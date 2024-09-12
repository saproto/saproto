<?php

namespace App\Http\Controllers;

use Cache;
use Carbon;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\View\View;
use ICal\ICal;

class SmartXpScreenController extends Controller
{
    /**
     * @return View
     */
    public function show()
    {
        return view('smartxp.screen');
    }

    /**
     * @return View
     */
    public function showProtopolis()
    {
        return view('smartxp.protopolis_screen');
    }

    /** @return array */
    public function timetable(int $daysBefore = 0, int $daysAfter = 1)
    {
        $allEvents = [];
        foreach (config('proto.google-calendar.studies') as $study) {
            $icalEvents = CalendarController::returnIcalEvents($study['ical'], $daysBefore, $daysAfter);
            $allEvents = array_merge(array_map(function ($event) use ($study) {
                return [
                    ...$event,
                    'year' => $study['year'],
                    'study' => $study['study'],
                    'studyShort' => $study['short'],
                ];
            }, $icalEvents), $allEvents);
        }

        usort($allEvents, fn($a, $b) => $a['start'] <=> $b['start']);
        
        return array_map(function ($event) {
            return [
                ...$event,
                'over' => $event['end'] < time(),
                'current' => $event['start'] < time() && $event['end'] > time(),
            ];
        }, $allEvents);
    }

    /** @return array */
    public
    function protopenersTimetable()
    {
        return CalendarController::returnGoogleCalendarEvents(
            config('proto.google-calendar.protopeners-id'),
            date('c', strtotime('today')),
            date('c', strtotime('tomorrow'))
        );
    }

    /**
     * @return Response|JsonResponse
     */
    public
    function bus(Request $request)
    {
        try {
            return response(file_get_contents("http://v0.ovapi.nl/tpc/$request->tpc_id,$request->tpc_id_other"), 200)->header('Content-Type', 'application/json');
        } catch (Exception $e) {
            return response()->json([
                'message' => 'OV_API not available',
            ], 503);
        }
    }

    /** @return object */
    public
    function smartxpTimetable()
    {
        $roster = [
            'monday' => [],
            'tuesday' => [],
            'wednesday' => [],
            'thursday' => [],
            'friday' => [],
            'weekend' => [],
        ];
        $occupied = false;
        $url = 'https://www.googleapis.com/calendar/v3/calendars/' . config('proto.google-calendar.smartxp-id') . '/events?singleEvents=true&orderBy=startTime&key=' . config('app-proto.google-key-private') . '&timeMin=' . urlencode(date('c', strtotime('last monday', strtotime('tomorrow')))) . '&timeMax=' . urlencode(date('c', strtotime('next monday')));

        try {
            $data = json_decode(str_replace('$', '', file_get_contents($url)));
        } catch (Exception $e) {
            return (object)['roster' => $roster, 'occupied' => $occupied];
        }

        foreach ($data->items as $entry) {
            $end_time = ($entry->end->date ?? $entry->end->dateTime);
            $start_time = (isset($entry->start->date) ? $entry->end->date : $entry->start->dateTime);
            $name = $entry->summary;
            $name_exp = explode(' ', $name);
            if (is_numeric($name_exp[0])) {
                $name_exp[0] = '';
            }
            $name = '';
            foreach ($name_exp as $val) {
                $name .= $val . ' ';
            }
            preg_match('/Type: (.*)/', $entry->description, $type);
            $current = strtotime($start_time) < time() && strtotime($end_time) > time();
            if ($current) {
                $occupied = true;
            }
            $day = strtolower(str_replace(['Saturday', 'Sunday'], ['weekend', 'weekend'], date('l', strtotime($start_time))));
            $roster[$day][] = (object)[
                'title' => $name,
                'start' => strtotime($start_time),
                'end' => strtotime($end_time),
                'type' => $type[1],
                'over' => strtotime($end_time) < time(),
                'current' => $current,
            ];
        }

        return (object)['roster' => $roster, 'occupied' => $occupied];
    }

    /** @return View */
    public
    function canWork()
    {
        return view('smartxp.caniwork', ['timetable' => $this->smartxpTimetable()->roster,
            'occupied' => $this->smartxpTimetable()->occupied,]);
    }
}
