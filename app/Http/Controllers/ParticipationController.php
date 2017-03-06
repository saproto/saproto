<?php

namespace Proto\Http\Controllers;

use Illuminate\Http\Request;
use Proto\Http\Controllers\Controller;

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
            abort(500, "You cannot subscribe for " . $event->title . ".");
        } elseif ($event->activity->getParticipation(Auth::user(), ($request->has('helping_committee_id') ? HelpingCommittee::findOrFail($request->input('helping_committee_id')) : null)) !== null) {
            abort(500, "You are already subscribed for " . $event->title . ".");
        } elseif (!$request->has('helping_committee_id') && (!$event->activity->canSubscribeBackup())) {
            abort(500, "You cannot subscribe for " . $event->title . " at this time.");
        } elseif ($event->activity->closed) {
            abort(500, "This activity is closed, you cannot change participation anymore.");
        }

        $data = ['activity_id' => $event->activity->id, 'user_id' => Auth::user()->id];

        if ($request->has('helping_committee_id')) {
            $helping = HelpingCommittee::findOrFail($request->helping_committee_id);
            if (!$helping->committee->isMember(Auth::user())) {
                abort(500, "You are not a member of the " . $helping->committee . " and thus cannot help on behalf of it.");
            }
            if ($helping->users->count() >= $helping->amount) {
                abort(500, "There are already enough people of your committee helping, thanks though!");
            }
            $data['committees_activities_id'] = $helping->id;
        } else {
            if ($event->activity->isFull() || !$event->activity->canSubscribe()) {
                $request->session()->flash('flash_message', 'You have been placed on the back-up list for ' . $event->title . '.');
                $data['backup'] = true;
            } else {
                $request->session()->flash('flash_message', 'You claimed a spot for ' . $event->title . '.');
            }
        }

        $participation = new ActivityParticipation();
        $participation->fill($data);
        $participation->save();

        return Redirect::back();

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
                abort(500, $user->name . " is not a member of the " . $helping->committee->name . " and thus cannot help on behalf of it.");
            }
            $data['committees_activities_id'] = $helping->id;
        }

        if (!$event->activity) {
            abort(500, "You cannot subscribe for " . $event->title . ".");
        } elseif ($event->activity->getParticipation($user, ($request->has('helping_committee_id') ? HelpingCommittee::findOrFail($request->input('helping_committee_id')) : null)) !== null) {
            abort(500, "You are already subscribed for " . $event->title . ".");
        } elseif ($event->activity->closed) {
            abort(500, "This activity is closed, you cannot change participation anymore.");
        }

        $request->session()->flash('flash_message', 'You added ' . $user->name . ' for ' . $event->title . '.');

        $participation = new ActivityParticipation();
        $participation->fill($data);
        $participation->save();

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


        if ($participation->committees_activities_id === null) {

            if ($participation->activity->closed) {
                abort(500, "This activity is closed, you cannot change participation anymore.");
            }

            if (!$participation->activity->canUnsubscribe() && !$participation->backup && !Auth::user()->can('board')) {
                abort(500, "You cannot unsubscribe for this event at this time.");
            }

            $backupparticipation = ($participation->backup ? null : ActivityParticipation::where('activity_id', $participation->activity->id)
                ->whereNull('committees_activities_id')->where('backup', true)
                ->first());
            if ($backupparticipation !== null) {
                $backupparticipation->backup = false;
                $backupparticipation->save();

                $name = $backupparticipation->user->name;
                $email = $backupparticipation->user->email;
                $activitytitle = $backupparticipation->activity->event->title;

                Mail::queueOn('high', 'emails.takenfrombackup', ['participation' => $backupparticipation], function ($m) use ($name, $email, $activitytitle) {
                    $m->replyTo('board@proto.utwente.nl', 'S.A. Proto');
                    $m->to($email, $name);
                    $m->subject('Moved from back-up list to participants for ' . $activitytitle . '.');
                });
            }

            if ($notify) {

                $name = $participation->user->name;
                $email = $participation->user->email;
                $activitytitle = $participation->activity->event->title;

                Mail::queueOn('high', 'emails.unsubscribeactivity', ['activity' => [
                    'id' => $participation->activity->event->id,
                    'title' => $activitytitle,
                    'name' => $participation->user->calling_name
                ]], function ($m) use ($name, $email, $activitytitle) {
                    $m->replyTo('board@proto.utwente.nl', 'S.A. Proto');
                    $m->to($email, $name);
                    $m->subject('You have been signed out for ' . $activitytitle . '.');
                });

            }

            $request->session()->flash('flash_message', $participation->user->name . ' is not attending ' . $participation->activity->event->title . ' anymore.');

            $participation->delete();

        } else {

            $request->session()->flash('flash_message', $participation->user->name . ' is not helping with ' . $participation->activity->event->title . ' anymore.');

            if ($notify) {

                $name = $participation->user->name;
                $email = $participation->user->email;
                $activitytitle = $participation->activity->event->title;

                Mail::queueOn('high', 'emails.unsubscribehelpactivity', ['participation' => $participation], function ($m) use ($name, $email, $activitytitle) {
                    $m->from('board@proto.utwente.nl', 'S.A. Proto');
                    $m->to($email, $name);
                    $m->subject('You don\'t help with ' . $activitytitle . ' anymore.');
                });

            }

            $participation->delete();

        }

        return Redirect::back();

    }

    public function checklist($id)
    {
        $event = Event::findOrFail($id);
        return view('event.checklist', ['event' => $event]);
    }
}
