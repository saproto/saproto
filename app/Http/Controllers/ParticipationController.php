<?php

namespace Proto\Http\Controllers;

use Illuminate\Http\Request;
use Proto\Http\Controllers\Controller;

use Proto\Mail\ActivityMovedFromBackup;
use Proto\Mail\ActivitySubscribedTo;
use Proto\Mail\ActivityUnsubscribedFrom;
use Proto\Mail\ActivityUnsubscribedToHelp;
use Proto\Mail\HelperMutation;
use Proto\Models\Activity;
use Proto\Models\ActivityParticipation;
use Proto\Models\Committee;
use Proto\Models\Event;
use Proto\Models\HelpingCommittee;
use Proto\Models\User;

use Redirect;
use Auth;
use Mail;

class ParticipationController extends Controller
{
    /**
     * Create a new participation.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id, Request $request)
    {
        $event = Event::findOrFail($id);
        if (!$event->activity) {
            abort(403, "You cannot subscribe for " . $event->title . ".");
        } elseif ($event->activity->getParticipation(Auth::user(), ($request->has('helping_committee_id') ? HelpingCommittee::findOrFail($request->input('helping_committee_id')) : null)) !== null) {
            abort(403, "You are already subscribed for " . $event->title . ".");
        } elseif (!$request->has('helping_committee_id') && (!$event->activity->canSubscribeBackup())) {
            abort(403, "You cannot subscribe for " . $event->title . " at this time.");
        } elseif ($event->activity->closed) {
            abort(403, "This activity is closed, you cannot change participation anymore.");
        }

        $data = ['activity_id' => $event->activity->id, 'user_id' => Auth::user()->id];

        $is_web = Auth::guard('web')->user();

        if ($request->has('helping_committee_id')) {
            $helping = HelpingCommittee::findOrFail($request->helping_committee_id);
            if (!$helping->committee->isMember(Auth::user())) {
                abort(403, "You are not a member of the " . $helping->committee . " and thus cannot help on behalf of it.");
            }
            if ($helping->users->count() >= $helping->amount) {
                abort(403, "There are already enough people of your committee helping, thanks though!");
            }
            $data['committees_activities_id'] = $helping->id;
            Mail::queue((new HelperMutation(Auth::user(), $helping, true))->onQueue('medium'));
        } elseif($is_web) {
            if ($event->activity->isFull() || !$event->activity->canSubscribe()) {
                $request->session()->flash('flash_message', 'You have been placed on the back-up list for ' . $event->title . '.');
                $data['backup'] = true;
            } else {
                $request->session()->flash('flash_message', 'You claimed a spot for ' . $event->title . '.');
            }
        } else {
            if ($event->activity->isFull() || !$event->activity->canSubscribe()) {
                $data['backup'] = true;
            }
        }

        $participation = new ActivityParticipation();
        $participation->fill($data);
        $participation->save();

        if($is_web) {
            return Redirect::back();
        } else {
            if ($event->activity->isFull() || !$event->activity->canSubscribe()) {
                abort(200, 'You have been placed on the back-up list for ' . $event->title . '.');
            } else {
                abort(200, 'You claimed a spot for ' . $event->title . '.');
            }
        }

    }

    /**
     * Create a new participation for somebody else.
     *
     * @return \Illuminate\Http\Response
     */
    public function createFor($id, Request $request)
    {
        $user = User::findOrFail($request->user_id);
        $event = Event::findOrFail($id);

        $data = ['activity_id' => $event->activity->id, 'user_id' => $user->id];

        if ($request->has('helping_committee_id')) {
            $helping = HelpingCommittee::findOrFail($request->helping_committee_id);
            if (!$helping->committee->isMember($user)) {
                abort(403, $user->name . " is not a member of the " . $helping->committee->name . " and thus cannot help on behalf of it.");
            }
            $data['committees_activities_id'] = $helping->id;
            Mail::queue((new HelperMutation($user, $helping, true))->onQueue('medium'));
        }

        if (!$event->activity) {
            abort(403, "You cannot subscribe for " . $event->title . ".");
        } elseif ($event->activity->getParticipation($user, ($request->has('helping_committee_id') ? HelpingCommittee::findOrFail($request->input('helping_committee_id')) : null)) !== null) {
            abort(403, "You are already subscribed for " . $event->title . ".");
        } elseif ($event->activity->closed) {
            abort(403, "This activity is closed, you cannot change participation anymore.");
        }

        $request->session()->flash('flash_message', 'You added ' . $user->name . ' for ' . $event->title . '.');

        $participation = new ActivityParticipation();
        $participation->fill($data);
        $participation->save();

        $helpcommittee = ($request->has('helping_committee_id') ? $helping->committee->name : null);

        Mail::to($participation->user)->queue((new ActivitySubscribedTo($participation, $helpcommittee))->onQueue('high'));

        return Redirect::back();

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id The id of the participation to be removed.
     * @return \Illuminate\Http\Response
     */
    public function destroy($participation_id, Request $request)
    {
        $participation = ActivityParticipation::findOrFail($participation_id);

        $notify = false;

        if ($participation->user->id != Auth::id()) {
            if (!Auth::user()->can('board')) {
                abort(403);
            }
            $notify = true;
        }

        $is_web = Auth::guard('web')->user();

        if ($participation->committees_activities_id === null) {

            if ($participation->activity->closed) {
                abort(403, "This activity is closed, you cannot change participation anymore.");
            }

            if (!$participation->activity->canUnsubscribe() && !$participation->backup && !Auth::user()->can('board')) {
                abort(403, "You cannot unsubscribe for this event at this time.");
            }

            if ($notify) {
                Mail::to($participation->user)->queue((new ActivityUnsubscribedFrom($participation))->onQueue('high'));
            }

            $message = $participation->user->name . ' is not attending ' . $participation->activity->event->title . ' anymore.';
            if ($is_web) {
                $request->session()->flash('flash_message', $message);
            }

            $participation->delete();

            if ($participation->backup == false) {
                ParticipationController::transferOneBackupUser($participation->activity);
            }

        } else {

            $message = $participation->user->name . ' is not helping with ' . $participation->activity->event->title . ' anymore.';
            if ($is_web) {
                $request->session()->flash('flash_message', $message);
            }

            if ($notify) {
                Mail::to($participation->user)->queue((new ActivityUnsubscribedToHelp($participation))->onQueue('high'));
            }

            Mail::queue((new HelperMutation($participation->user, $participation->help, false))
                    ->onQueue('medium'));

            $participation->delete();

        }

        if ($is_web) {
            return Redirect::back();
        } else {
            abort(200, $message);
        }

    }

    public function togglePresence($participation_id, Request $request)
    {
        $participation = ActivityParticipation::findOrFail($participation_id);

        if (!$participation->activity->event->isEventAdmin(Auth::user())) {
            abort(403, "You are not an organizer for this event.");
        }

        $participation->is_present = !$participation->is_present;
        $participation->save();

        return Redirect::back();
    }

    public static function processBackupQueue(Activity $activity)
    {

        while ($activity->backupUsers()->count() > 0 && $activity->users()->count() < $activity->participants) {

            ParticipationController::transferOneBackupUser($activity);

        }

    }

    public static function transferOneBackupUser(Activity $activity)
    {

        $backupparticipation = ActivityParticipation::where('activity_id', $activity->id)->whereNull('committees_activities_id')->where('backup', true)->first();

        if ($backupparticipation !== null) {
            $backupparticipation->backup = false;
            $backupparticipation->save();
            Mail::to($backupparticipation->user)->queue((new ActivityMovedFromBackup($backupparticipation))->onQueue('high'));
        }

    }
}
