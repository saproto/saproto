<?php

namespace Proto\Http\Controllers;

use Illuminate\Http\Request;

use Proto\Http\Requests;
use Proto\Http\Controllers\Controller;

use Exception;

class SmartXpScreenController extends Controller
{

    /**
     * Display the specified resource.
     */
    public function show(Request $request)
    {

        return view('smartxp.screen');

    }

    public function timetable()
    {

        return CalendarController::returnGoogleCalendarEvents(config('proto.google-timetable-id'), date('c', strtotime("today")), date('c', strtotime("tomorrow")));

    }

    public function boardroomTimetable()
    {

        return CalendarController::returnGoogleCalendarEvents(config('proto.boardroom-google-timetable-id'), date('c', strtotime("today")), date('c', strtotime("+1 week")));

    }

    public function smartxpTimetable()
    {

        $url = "https://www.googleapis.com/calendar/v3/calendars/" . config('proto.smartxp-google-timetable-id') . "/events?singleEvents=true&orderBy=startTime&key=" . env('GOOGLE_KEY_PRIVATE') . "&timeMin=" . urlencode(date('c', strtotime('last monday', strtotime('tomorrow')))) . "&timeMax=" . urlencode(date('c', strtotime('next monday'))) . "";

        $data = json_decode(str_replace("$", "", file_get_contents($url)));

        $roster = [
            'monday' => [],
            'tuesday' => [],
            'wednesday' => [],
            'thursday' => [],
            'friday' => [],
            'weekend' => []
        ];

        $answer = true;

        foreach ($data->items as $entry) {

            $endtime = (isset($entry->end->date) ? $entry->end->date : $entry->end->dateTime);
            $starttime = (isset($entry->start->date) ? $entry->end->date : $entry->start->dateTime);

            $name = $entry->summary;
            $name_exp = explode(" ", $name);
            if (is_numeric($name_exp[0])) {
                $name_exp[0] = "";
            }
            $name = "";
            foreach ($name_exp as $key => $val) {
                $name .= $val . " ";
            }

            preg_match("/Type: (.*)/", $entry->description, $type);

            $current = (strtotime($starttime) < time() && strtotime($endtime) > time() ? true : false);

            if ($current) {
                $answer = false;
            }

            $roster[strtolower(str_replace(['Saturday', 'Sunday'], ['weekend', 'weekend'], date('l', strtotime($starttime))))][] = (object)array(
                'title' => $name,
                'start' => strtotime($starttime),
                'end' => strtotime($endtime),
                'type' => $type[1],
                'over' => (strtotime($endtime) < time() ? true : false),
                'current' => $current
            );
        }

        return (object)['roster' => $roster, 'answer' => $answer];

    }

    public function bus($stop)
    {
        try {
            $departures = json_decode(stripslashes(file_get_contents("https://api.9292.nl/0.1/locations/enschede/$stop/departure-times?lang=en-GB")));
            return $departures->tabs[0]->departures;
        } catch (Exception $e) {
            return [(object)[
                'time' => '00:00',
                'service' => '',
                'mode' => (object)[
                    'name' => 'Error in API!'
                ],
                'realtimeText' => '',
                'realtimeState' => '9292',
                'destinationName' => 'who knows?'
            ]];
        }
    }

    public function canWork()
    {
        return view('smartxp.caniwork', ['timetable' => $this->smartxpTimetable()->roster,
            'answer' => $this->smartxpTimetable()->answer]);
    }

    public function boardroomStatus()
    {
        return view('smartxp.boardroom');
    }
}
