<?php

namespace Proto\Http\Controllers;

use Illuminate\Http\Request;

use Proto\Mail\CommitteeHelpNeeded;
use Proto\Mail\CommitteeHelpNotNeeded;
use Proto\Models\Activity;
use Proto\Models\ActivityParticipation;
use Proto\Models\Committee;
use Proto\Models\Event;

use Proto\Models\HelpingCommittee;
use Redirect;

use Auth;
use Mail;

class ActivityController extends Controller
{

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function save(Request $request, $id)
    {
        $event = Event::findOrFail($id);

        $new = $event->activity === null;
        $activity = ($new ? new Activity() : $event->activity);

        $newprice = floatval(str_replace(',', '.', $request->price));
        $newnoshow = floatval(str_replace(',', '.', $request->no_show_fee));

        if ($newnoshow > floatval($activity->no_show_fee) && $activity->users->count() > 0) {
            return response()->json(["message" => 'You cannot make the no show fee higher since this activity already has participants.'], 400);
        } elseif ($newnoshow < 0) {
            return response()->json(['message' => 'The no show fee should be a positive amount.'], 400);
        }

        if ($newprice > floatval($activity->price) && $activity->users->count() > 0) {
            return response()->json(['message' => 'You cannot make the price of this activity higher since this activity already has participants.'], 400);
        }

        $data = [
            'registration_start' => strtotime($request->registration_start),
            'registration_end' => strtotime($request->registration_end),
            'deregistration_end' => strtotime($request->deregistration_end),
            'participants' => $request->participants,
            'price' => $newprice,
            'no_show_fee' => $newnoshow
        ];

        if (!$activity->validate($data)) {
            return response()->json(['message' => $activity->errors()], 400);
//            return Redirect::route('event::edit', ['id' => $event->id])->withErrors($activity->errors());
        }

        $activity->fill($data);

        $activity->save();

        if ($new) {
            $activity->event()->associate($event);
            $activity->save();
        }

        ParticipationController::processBackupQueue($activity);

        return response()->json(["message" => "Your changes to this event's sign-up have been saved"]);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request, $id)
    {
        $event = Event::findOrFail($id);

        if (!$event->activity) {
            $request->session()->flash('flash_message', "There is no participation data to delete.");
            return Redirect::back();
        } elseif (count($event->activity->users) > 0) {
            $request->session()->flash('flash_message', "You cannot delete participation data because there are still participants to this activity.");
            return Redirect::back();
        }

        ActivityParticipation::withTrashed()->where('activity_id', $event->activity->id)->forceDelete();

        $event->activity->delete();

        $request->session()->flash('flash_message', 'Participation data deleted.');

        return Redirect::route('event::edit', ['id' => $event->id]);
    }

    public function checklist($id)
    {
        $event = Event::findOrFail($id);
        if (!Auth::check() || !(Auth::user()->can('board') || $event->isEventAdmin(Auth::user()))) {
            abort(403, 'You may not see this page.');
        }
        if (!$event->activity) {
            abort(404, 'This event has no activity.');
        }
        return view('event.checklist', ['event' => $event]);
    }

    public function addHelp(Request $request, $id)
    {
        $event = Event::findOrFail($id);
        if (!$event->activity) {
            $request->session()->flash('flash_message', 'This event has no activity data.');
            return Redirect::back();
        }

        $amount = $request->input('amount');
        if ($amount < 1) {
            $request->session()->flash('flash_message', 'The amount of helpers should be positive.');
            return Redirect::back();
        }

        $committee = Committee::findOrFail($request->input('committee'));

        $help = HelpingCommittee::create([
            'activity_id' => $event->activity->id,
            'committee_id' => $committee->id,
            'amount' => $amount,
            'notification_sent' => false
        ]);

        $request->session()->flash('flash_message', 'Added ' . $committee->name . ' as helping committee.');
        return Redirect::back();
    }

    public function updateHelp(Request $request, $id)
    {
        $help = HelpingCommittee::findOrFail($id);
        $amount = $request->input('amount');
        $oldamount = $help->amount;

        $help->amount = ($amount > 0 ? $amount : $help->amount);
        $help->notification_sent = false;
        $help->save();

        $request->session()->flash('flash_message', 'Updated ' . $help->committee->name . ' as helping committee.');
        return Redirect::back();
    }

    public function deleteHelp(Request $request, $id)
    {
        $help = HelpingCommittee::findOrFail($id);

        foreach (ActivityParticipation::withTrashed()->where('committees_activities_id', $help->id)->get() as $participation) {
            $participation->delete();
        }

        $help->delete();
        $request->session()->flash('flash_message', 'Removed ' . $help->committee->name . ' as helping committee.');
        return Redirect::back();
    }

}
