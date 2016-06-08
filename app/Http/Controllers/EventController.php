<?php

namespace Proto\Http\Controllers;

use Illuminate\Http\Request;

use Proto\Http\Requests;
use Proto\Http\Controllers\Controller;
use Proto\Models\Event;

use Session;
use Redirect;

class EventController extends Controller
{
    /**
     * Display a listing of upcoming activites.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $events = Event::orderBy('start')->get();
        $data = [[], [], []];
        $years = [];

        foreach ($events as $event) {
            if ((!$event->activity || !$event->activity->secret) && $event->end > date('U')) {
                $delta = $event->start - date('U');
                if ($delta < 3600 * 24 * 7) {
                    $data[0][] = $event;
                } elseif ($delta < 3600 * 24 * 21) {
                    $data[1][] = $event;
                } else {
                    $data[2][] = $event;
                }
            }
            if (!in_array(date('Y', $event->start), $years)) {
                $years[] = date('Y', $event->start);
            }
        }

        return view('event.calendar', ['events' => $data, 'years' => $years]);
    }

    /**
     * Display a listing of activities in a year.
     *
     * @return \Illuminate\Http\Response
     */
    public function archive($year)
    {
        $events = Event::where('start', '>', strtotime($year . "-01-01 00:00:01"))->where('start', '<', strtotime($year . "-12-31 23:59:59"))->get();
        $months = [];
        for ($i = 1; $i <= 12; $i++) {
            $months[$i] = [];
        }

        foreach ($events as $event) {
            if (!$event->activity || !$event->activity->secret) {
                $months[intval(date('n', $event->start))][] = $event;
            }
        }

        return view('event.archive', ['year' => $year, 'months' => $months]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('event.edit', ['event' => null]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $event = new Event();
        $event->title = $request->title;
        $event->start = strtotime($request->start);
        $event->end = strtotime($request->end);
        $event->location = $request->location;

        $event->save();

        Session::flash("flash_message", "Your event '" . $event->title . "' has been added.");
        return Redirect::route('event::show', ['id' => $event->id]);

    }

    /**
     * Display the specified event.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $event = Event::findOrFail($id);
        return view('event.display', ['event' => $event]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $event = Event::findOrFail($id);
        return view('event.edit', ['event' => $event]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        $event = Event::findOrFail($id);
        $event->title = $request->title;
        $event->start = strtotime($request->start);
        $event->end = strtotime($request->end);
        $event->location = $request->location;

        $event->save();

        Session::flash("flash_message", "Your event '" . $event->title . "' has been saved.");
        return Redirect::route('event::show', ['id' => $event->id]);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $event = Event::findOrFail($id);

        if ($event->activity !== null) {
            Session::flash("flash_message", "You cannot delete event '" . $event->title . "' since it has a participation details.");
            return Redirect::back();
        }

        Session::flash("flash_message", "The event '" . $event->title . "' has been deleted.");

        $event->delete();

        return Redirect::route('event::list');
    }
}
