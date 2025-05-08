<?php

namespace App\Http\Controllers;

use App\Mail\ActivityMovedFromBackup;
use App\Mail\ActivitySubscribedTo;
use App\Mail\ActivityUnsubscribedFrom;
use App\Models\Activity;
use App\Models\ActivityParticipation;
use App\Models\Event;
use App\Models\HelpingCommittee;
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
    public function create(int $id, Request $request)
    {
        /** @var Event $event */
        $event = Event::query()->findOrFail($id);
        if (! $event->activity) {
            abort(403, 'You cannot subscribe for '.$event->title.'.');
        }

        if ($request->has('helping_committee_id') && $event->activity->getHelperParticipation(Auth::user(), HelpingCommittee::query()->findOrFail($request->input('helping_committee_id'))) !== null) {
            abort(403, 'You are helping at '.$event->title.'.');
        } elseif (! $request->has('helping_committee_id') && $event->activity->getParticipation(Auth::user()) !== null) {
            abort(403, 'You are already subscribed for '.$event->title.'.');
        } elseif (! $request->has('helping_committee_id') && (! $event->activity->canSubscribeBackup())) {
            abort(403, 'You cannot subscribe for '.$event->title.' at this time.');
        } elseif ($event->activity->closed) {
            abort(403, 'This activity is closed, you cannot change participation anymore.');
        }

        $data = ['activity_id' => $event->activity->id, 'user_id' => Auth::user()->id];

        if ($request->has('helping_committee_id')) {
            $helping = HelpingCommittee::query()->findOrFail($request->helping_committee_id);
            if (! $helping->committee->isMember(Auth::user())) {
                abort(403, 'You are not a member of the '.$helping->committee.' and thus cannot help on behalf of it.');
            }

            if ($helping->users->count() >= $helping->amount) {
                abort(403, 'There are already enough people of your committee helping, thanks though!');
            }

            $data['committees_activities_id'] = $helping->id;
        } elseif ($event->activity->isFull() || ! $event->activity->canSubscribe()) {
            Session::flash('flash_message', 'You have been placed on the back-up list for '.$event->title.'.');
            $data['backup'] = true;
        } else {
            Session::flash('flash_message', 'You claimed a spot for '.$event->title.'.');
        }

        $participation = new ActivityParticipation;
        $participation->fill($data);
        $participation->save();

        $event->updateUniqueUsersCount();

        if ($event->activity->redirect_url) {
            return Redirect::to($event->activity->redirect_url);
        }

        return Redirect::back();
    }

    /**
     * @return RedirectResponse
     */
    public function createFor(int $id, Request $request)
    {
        /** @var Event $event */
        $event = Event::query()->findOrFail($id);
        $user = User::query()->findOrFail($request->user_id);

        $data = ['activity_id' => $event->activity->id, 'user_id' => $user->id];

        if ($request->has('helping_committee_id')) {
            $helping = HelpingCommittee::query()->findOrFail($request->helping_committee_id);
            if (! $helping->committee->isMember($user)) {
                abort(403, $user->name.' is not a member of the '.$helping->committee->name.' and thus cannot help on behalf of it.');
            }

            $data['committees_activities_id'] = $helping->id;
        }

        if (! $event->activity) {
            abort(403, 'You cannot subscribe for '.$event->title.'.');
        } elseif ($event->activity->closed) {
            abort(403, 'This activity is closed, you cannot change participation anymore.');
        } elseif ($request->has('helping_committee_id') && $event->activity->getHelperParticipation($user, HelpingCommittee::query()->findOrFail($request->input('helping_committee_id'))) !== null) {
            abort(403, 'You are helping at '.$event->title.'.');
        } elseif (! $request->has('helping_committee_id') && $event->activity->getParticipation($user) !== null) {
            abort(403, 'You are already subscribed for '.$event->title.'.');
        }

        Session::flash('flash_message', 'You added '.$user->name.' for '.$event->title.'.');

        $participation = ActivityParticipation::query()->create($data);

        if (! isset($data['committees_activities_id']) || ! $data['committees_activities_id']) {
            $event->updateUniqueUsersCount();
        }

        $help_committee = ($helping->committee->name ?? null);

        Mail::to($participation->user)->queue((new ActivitySubscribedTo($participation, $help_committee))->onQueue('high'));

        return Redirect::back();
    }

    /**
     * @return RedirectResponse
     *
     * @throws Exception
     */
    public function destroy(int $participation_id)
    {
        /** @var ActivityParticipation|null $participation */
        $participation = ActivityParticipation::query()->with('activity', 'activity.event', 'user')->findorFail($participation_id);

        abort_unless($participation->user->id == Auth::id() || Auth::user()->can('board'), 403, 'You are not allowed to unsubscribe this user from this event.');

        if ($participation->committees_activities_id !== null) {

            $message = $participation->user->name.' is not helping with '.$participation->activity->event->title.' anymore.';
            Session::flash('flash_message', $message);

            $participation->delete();
            $participation->activity->event->updateUniqueUsersCount();

            return Redirect::back();
        }

        if ($participation->activity->closed) {
            abort(403, 'This activity is closed, you cannot change participation anymore.');
        }

        if (! $participation->activity->canUnsubscribe() && ! $participation->backup && ! Auth::user()->can('board')) {
            abort(403, 'You cannot unsubscribe for this event at this time.');
        }

        if ($participation->user->id != Auth::id()) {
            Mail::to($participation->user)->queue((new ActivityUnsubscribedFrom($participation))->onQueue('high'));
        }

        Session::flash('flash_message', $participation->user->name.' is not attending '.$participation->activity->event->title.' anymore.');

        $participation->delete();

        if (! $participation->backup && $participation->activity->users()->count() < $participation->activity->participants) {
            self::transferOneBackupUser($participation->activity);
        }

        $participation->activity->event->updateUniqueUsersCount();

        return Redirect::back();
    }

    /**
     * @return JsonResponse
     */
    public function togglePresence(int $participation_id)
    {
        /** @var ActivityParticipation $participation */
        $participation = ActivityParticipation::query()->findOrFail($participation_id);

        if (! $participation->activity->event->isEventAdmin(Auth::user())) {
            abort(403, 'You are not an organizer for this event.');
        }

        $participation->is_present = ! $participation->is_present;
        $participation->save();

        return response()->json($participation->activity->getPresent());
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
            ->whereNull('committees_activities_id')->where('backup', true)
            ->with('user', 'activity.event')
            ->first();

        if ($backup_participation !== null) {
            $backup_participation->backup = false;
            $backup_participation->save();

            $backup_participation->activity->event->updateUniqueUsersCount();

            Mail::to($backup_participation->user)->queue((new ActivityMovedFromBackup($backup_participation))->onQueue('high'));
        }
    }
}
