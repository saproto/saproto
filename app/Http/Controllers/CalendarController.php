<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Config;

class CalendarController extends Controller
{
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
    public static function returnGoogleCalendarEvents(string $google_calendar_id, string $start, string $end): array
    {
        try {
            $url = 'https://www.googleapis.com/calendar/v3/calendars/'.$google_calendar_id.'/events?singleEvents=true&orderBy=startTime&key='.Config::string('app-proto.google-key-private').'&timeMin='.urlencode($start).'&timeMax='.urlencode($end).'';
            $data = json_decode(str_replace('$', '', file_get_contents($url)));
        } catch (Exception) {
            return [];
        }

        $results = [];

        foreach ($data->items as $entry) {
            $endTime = $entry->end->date ?? $entry->end->dateTime;
            $startTime = isset($entry->start->date) ? $entry->end->date : $entry->start->dateTime;

            $name = property_exists($entry, 'summary') ? $entry->summary : '(no name)';

            $name_exp = explode(' ', $name);
            if (is_numeric($name_exp[0])) {
                $name_exp[0] = '';
            }

            $name = '';
            foreach ($name_exp as $val) {
                $name .= $val.' ';
            }

            if (property_exists($entry, 'description')) {
                preg_match(' /Type: (.*)/', $entry->description, $type);
                preg_match('/Student set\(s\):.*(CRE MOD\d{2}|ITECH M \d[a-zA-Z]).*/', $entry->description, $study);
            } else {
                $type = null;
                $study = null;
            }

            $year = null;
            $studyShort = null;
            if (! empty($study)) {
                $study = $study[1];
                if (str_starts_with($study, 'CRE')) {
                    $year = ceil(intval(str_replace('CRE MOD', '', $study)) / 4);
                    $study = 'Creative Technology';
                    $studyShort = 'CreaTe';
                } elseif (str_starts_with($study, 'ITECH')) {
                    $study = 'Interaction Technology';
                    $studyShort = 'ITech';
                }
            }

            $end = Carbon::parse($endTime)->timestamp;
            $start = Carbon::parse($startTime)->timestamp;
            $now = Carbon::now()->timestamp;
            $results[] = [
                'title' => trim($name),
                'place' => isset($entry->location) ? trim($entry->location) : 'Unknown',
                'start' => $start,
                'end' => $end,
                'type' => empty($type) ? null : $type[1],
                'year' => $year,
                'study' => $study,
                'studyShort' => $studyShort,
                'over' => $end < $now,
                'current' => $start < $now && $end > $now,
            ];
        }

        return $results;
    }
}
