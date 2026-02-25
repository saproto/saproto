<?php

namespace App\Http\Controllers;

use App\Mail\ActivityMovedFromBackup;
use App\Mail\ActivitySubscribedTo;
use App\Mail\ActivityUnsubscribedFrom;
use App\Models\Activity;
use App\Models\ActivityParticipation;
use App\Models\Event;
use App\Models\User;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class ParticipationController extends Controller
{
    /**
     * @return RedirectResponse
     */
    public function create(Event $event, Request $request)
    {
        abort_if(! $event->activity, 403, $event->title.' does not have a signup.');
        abort_if($event->activity->closed, 403, 'This activity is closed, you cannot change participation anymore.');

        $data = ['activity_id' => $event->activity->id, 'user_id' => Auth::user()->id];

        //        if ($request->has('helping_committee_id')) {
        //            $helpingCommittee = HelpingCommittee::query()
        //                ->withCount('users')
        //                ->with(
        //                    'committee.users'
        //                )
        //                ->findOrFail($request->input('helping_committee_id'));
        //            abort_unless($event->activity->getHelperParticipation(Auth::user(), $helpingCommittee) === null, 403, 'You are already helping at '.$event->title.'.');
        //
        //            abort_unless($helpingCommittee->committee->isMember(Auth::user()), 403, 'You are not a member of the '.$helpingCommittee->committee.' and thus cannot help on behalf of it.');
        //            abort_if($helpingCommittee->users_count >= $helpingCommittee->amount, 403, 'There are already enough people of your committee helping, thanks though!');
        //
        //            $data['committees_activities_id'] = $helpingCommittee->id;
        //            ActivityParticipation::query()->create($data);
        //
        //            return back();
        //        }

        abort_if($event->activity->isParticipating(Auth::user()), 403, 'You are already subscribed for '.$event->title.'.');
        abort_unless($event->activity->canSubscribeBackup(), 403, 'You cannot subscribe for '.$event->title.' at this time.');

        if ($event->activity->isFull() || ! $event->activity->canSubscribe()) {
            Session::flash('flash_message', 'You have been placed on the back-up list for '.$event->title.'.');
            $data['backup'] = true;
        } else {
            Session::flash('flash_message', 'You claimed a spot for '.$event->title.'.');
        }

        ActivityParticipation::query()->create($data);
        $event->updateUniqueUsersCount();

        if ($event->activity->redirect_url) {
            return Redirect::to($event->activity->redirect_url);
        }

        return back();
    }

    public function createFor(Event $event, Request $request): RedirectResponse
    {
        abort_if(! $event->activity, 403, $event->title.' does not have a signup.');
        abort_if($event->activity->closed, 403, 'This activity is closed, you cannot change participation anymore.');

        $user = User::query()->findOrFail($request->input('user_id'));

        $data = ['activity_id' => $event->activity->id, 'user_id' => $user->id];

        abort_unless($user->is_member, 403, $user->name.' is not a member of the association and therefore can not be subscribed for '.$event->title.'.');
        abort_if($event->activity->isParticipating($user), 403, $user->name.' is already subscribed for '.$event->title.'.');

        //        if ($request->has('helping_committee_id')) {
        //            $helping = HelpingCommittee::query()->findOrFail($request->input('helping_committee_id'));
        //            abort_unless($event->activity->getHelperParticipation($user, $helping) === null, 403, $user->name.' is already helping at '.$event->title.' for the '.$helping->committee->name.'.');
        //            abort_unless($helping->committee->isMember($user), 403, $user->name.' is not a member of the '.$helping->committee->name.' and thus cannot help on behalf of it.');
        //
        //            $data['committees_activities_id'] = $helping->id;
        //        } else {
        //
        //        }

        $participation = ActivityParticipation::query()->create($data);

        $event->updateUniqueUsersCount();

        Session::flash('flash_message', 'You added '.$user->name.' for '.$event->title.'.');

        Mail::to($participation->user)->queue(new ActivitySubscribedTo($participation, $helping->committee->name ?? null)->onQueue('high'));

        return back();
    }

    /**
     * @throws Exception
     */
    public function destroy(ActivityParticipation $participation): RedirectResponse
    {
        $participation->load(['activity', 'activity.event', 'user']);

        abort_unless($participation->user->id == Auth::id() || Auth::user()->can('board'), 403, 'You are not allowed to unsubscribe this user from this event.');

        //        // always allow deleting of helper participation
        //        if ($participation->committees_activities_id !== null) {
        //            $participation->delete();
        //            Session::flash('flash_message', $participation->user->name.' is not helping with '.$participation->activity->event->title.' anymore.');
        //            $participation->activity->event->updateUniqueUsersCount();
        //
        //            return back();
        //        }

        abort_if($participation->activity->closed, 403, 'This activity is closed, you cannot change participation anymore.');

        abort_unless($participation->backup || $participation->activity->canUnsubscribe() || Auth::user()->can('board'), 403, 'You cannot unsubscribe for this event at this time.');

        if ($participation->user->id !== Auth::id()) {
            Mail::to($participation->user)->queue(new ActivityUnsubscribedFrom($participation)->onQueue('high'));
        }

        $participation->delete();

        Session::flash('flash_message', $participation->user->name.' is not attending '.$participation->activity->event->title.' anymore.');

        if (! $participation->backup && $participation->activity->users()->count() < $participation->activity->participants) {
            self::transferOneBackupUser($participation->activity);
        }

        $participation->activity->event->updateUniqueUsersCount();

        return back();
    }

    /**
     * @return JsonResponse
     */
    public function togglePresence(ActivityParticipation $participation)
    {
        abort_unless($participation->activity->event->isEventAdmin(Auth::user()), 403, 'You are not an organizer for this event.');

        $participation->update(['is_present' => ! $participation->is_present]);

        return new JsonResponse($participation->activity->getPresent());
    }

    public static function processBackupQueue(Activity $activity): void
    {
        while ($activity->backupUsers()->count() > 0 && $activity->users()->count() < $activity->participants) {
            self::transferOneBackupUser($activity);
        }
    }

    public static function transferOneBackupUser(Activity $activity): void
    {
        $backup_participation = ActivityParticipation::query()->where('activity_id', $activity->id)
            ->where('backup', true)
            ->with('activity.event')
            ->with('user')
            ->first();

        if ($backup_participation == null) {
            return;
        }

        $backup_participation->update(['backup' => false]);

        $backup_participation->activity->event->updateUniqueUsersCount();

        Mail::to($backup_participation->user)->queue(new ActivityMovedFromBackup($backup_participation)->onQueue('high'));
    }
}
