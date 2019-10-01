<?php

namespace Proto\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Proto\Models\Event;

class QueryController extends Controller
{
    public function index()
    {
        return view('queries.index');
    }

    public function activityOverview(Request $request)
    {
        if (!$request->has('start') || !$request->has('start')) {

            if (intval(date('n')) >= 9) {
                $yearstart = intval(date('Y'));
            } else {
                $yearstart = intval(date('Y')) - 1;
            }
            $start = strtotime("$yearstart-09-01 00:00:01");
            $end = date('U');
        } else {
            $start = strtotime($request->start);
            $end = strtotime($request->end) + 86400; # Add one day to make it inclusive.
        }

        $events = Event::with(['activity', 'activity.users', 'activity.helpingCommitteeInstances'])
            ->where('start', '>=', $start)->where('end', '<=', $end)
            ->orderBy('start', 'asc')->get();

        return view('queries.activity_overview', [
            'start' => $start,
            'end' => $end,
            'events' => $events
        ]);
    }
}
