<?php

namespace App\Http\Controllers;

use Exception;
use ICal\ICal;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

class CalendarController extends Controller
{
    /**
     * @param string $google_calendar_id
     * @param string $start
     * @param string $end
     * @return array
     */
    public static function returnGoogleCalendarEvents(string $google_calendar_id, string $start, string $end)
    {
        try {
            $url = 'https://www.googleapis.com/calendar/v3/calendars/' . $google_calendar_id . '/events?singleEvents=true&orderBy=startTime&key=' . config('app-proto.google-key-private') . '&timeMin=' . urlencode($start) . '&timeMax=' . urlencode($end) . '';
            $data = json_decode(str_replace('$', '', file_get_contents($url)));
        } catch (Exception) {
            return [];
        }

        $results = [];

        foreach ($data->items as $entry) {
            $endTime = $entry->end->date ?? $entry->end->dateTime;
            $startTime = isset($entry->start->date) ? $entry->end->date : $entry->start->dateTime;

            if (property_exists($entry, 'summary')) {
                $name = $entry->summary;
            } else {
                $name = '(no name)';
            }
            $name_exp = explode(' ', $name);
            if (is_numeric($name_exp[0])) {
                $name_exp[0] = '';
            }
            $name = '';
            foreach ($name_exp as $val) {
                $name .= $val . ' ';
            }

            if (property_exists($entry, 'description')) {
                preg_match(' /Type: (.*)/', $entry->description, $type);
                preg_match('/Student set\(s\):.*(CRE MOD[0-9]{2}|ITECH M [0-9][a-zA-Z]).*/', $entry->description, $study);
            } else {
                $type = null;
                $study = null;
            }

            $year = null;
            $studyShort = null;
            if ($study) {
                $study = $study[1];
                if (substr($study, 0, 3) == 'CRE') {
                    $year = ceil(intval(str_replace('CRE MOD', '', $study)) / 4);
                    $study = 'Creative Technology';
                    $studyShort = 'CreaTe';
                } elseif (substr($study, 0, 5) == 'ITECH') {
                    $study = 'Interaction Technology';
                    $studyShort = 'ITech';
                }
            }

            $results[] = [
                'title' => trim($name),
                'place' => isset($entry->location) ? trim($entry->location) : 'Unknown',
                'start' => strtotime($startTime),
                'end' => strtotime($endTime),
                'type' => ($type ? $type[1] : null),
                'year' => $year,
                'study' => $study,
                'studyShort' => $studyShort,
                'over' => strtotime($endTime) < time(),
                'current' => strtotime($startTime) < time() && strtotime($endTime) > time(),
            ];
        }

        return $results;
    }


    public static function returnIcalEvents(string $icalLink, int $daysBefore = 0, int $daysAfter = 1, int $cacheSeconds = 0)
    {
        $cacheKey = "timetable-" . $icalLink . "-" . $daysBefore . "-" . $daysAfter;

        return Cache::remember($cacheKey, $cacheSeconds, function () use ($icalLink, $daysBefore, $daysAfter) {
            $ical = new ICal(false, array(
                'defaultSpan' => 2,
                'defaultTimeZone' => 'DST',
                'defaultWeekStart' => 'MO',
                'disableCharacterReplacement' => false,
                'filterDaysAfter' => $daysAfter,
                'filterDaysBefore' => $daysBefore,
                'httpUserAgent' => null,
                'skipRecurrence' => false,
            ));

            $ical->initUrl($icalLink, $username = null, $password = null, $userAgent = null);

            return array_map(function ($event) {
                return [
                    'title' => Str::replace('Course: ', '', $event->summary),
                    'place' => $event->location,
                    'start' => $event->dtstart_array[2],
                    'end' => $event->dtend_array[2],
                    'type' => Str::startsWith($event->summary, 'Course') ? 'Course' : 'Other',
                ];
            }, $ical->events());
        });
    }
}
