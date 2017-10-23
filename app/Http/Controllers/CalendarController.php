<?php

namespace Proto\Http\Controllers;

use Illuminate\Http\Request;

use Proto\Http\Requests;
use Proto\Http\Controllers\Controller;

class CalendarController extends Controller
{
    public static function returnGoogleCalendarEvents($google_calendar_id, $start, $end)
    {

        $url = "https://www.googleapis.com/calendar/v3/calendars/" . $google_calendar_id . "/events?singleEvents=true&orderBy=startTime&key=" . config('app-proto.google-key-private') . "&timeMin=" . urlencode($start) . "&timeMax=" . urlencode($end) . "";

        $data = json_decode(str_replace("$", "", file_get_contents($url)));

        $results = [];

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

            if (property_exists($entry, 'description')) {
                preg_match("/Type: (.*)/", $entry->description, $type);
            } else {
                $type = null;
            }

            $results[] = array(
                'title' => $name,
                'place' => isset($entry->location) ? $entry->location : "somewhere",
                'start' => strtotime($starttime),
                'end' => strtotime($endtime),
                'type' => ($type ? $type[1] : null),
                'over' => (strtotime($endtime) < time() ? true : false),
                'current' => (strtotime($starttime) < time() && strtotime($endtime) > time() ? true : false)
            );
        }

        return $results;

    }
}
