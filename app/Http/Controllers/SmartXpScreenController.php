<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Config;
use Illuminate\View\View;

class SmartXpScreenController extends Controller
{
    /**
     * @return View
     */
    public function show()
    {
        return view('smartxp.screen', ['protube' => true]);
    }

    /**
     * @return View
     */
    public function showProtopolis()
    {
        return view('smartxp.screen');
    }

    public function timetable(): array
    {
        return CalendarController::returnGoogleCalendarEvents(
            Config::string('proto.google-calendar.timetable-id'),
            date('c', strtotime('today')),
            date('c', strtotime('tomorrow'))
        );
    }

    public function protopenersTimetable(): array
    {
        return CalendarController::returnGoogleCalendarEvents(
            Config::string('proto.google-calendar.protopeners-id'),
            date('c', strtotime('today')),
            date('c', strtotime('tomorrow'))
        );
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

        $url = 'https://www.googleapis.com/calendar/v3/calendars/'.Config::string('proto.google-calendar.smartxp-id').'/events?singleEvents=true&orderBy=startTime&key='.Config::string('app-proto.google-key-private').'&timeMin='.urlencode(date('c', strtotime('last monday', strtotime('tomorrow')))).'&timeMax='.urlencode(date('c', strtotime('next monday')));

        try {
            $data = json_decode(str_replace('$', '', file_get_contents($url)));
        } catch (Exception) {
            return (object) ['roster' => $roster, 'occupied' => false];
        }

        $occupied = false;
        foreach ($data->items as $entry) {
            $end_time = ($entry->end->date ?? $entry->end->dateTime);
            $start_time = (isset($entry->start->date) ? $entry->end->date : $entry->start->dateTime);

            $name = $entry->summary ?? '';
            preg_match('/Course\/Description:\s*([^\.]+)\./', $entry->summary ?? '', $name);
            $name = $name[1] ?? 'unknown';

            preg_match('/Hall: ZI A138, (.*)/', $entry->summary ?? '', $type);
            foreach (Config::array('proto.timetable-translations') as $key => $value) {
                $type = str_replace($key, $value, $type);
            }

            $current = strtotime($start_time) < Carbon::now()->getTimestamp() && strtotime($end_time) > Carbon::now()->getTimestamp();
            if ($current) {
                $occupied = true;
            }

            $day = strtolower(str_replace(['Saturday', 'Sunday'], ['weekend', 'weekend'], date('l', strtotime($start_time))));
            $roster[$day][] = (object) [
                'title' => $name,
                'start' => strtotime($start_time),
                'end' => strtotime($end_time),
                'type' => $type[1] ?? 'Other',
                'over' => strtotime($end_time) < Carbon::now()->getTimestamp(),
                'current' => $current,
            ];
        }

        return (object) ['roster' => $roster, 'occupied' => $occupied];
    }

    /** @return View */
    public function canWork()
    {
        $timetable = $this->smartxpTimetable();

        return view('smartxp.caniwork', ['timetable' => $timetable->roster,
            'occupied' => $timetable->occupied, ]);
    }
}
