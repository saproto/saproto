<?php

namespace Proto\Http\Controllers;

use Illuminate\Http\Request;

use Proto\Http\Requests;
use Proto\Http\Controllers\Controller;
use Proto\Models\Activity;
use Proto\Models\Event;

use Redirect;

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
            abort(500, "There is no participation data to delete.");
        } elseif (count($event->activity->users()) > 0) {
            abort(500, "You cannot delete participation data because there are still participants to this activity.");
        }

        $event->activity()->delete();

        $request->session()->flash('flash_message', 'Participation data deleted.');

        return Redirect::route('event::edit', ['id' => $event->id]);
    }
}
