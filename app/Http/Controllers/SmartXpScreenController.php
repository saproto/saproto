<?php

namespace App\Http\Controllers;

use Cache;
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
    public function timetable()
    {
        $studies = [
            'Create Year 1' => [
                'short' => 'CreaTe Y1',
                'year' => 1,
                'type' => 'CRE MOD',
                'ical' => 'https://cloud.timeedit.net/nl_utwente/web/student/ri69dQ34X34ZXtQ5uQ8ZZ074y1Z84YZ6Q929w08QQ62uj6109l9n443j50Z3kj1B21DB136B0m7D9Dt6029QFlAF36Eo944AF6CE26DB.ics',
            ],

            'Create Year 2' => [
                'short' => 'CreaTe Y2',
                'year' => 2,
                'type' => 'CRE MOD',
                'ical' => 'https://cloud.timeedit.net/nl_utwente/web/public/ri65Q304518Z5uQ3555X64Q95Z044XZ5n4Q5317Q0Y72y3wXZ86Xn804.ics',
            ],
        ];

        foreach ($studies as $study => $value) {
            $events = Cache::remember("timetable-$study", 3600, function () use ($value) {
                $ical = new ICal(false, array(
                    'defaultSpan' => 2,     // Default value
                    'defaultTimeZone' => 'UTC',
                    'defaultWeekStart' => 'MO',  // Default value
                    'disableCharacterReplacement' => false, // Default value
                    'filterDaysAfter' => null,  // Default value
                    'filterDaysBefore' => null,  // Default value
                    'httpUserAgent' => null,  // Default value
                    'skipRecurrence' => false, // Default value
                ));

                $ical->initUrl($value['ical']);

                return collect($ical->events());
            });
        }


        return $events->map(function ($event) {
            return [
                'title' => $event->summary,
                'place' => $event->location,
                'start' => $event->dtstart_array[2],
                'end' => $event->dtend_array[2],
                'type' => null,
                'year' => null,
                'study' => null,
                'studyShort' => null,
                'over' => strtotime($event->dtend) < time(),
                'current' => strtotime($event->dtstart) < time() && strtotime($event->dtend) > time(),
            ];
        });
    }

    /** @return array */
    public function protopenersTimetable()
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
    public function bus(Request $request)
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
    public function smartxpTimetable()
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
    public function canWork()
    {
        return view('smartxp.caniwork', ['timetable' => $this->smartxpTimetable()->roster,
            'occupied' => $this->smartxpTimetable()->occupied,]);
    }
}
