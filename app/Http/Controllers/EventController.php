<?php

namespace Proto\Http\Controllers;

use Illuminate\Http\Request;

use Proto\Http\Requests;
use Proto\Http\Controllers\Controller;
use Proto\Models\Event;

use Auth;

class EventController extends Controller
{
    /**
     * Display a listing of upcoming activites.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $events = Event::all();
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
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified event.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return view('event.display', ['event' => Event::findOrFail($id)]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }


    public function apiEvents(Request $request)
    {

        if (!Auth::check() || !Auth::user()->member) {
            abort(403);
        }

        $events = Event::all();
        $data = array();

        foreach ($events as $event) {
            $item = new \stdClass();
            $item->id = $event->id;
            $item->title = $event->title;
            $item->description = $event->description;
            $item->start = $event->start;
            $item->end = $event->end;
            $item->location = $event->location;
            $data[] = $item;
        }

        return $data;

    }

    public function apiEventsSingle($id, Request $request)
    {

        if (!Auth::check() || !Auth::user()->member) {
            abort(403);
        }

        $event = Event::findOrFail($id);

        $item = new \stdClass();
        $item->id = $event->id;
        $item->title = $event->title;
        $item->description = $event->description;
        $item->start = $event->start;
        $item->end = $event->end;
        $item->location = $event->location;

        return (array) $item;

    }

}
