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

    public function protopenersTimetable()
    {

        return CalendarController::returnGoogleCalendarEvents(config('proto.protopeners-google-timetable-id'), date('c', strtotime("today")), date('c', strtotime("tomorrow")));

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

}
