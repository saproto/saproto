<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\Factory;
use Carbon\CarbonInterface;
use Exception;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Config;
use Illuminate\View\View;

class SmartXpScreenController extends Controller
{
    /**
     * @return View
     */
    public function show(): \Illuminate\Contracts\View\View|Factory
    {
        return view('smartxp.screen', ['protube' => true]);
    }

    /**
     * @return View
     */
    public function showProtopolis(): \Illuminate\Contracts\View\View|Factory
    {
        return view('smartxp.screen');
    }

    /**
     * @return array<int, array{
     * title: string,
     * place: string,
     * start: int,
     * end: int,
     * type: string|null,
     * year: mixed,
     * study: mixed,
     * studyShort: mixed,
     * over: bool,
     * current: bool
     * }>
     */
    public function timetable(): array
    {
        return CalendarController::returnGoogleCalendarEvents(
            Config::string('proto.google-calendar.timetable-id'),
            Carbon::today()->toIso8601String(),
            Carbon::tomorrow()->toIso8601String()
        );
    }

    /**
     * @return array<int, array{
     * title: string,
     * place: string,
     * start: int,
     * end: int,
     * type: string|null,
     * year: mixed,
     * study: mixed,
     * studyShort: mixed,
     * over: bool,
     * current: bool
     * }>
     */
    public function protopenersTimetable(): array
    {
        return CalendarController::returnGoogleCalendarEvents(
            Config::string('proto.google-calendar.protopeners-id'),
            Carbon::today()->toIso8601String(),
            Carbon::tomorrow()->toIso8601String()
        );
    }

    /** @return object{
     *     roster: array<'monday'|'tuesday'|'wednesday'|'thursday'|'friday'|'weekend', array<object{
     *      title: string,
     *      start: int,
     *      end: int,
     *      type: string,
     *      over: bool,
     *      current: bool
     *  }>
     *     >
     * }
     */
    public function smartxpTimetable(): object
    {
        $roster = [
            'monday' => [],
            'tuesday' => [],
            'wednesday' => [],
            'thursday' => [],
            'friday' => [],
            'weekend' => [],
        ];

        $url = 'https://www.googleapis.com/calendar/v3/calendars/'.Config::string('proto.google-calendar.smartxp-id').'/events?singleEvents=true&orderBy=startTime&key='.Config::string('app-proto.google-key-private').'&timeMin='.urlencode(Carbon::now()->previous(CarbonInterface::MONDAY)->toIso8601String()).'&timeMax='.urlencode(Carbon::now()->next(CarbonInterface::MONDAY)->toIso8601String());

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

            $current = Carbon::parse($start_time)->timestamp < Carbon::now()->timestamp && Carbon::parse($end_time)->timestamp > Carbon::now()->timestamp;
            if ($current) {
                $occupied = true;
            }

            $day = strtolower(str_replace(['Saturday', 'Sunday'], ['weekend', 'weekend'], Carbon::parse($start_time)->format('l')));
            $roster[$day][] = (object) [
                'title' => $name,
                'start' => Carbon::parse($start_time)->timestamp,
                'end' => Carbon::parse($end_time)->timestamp,
                'type' => $type[1] ?? 'Other',
                'over' => Carbon::parse($end_time)->timestamp < Carbon::now()->timestamp,
                'current' => $current,
            ];
        }

        return (object) ['roster' => $roster, 'occupied' => $occupied];
    }

    /** @return View */
    public function canWork(): \Illuminate\Contracts\View\View|Factory
    {
        $timetable = $this->smartxpTimetable();

        return view('smartxp.caniwork', ['timetable' => $timetable->roster,
            'occupied' => $timetable->occupied, ]);
    }
}
