<?php

namespace Proto\Http\Controllers;

use Illuminate\Http\Request;

use Proto\Http\Requests;
use Proto\Http\Controllers\Controller;
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
     * @return \Illuminate\Http\Response
     */
    public function save(Request $request, $id)
    {
        $event = Event::findOrFail($id);

        $new = $event->activity === null;
        $activity = ($new ? new Activity() : $event->activity);

        $data = [
            'registration_start' => strtotime($request->registration_start),
            'registration_end' => strtotime($request->registration_end),
            'deregistration_end' => strtotime($request->deregistration_end),
            'participants' => ($request->participants == 0 ? null : $request->participants),
            'price' => $request->price
        ];

        if (!$activity->validate($data)) {
            return Redirect::route('event::edit', ['id' => $event->id])->withErrors($activity->errors());
        }

        $activity->fill($data);

        $activity->save();

        if ($new) {
            $activity->event()->associate($event);
            $activity->save();
        }

        $request->session()->flash('flash_message', 'Your changes have been saved.');

        return Redirect::route('event::edit', ['id' => $event->id]);

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
            'amount' => $amount
        ]);

        foreach ($committee->users as $user) {
            Mail::send('emails.committeehelpneeded', ['user' => $user, 'help' => $help], function ($m) use ($user, $help) {
                $m->replyTo('board@proto.utwente.nl', 'S.A. Proto');
                $m->to($user->email, $user->name);
                $m->subject('The activity ' . $help->activity->event->title . ' needs your help.');
            });
        }

        $request->session()->flash('flash_message', 'Added ' . $committee->name . ' as helping committee.');
        return Redirect::back();
    }

    public function deleteHelp(Request $request, $id)
    {
        $help = HelpingCommittee::findOrFail($id);

        foreach ($help->users as $user) {
            Mail::send('emails.committeehelpnotneeded', ['user' => $user, 'help' => $help], function ($m) use ($user, $help) {
                $m->replyTo('board@proto.utwente.nl', 'S.A. Proto');
                $m->to($user->email, $user->name);
                $m->subject('The activity ' . $help->activity->event->title . ' doesn\'t need your help anymore.');
            });
        }

        foreach (ActivityParticipation::withTrashed()->where('committees_activities_id', $help->id)->get() as $participation) {
            $participation->delete();
        }

        $help->delete();
        $request->session()->flash('flash_message', 'Removed ' . $help->committee->name . ' as helping committee.');
        return Redirect::back();
    }

}
