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

        $url = "https://www.googleapis.com/calendar/v3/calendars/" . config('proto.google-timetable-id') . "/events?singleEvents=true&orderBy=startTime&key=" . env('GOOGLE_KEY_PRIVATE') . "&timeMin=" . urlencode(date('c', strtotime("today"))) . "&timeMax=" . urlencode(date('c', strtotime("tomorrow"))) . "";

        $data = json_decode(str_replace("$", "", file_get_contents($url)));

        $roster = [];

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

            $roster[] = array(
                'title' => $name,
                'place' => isset($entry->location) ? $entry->location : "somewhere",
                'start' => strtotime($starttime),
                'end' => strtotime($endtime),
                'type' => $type[1],
                'over' => (strtotime($endtime) < time() ? true : false),
                'current' => (strtotime($starttime) < time() && strtotime($endtime) > time() ? true : false)
            );
        }

        return $roster;

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

            $roster[strtolower(str_replace(['Saturday', 'Sunday'], ['weekend', 'weekend'], date('l', strtotime($starttime))))][] = (object)array(
                'title' => $name,
                'start' => strtotime($starttime),
                'end' => strtotime($endtime),
                'type' => $type[1],
                'over' => (strtotime($endtime) < time() ? true : false),
                'current' => (strtotime($starttime) < time() && strtotime($endtime) > time() ? true : false)
            );
        }

        return $roster;

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
        return view('smartxp.caniwork', ['timetable' => $this->smartxpTimetable()]);
    }
}
