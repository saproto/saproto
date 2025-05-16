<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Config;

class CalendarController extends Controller
{
    /**
     * @return array<array<string, mixed>>
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

            $results[] = [
                'title' => trim($name),
                'place' => isset($entry->location) ? trim($entry->location) : 'Unknown',
                'start' => Carbon::parse($startTime)->getTimestamp(),
                'end' => Carbon::parse($endTime)->getTimestamp(),
                'type' => empty($type) ? null : $type[1],
                'year' => $year,
                'study' => $study,
                'studyShort' => $studyShort,
                'over' => Carbon::parse($endTime)->getTimestamp() < Carbon::now()->getTimestamp(),
                'current' => Carbon::parse($startTime)->getTimestamp() < Carbon::now()->getTimestamp() && Carbon::parse($endTime)->getTimestamp() > Carbon::now()->getTimestamp(),
            ];
        }

        return $results;
    }
}
