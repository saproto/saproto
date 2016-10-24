<?php

namespace Proto\Http\Controllers;

use Illuminate\Http\Request;

use Proto\Http\Requests;
use Proto\Http\Controllers\Controller;
use Proto\Models\Account;
use Proto\Models\Activity;
use Proto\Models\Committee;
use Proto\Models\Event;
use Proto\Models\OrderLine;
use Proto\Models\Product;
use Proto\Models\StorageEntry;

use Session;
use Redirect;
use Auth;
use Response;
use Markdown;

use IcalCalendar;
use IcalEvent;
use IcalOrganizer;
use DateTime;

class EventController extends Controller
{
    /**
     * Display a listing of upcoming activites.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Auth::check() && Auth::user()->can('board')) {
            $events = Event::orderBy('start')->get();
        } else {
            $events = Event::where('secret', false)->orderBy('start')->get();
        }
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
     * Display a listing of all activities that still have to be closed.
     *
     * @return \Illuminate\Http\Response
     */
    public function finindex()
    {

        $activities = Activity::where('closed', false)->orderBy('registration_end', 'asc')->get();
        return view('event.notclosed', ['activities' => $activities]);
    }

    /**
     * Display a listing of activities in a year.
     *
     * @return \Illuminate\Http\Response
     */
    public function archive($year)
    {
        if (Auth::check() && Auth::user()->can('board')) {
            $events = Event::orderBy('start')->get();
        } else {
            $events = Event::where('secret', false)->orderBy('start')->get();
        }

        $months = [];
        $years = [];
        for ($i = 1; $i <= 12; $i++) {
            $months[$i] = [];
        }

        foreach ($events as $event) {
            if ($event->start > strtotime($year . "-01-01 00:00:01") && $event->end < strtotime($year . "-12-31 23:59:59")) {
                $months[intval(date('n', $event->start))][] = $event;
            }
            if (!in_array(date('Y', $event->start), $years)) {
                $years[] = date('Y', $event->start);
            }
        }

        return view('event.archive', ['years' => $years, 'year' => $year, 'months' => $months]);
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
        $event->secret = $request->secret;
        $event->description = $request->description;
        $event->summary = $request->summary;

        if ($request->file('image')) {
            $file = new StorageEntry();
            $file->createFromFile($request->file('image'));

            $event->image()->associate($file);
        }

        $committee = Committee::find($request->input('committee'));
        $event->committee()->associate($committee);

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
        $event->secret = $request->secret;
        $event->description = $request->description;
        $event->summary = $request->summary;

        if ($request->file('image')) {
            $file = new StorageEntry();
            $file->createFromFile($request->file('image'));

            $event->image()->associate($file);
        }

        $committee = Committee::find($request->input('committee'));
        $event->committee()->associate($committee);

        $event->save();

        Session::flash("flash_message", "Your event '" . $event->title . "' has been saved.");
        return Redirect::route('event::edit', ['id' => $event->id]);

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

    public function finclose(Request $request, $id)
    {

        $activity = Activity::findOrFail($id);

        if ($activity->event && !$activity->event->over()) {
            Session::flash("flash_message", "You cannot close an activity before it has finished.");
            return Redirect::back();
        }

        if ($activity->closed) {
            Session::flash("flash_message", "This activity is already closed.");
            return Redirect::back();
        }

        if (count($activity->users) == 0 || $activity->price == 0) {
            $activity->closed = true;
            $activity->save();
            Session::flash("flash_message", "This activity is now closed. It either was free or had no participants, so no orderlines or products were created.");
            return Redirect::back();
        }

        $account = Account::findOrFail($request->input('account'));

        $product = Product::create([
            'account_id' => $account->id,
            'name' => 'Activity: ' . ($activity->event ? $activity->event->title : $activity->comment),
            'nicename' => 'activity-' . $activity->id,
            'price' => $activity->price
        ]);
        $product->save();

        foreach ($activity->users as $user) {
            $order = OrderLine::create([
                'user_id' => $user->id,
                'product_id' => $product->id,
                'original_unit_price' => $product->price,
                'units' => 1,
                'total_price' => $product->price
            ]);
            $order->save();
        }

        $activity->closed = true;
        $activity->save();

        Session::flash("flash_message", "This activity has been closed and the relevant orderlines were added.");
        return Redirect::back();

    }


    public function apiUpcomingEvents($limit = 20)
    {

        $events = Event::where('secret', 0)->where('end', '>', strtotime('today'))->where('start', '<', strtotime('+1 month'))->orderBy('start', 'asc')->take($limit)->get();

        $data = [];

        foreach ($events as $event) {
            $data[] = (object)[
                'id' => $event->id,
                'title' => $event->title,
                'description' => $event->description,
                'start' => $event->start,
                'end' => $event->end,
                'location' => $event->location,
                'current' => $event->current(),
                'over' => $event->over()
            ];
        }

        return $data;

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

        if ($event->activity !== null) {
            $item->activity = new \stdClass();
            $item->activity->id = $event->activity->id;
            $item->activity->event_id = $event->activity->event_id;
            $item->activity->price = $event->activity->price;
            $item->activity->participants = $event->activity->participants;
            $item->activity->registration_start = $event->activity->registration_start;
            $item->activity->registration_end = $event->activity->registration_end;
            $item->activity->active = $event->activity->active;
            $item->activity->closed = $event->activity->closed;
            $item->activity->organizing_commitee = $event->activity->organizing_commitee;
        }

        return (array)$item;

    }

    public function apiEventsMembers($id, Request $request)
    {

        if (!Auth::check() || !Auth::user()->member) {
            abort(403);
        }

        $activities = Event::findOrFail($id)->activity->users;
        $data = array();

        foreach ($activities as $activity) {
            $item = new \stdClass();
            $item->id = $activity->id;
            $item->email = $activity->email;
            $item->name = $activity->name;
            $item->birthdate = $activity->birthdate;
            $item->gender = $activity->gender;
            $data[] = $item;
        }

        return $data;

    }

    public function icalCalendar(Request $request)
    {
        $calendar = new IcalCalendar('-//HYTTIOAOAc//S.A. Proto Calendar//EN');
        $calendar->setName('S.A. Proto Calendar');
        $calendar->setDescription('All of Proto\'s events and happenings, straight from the website!');
        $calendar->setCalendarColor('#C1FF00');
        $calendar->setCalendarScale('GREGORIAN');
        $calendar->setMethod('PUBLISH');

        foreach (Event::where('secret', false)->where('start', '>', strtotime('-6 months'))->get() as $event) {

            $infotext = '';
            if ($event->over()) {
                $infotext = 'This activity is over.';
            } elseif ($event->activity !== null && $event->activity->participants === null) {
                $infotext = 'Sign-up required, but no participant limit.';
            } elseif ($event->activity !== null && $event->activity->participants !== null) {
                $infotext = 'Sign-up required! There are roughly ' . $event->activity->freeSpots() . ' of ' . $event->activity->participants . ' places left.';
            } else {
                $infotext = 'No sign-up necessary.';
            }

            $component = (new IcalEvent())
                ->setDtStart(new DateTime(date('d-m-Y H:i:s', $event->start)))
                ->setDtEnd(new DateTime(date('d-m-Y H:i:s', $event->end)))
                ->setSummary($event->title)
                ->setDescription($infotext . ' More information: ' . route("event::show", ['id' => $event->id]))
                ->setUseTimezone(true)
                ->setLocation($event->location);

            if ($event->committee !== null) {
                $component->setOrganizer(new IcalOrganizer($event->committee->name));
            }

            $calendar->addComponent($component);
        }

        return Response::make($calendar->render())
            ->header('Content-Type', 'text/calendar; charset=utf-8')
            ->header('Content-Disposition', 'attachment; filename="protocalendar.ics"');
    }

}
