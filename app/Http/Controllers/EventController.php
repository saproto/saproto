<?php

namespace Proto\Http\Controllers;

use Illuminate\Http\Request;

use Proto\Models\Account;
use Proto\Models\Activity;
use Proto\Models\Committee;
use Proto\Models\Event;
use Proto\Models\FlickrAlbum;
use Proto\Models\Product;
use Proto\Models\StorageEntry;
use Proto\Models\User;

use Session;
use Redirect;
use Auth;
use Response;

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


        if (Auth::check()) {
            $reminder = Auth::user()->getCalendarAlarm();
        } else {
            $reminder = null;
        }

        $relevant_only = Auth::check() && Auth::user()->getCalendarRelevantSetting() ? true : false;

        $calendar_url = route("ical::calendar", ["personal_key" => (Auth::check() ? Auth::user()->getPersonalKey() : null)]);

        return view('event.calendar', ['events' => $data, 'years' => $years, 'ical_url' => $calendar_url, 'reminder' => $reminder, 'relevant_only' => $relevant_only]);
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
     * @return \Illuminate\Http\RedirectResponse
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
        $event->involves_food = $request->has('involves_food');
        $event->is_external = $request->has('is_external');
        $event->force_calendar_sync = $request->has('force_calendar_sync');

        if ($event->end < $event->start) {
            Session::flash("flash_message", "You cannot let the event end before it starts.");
            return Redirect::back();
        }

        if ($request->file('image')) {
            $file = new StorageEntry();
            $file->createFromFile($request->file('image'));

            $event->image()->associate($file);
        }

        $committee = Committee::find($request->input('committee'));
        $event->committee()->associate($committee);

        $event->save();

        Session::flash("flash_message", "Your event '" . $event->title . "' has been added.");
        return Redirect::route('event::show', ['id' => $event->getPublicId()]);

    }

    /**
     * Display the specified event.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $event = Event::fromPublicId($id);
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
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {

        $event = Event::findOrFail($id);

        $changed_important_details = $event->start != strtotime($request->start) || $event->end != strtotime($request->end) || $event->location != $request->location ? true : false;

        $event->title = $request->title;
        $event->start = strtotime($request->start);
        $event->end = strtotime($request->end);
        $event->location = $request->location;
        $event->secret = $request->secret;
        $event->description = $request->description;
        $event->summary = $request->summary;
        $event->involves_food = $request->has('involves_food');
        $event->is_external = $request->has('is_external');
        $event->force_calendar_sync = $request->has('force_calendar_sync');

        if ($event->end < $event->start) {
            Session::flash("flash_message", "You cannot let the event end before it starts.");
            return Redirect::back();
        }

        if ($request->file('image')) {
            $file = new StorageEntry();
            $file->createFromFile($request->file('image'));

            $event->image()->associate($file);
        }

        $committee = Committee::find($request->input('committee'));
        $event->committee()->associate($committee);

        $event->save();

        if ($changed_important_details) {
            Session::flash("flash_message", "Your event '" . $event->title . "' has been saved. You updated some important information. Don't forget to update your participants with this info!");
            return Redirect::route('email::add');
        } else {
            Session::flash("flash_message", "Your event '" . $event->title . "' has been saved.");
            return Redirect::route('event::edit', ['id' => $event->id]);
        }

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

    public function admin($id)
    {
        $event = Event::findOrFail($id);

        if (!$event->isEventAdmin(Auth::user())) {
            Session::flash("flash_message", "You are not an event admin for this event!");
            return Redirect::back();
        }

        return view('event.admin', ['event' => $event]);
    }

    public function scan($id)
    {
        $event = Event::findOrFail($id);

        if (!$event->isEventAdmin(Auth::user())) {
            Session::flash("flash_message", "You are not an event admin for this event!");
            return Redirect::back();
        }

        return view('event.scan', ['event' => $event]);
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
            $product->buyForUser($user, 1, $product->price);
        }

        $activity->closed = true;
        $activity->save();

        Session::flash("flash_message", "This activity has been closed and the relevant orderlines were added.");
        return Redirect::back();

    }

    public function linkAlbum(Request $request, $event)
    {
        $event = Event::findOrFail($event);
        $album = FlickrAlbum::findOrFail($request->album_id);
        $album->event_id = $event->id;
        $album->save();

        Session::flash("flash_message", "The album " . $album->name . " has been linked to this activity!");
        return Redirect::back();
    }

    public function unlinkAlbum($album)
    {
        $album = FlickrAlbum::findOrFail($album);
        $album->event_id = null;
        $album->save();

        Session::flash("flash_message", "The album " . $album->name . " has been unlinked from an activity!");
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
            $data[] = $item;
        }

        return $data;

    }

    public function setReminder(Request $request)
    {
        $user = Auth::user();

        $hours = floatval($request->get('hours'));

        if ($request->has('delete') || $hours <= 0) {

            $user->setCalendarAlarm(null);
            Session::flash('flash_message', 'Reminder removed.');
            return Redirect::back();

        } elseif ($hours > 0) {

            $user->setCalendarAlarm($hours);
            Session::flash('flash_message', sprintf('Reminder set to %s hours.', $hours));
            return Redirect::back();

        } else {

            abort(500, "Invalid request.");

        }
    }

    public function toggleRelevantOnly()
    {
        $user = Auth::user();
        $newSetting = $user->toggleCalendarRelevantSetting();
        if ($newSetting === true) {
            Session::flash('flash_message', 'From now on your calendar will only sync events relevant to you.');
        } else {
            Session::flash('flash_message', 'From now on your calendar will sync all events.');
        }
        return Redirect::back();
    }

    public function icalCalendar($personal_key = null)
    {

        $user = ($personal_key ? User::where('personal_key', $personal_key)->first() : null);

        if ($user) {
            $calendar_name = sprintf('S.A. Proto Calendar for %s', $user->calling_name);
        } else {
            $calendar_name = 'S.A. Proto Calendar';
        }

        $calendar = "BEGIN:VCALENDAR" . "\r\n" .
            "VERSION:2.0" . "\r\n" .
            "PRODID:-//HYTTIOAOAc//S.A. Proto Calendar//EN" . "\r\n" .
            "CALSCALE:GREGORIAN" . "\r\n" .
            "X-WR-CALNAME:" . $calendar_name . "\r\n" .
            "X-WR-CALDESC:All of Proto's events, straight from the website!" . "\r\n" .
            "BEGIN:VTIMEZONE" . "\r\n" .
            "TZID:Central European Standard Time" . "\r\n" .
            "BEGIN:STANDARD" . "\r\n" .
            "DTSTART:20161002T030000" . "\r\n" .
            "RRULE:FREQ=YEARLY;BYDAY=-1SU;BYHOUR=3;BYMINUTE=0;BYMONTH=10" . "\r\n" .
            "TZNAME:Central European Standard Time" . "\r\n" .
            "TZOFFSETFROM:+0200" . "\r\n" .
            "TZOFFSETTO:+0100" . "\r\n" .
            "END:STANDARD" . "\r\n" .
            "BEGIN:DAYLIGHT" . "\r\n" .
            "DTSTART:20160301T020000" . "\r\n" .
            "RRULE:FREQ=YEARLY;BYDAY=-1SU;BYHOUR=2;BYMINUTE=0;BYMONTH=3" . "\r\n" .
            "TZNAME:Central European Daylight Time" . "\r\n" .
            "TZOFFSETFROM:+0100" . "\r\n" .
            "TZOFFSETTO:+0200" . "\r\n" .
            "END:DAYLIGHT" . "\r\n" .
            "END:VTIMEZONE" . "\r\n";

        if ($user) {
            $reminder = $user->getCalendarAlarm();
        } else {
            $reminder = null;
        }

        $relevant_only = $user ? $user->getCalendarRelevantSetting() : false;

        foreach (Event::where('secret', false)->where('start', '>', strtotime('-6 months'))->get() as $event) {

            if (!$event->force_calendar_sync && $relevant_only && !($event->isOrganizing($user) || $event->hasBoughtTickets($user) || ($event->activity && ($event->activity->isHelping($user) || $event->activity->isParticipating($user))))) {
                continue;
            }

            if ($event->over()) {
                $infotext = 'This activity is over.';
            } elseif ($event->activity !== null && $event->activity->participants == -1) {
                $infotext = 'Sign-up required, but no participant limit.';
            } elseif ($event->activity !== null && $event->activity->participants > 0) {
                $infotext = 'Sign-up required! There are roughly ' . $event->activity->freeSpots() . ' of ' . $event->activity->participants . ' places left.';
            } elseif ($event->tickets->count() > 0) {
                $infotext = 'Ticket purchase required.';
            } else {
                $infotext = 'No sign-up necessary.';
            }

            $status = null;

            if ($event->is_external) {
                $status = 'External';
                $infotext .= ' This activity is not organised by S.A. Proto';
            }

            if ($user) {
                if ($event->isOrganizing($user)) {
                    $status = 'Organizing';
                    $infotext .= ' You are organizing this activity.';
                } elseif ($event->activity) {
                    if ($event->activity->isHelping($user)) {
                        $status = 'Helping';
                        $infotext .= ' You are helping with this activity.';
                    } elseif ($event->activity->isParticipating($user) || $event->hasBoughtTickets($user)) {
                        $status = 'Participating';
                        $infotext .= ' You are participating in this activity.';
                    }
                }
            }

            $calendar .= "BEGIN:VEVENT" . "\r\n" .
                sprintf("UID:%s@proto.utwente.nl", $event->id) . "\r\n" .
                sprintf("DTSTAMP:%s", gmdate('Ymd\THis\Z', strtotime($event->created_at))) . "\r\n" .
                sprintf("DTSTART:%s", date('Ymd\THis', $event->start)) . "\r\n" .
                sprintf("DTEND:%s", date('Ymd\THis', $event->end)) . "\r\n" .
                sprintf("SUMMARY:%s", $status ? sprintf('[%s] %s', $status, $event->title) : $event->title) . "\r\n" .
                sprintf("DESCRIPTION:%s", $infotext . ' More information: ' . route("event::show", ['id' => $event->getPublicId()])) . "\r\n" .
                sprintf("LOCATION:%s", $event->location) . "\r\n" .
                sprintf("ORGANIZER;CN=%s:MAILTO:%s",
                    ($event->committee ? $event->committee->name : 'S.A. Proto'),
                    ($event->committee ? $event->committee->getEmailAddress() : 'board@proto.utwente.nl')) . "\r\n";

            if ($reminder && $status) {
                $calendar .= "BEGIN:VALARM" . "\r\n" .
                    sprintf("TRIGGER:-PT%dM", ceil($reminder * 60)) . "\r\n" .
                    "ACTION:DISPLAY" . "\r\n" .
                    sprintf("DESCRIPTION:%s at %s", $status ? sprintf('[%s] %s', $status, $event->title) : $event->title, date('l F j, H:i:s', $event->start)) . "\r\n" .
                    "END:VALARM" . "\r\n";
            }

            $calendar .= "END:VEVENT" . "\r\n";

        }

        $calendar .= "END:VCALENDAR";

        $calendar_wrapped = "";
        foreach (explode("\r\n", $calendar) as $line) {
            if (preg_match('(SUMMARY|DESCRIPTION|LOCATION)', $line) === 1) {
                $search = [';', ','];
                $replace = ['\;', '\,'];
                $line = str_replace($search, $replace, $line);
            }
            $calendar_wrapped .= wordwrap($line, 75, "\r\n ", true) . "\r\n";
        }

        return Response::make($calendar_wrapped)
            ->header('Content-Type', 'text/calendar; charset=utf-8')
            ->header('Content-Disposition', 'attachment; filename="protocalendar.ics"');

    }

}
