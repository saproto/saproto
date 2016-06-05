<?php

namespace Proto\Http\Controllers;

use Illuminate\Http\Request;
use Proto\Http\Controllers\Controller;

use Proto\Models\ActivityParticipation;
use Proto\Models\Event;
use Proto\Models\HelpingCommittee;

use Redirect;
use Auth;

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
        } elseif ($event->activity->registration_start > date('U') || $event->activity->registration_end < date('U')) {
            abort(500, "You cannot subscribe for " . $event->title . " at this time.");
        }

        $data = ['activity_id' => $event->activity->id, 'user_id' => Auth::user()->id];

        if ($request->has('helping_committee_id')) {
            $helping = HelpingCommittee::findOrFail($request->helping_committee_id);
            if (!$helping->committee->isMember(Auth::user())) {
                abort(500, "You are not a member of the " . $helping->committee . " and thus cannot help on behalf of it.");
            }
            $data['committees_activities_id'] = $helping->id;
        }

        $participation = new ActivityParticipation();
        $participation->fill($data);
        $participation->save();

        $request->session()->flash('flash_message', ($participation->user->id == Auth::id() ? 'You have' : $participation->user->name . 'has') . " been added to " . $participation->activity->event->title . ".");
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
        if ($participation->user->id == Auth::id() || Auth::user()->can('board')) {
            if ($participation->activity->registration_end < date('U') && !Auth::user()->can('board')) {
                abort(500, "You cannot unsubscribe for this event at this time.");
            }
            $request->session()->flash('flash_message', ($participation->user->id == Auth::id() ? 'You have' : $participation->user->name . 'has') . " been removed from " . $participation->activity->event->title . ".");
            $participation->delete();
            return Redirect::back();
        } else {
            abort(403);
        }
    }
}
