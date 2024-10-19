<?php

namespace App\Http\Controllers;

use App\Enums\MembershipTypeEnum;
use App\Models\Activity;
use App\Models\ActivityParticipation;
use App\Models\Event;
use App\Models\EventCategory;
use App\Models\Member;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use Illuminate\View\View;

class QueryController extends Controller
{
    /** @return View */
    public function index()
    {
        return view('queries.index');
    }

    /**
     * @return View
     */
    public function activityOverview(Request $request)
    {
        if ($request->missing('start') || $request->missing('end')) {
            $year_start = intval(date('n')) >= 9 ? intval(date('Y')) : intval(date('Y')) - 1;
            $start = strtotime("{$year_start}-09-01 00:00:01");
            $end = date('U');
        } else {
            $start = strtotime($request->start);
            $end = strtotime($request->end) + 86399; // Add one day to make it inclusive.
        }

        $events = Event::with(['activity', 'activity.users', 'activity.helpingCommitteeInstances'])
            ->where('start', '>=', $start)->where('end', '<=', $end)
            ->orderBy('start', 'asc')->get();

        return view('queries.activity_overview', [
            'start' => $start,
            'end' => $end,
            'events' => $events,
        ]);
    }

    public function membershipTotals(Request $request)
    {
        $primary_query = Member::query()->where('membership_type', MembershipTypeEnum::REGULAR)
            ->where('is_primary_at_another_association', false)
            ->whereHas('user', function ($query) {
                $query->whereHas('UtAccount');
            });
        if ($request->has('export_subsidies')) {
            //todo: implement export
            $subsidy_users = $primary_query->get();
            $headers = [
                'Content-Encoding' => 'UTF-8',
                'Content-Type' => 'text/csv; charset=UTF-8',
                'Content-Disposition' => sprintf('attachment; filename="primary_member_overview_%s.csv"', date('d_m_Y')),
            ];

            return Response::make(view('queries.export_subsidies', ['subsidy_users' => $subsidy_users]), 200, $headers);
        }

        $count_total = Member::query()->where(function (Builder $query) {
            $query->whereNot('membership_type', MembershipTypeEnum::PET)
                ->whereNot('membership_type', MembershipTypeEnum::PENDING);
        })->count();
        $count_active = Member::query()->whereHas('user', function ($query) {
            $query->whereHas('committees');
        })->count();
        $count_lifelong = Member::query()->where('membership_type', MembershipTypeEnum::LIFELONG)->count();
        $count_honorary = Member::query()->where('membership_type', MembershipTypeEnum::HONORARY)->count();
        $count_donor = Member::query()->where('membership_type', MembershipTypeEnum::DONOR)->count();
        $count_pending = Member::query()->where('membership_type', MembershipTypeEnum::PENDING)->count();
        $count_pet = Member::query()->where('membership_type', MembershipTypeEnum::PET)->count();
        $count_primary = $primary_query->count();
        $count_secondary = $count_total - $count_primary;
        $count_ut = Member::query()->where('membership_type', MembershipTypeEnum::REGULAR)->whereHas('user', function ($query) {
            $query->whereHas('UtAccount')->orWhereNotNull('utwente_username');
        })->count();

        return view('queries.membership_totals', [
            'total' => $count_total,
            'primary' => $count_primary,
            'secondary' => $count_secondary,
            'ut' => $count_ut,
            'active' => $count_active,
            'lifelong' => $count_lifelong,
            'honorary' => $count_honorary,
            'donor' => $count_donor,
            'pending' => $count_pending,
            'pet' => $count_pet,
        ]);
    }

    public function primaryExport()
    {
        $export_subsidies = [];
        /** @var User[] $users */
        $users = User::query()->whereHas('member', function ($query) {
            $query->where('membership_type', MembershipTypeEnum::REGULAR);
        })->whereHas('UtAccount')->with('UtAccount')->get();
        foreach ($users as $user) {
            $export_subsidies[] = (object) [
                'name' => $user->name,
                'primary' => 'true',
                'email' => $user->UtAccount()->first()->mail,
                'ut_number' => $user->UtAccount()->first()->number,
            ];
        }

        $headers = [
            'Content-Encoding' => 'UTF-8',
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => sprintf('attachment; filename="primary_member_overview_%s.csv"', date('d_m_Y')),
        ];

        return Response::make(view('queries.export_subsidies', ['export' => $export_subsidies]), 200, $headers);
    }

    public function activityStatistics(Request $request)
    {

        if ($request->missing('start') || $request->missing('end')) {
            $year_start = intval(date('n')) >= 9 ? intval(date('Y')) : intval(date('Y')) - 1;
            $start = strtotime("{$year_start}-09-01 00:00:01");
            $end = date('U');
        } else {
            $start = strtotime($request->start);
            $end = strtotime($request->end) + 86399; // Add one day to make it inclusive.
        }

        $eventCategories = EventCategory::query()->withCount(['events' => static function ($query) use ($start, $end) {
            $query->where('start', '>=', $start)->where('end', '<=', $end);
        }])->get()->sortBy('name');

        foreach ($eventCategories as $category) {
            /** @var EventCategory $category */
            $category->spots = Activity::query()->whereHas('event', static function ($query) use ($category, $start, $end) {
                $query->where('category_id', $category->id)->where('start', '>=', $start)->where('end', '<=', $end);
            })->where('participants', '>', 0)
                ->sum('participants');

            $category->signups = ActivityParticipation::query()->whereHas('activity', static function ($query) use ($category, $start, $end) {
                $query->whereHas('event', static function ($query) use ($category, $start, $end) {
                    $query->where('category_id', $category->id)->where('start', '>=', $start)->where('end', '<=', $end);
                })->where('participants', '>', 0);
            })->count();

            $category->attendees = Activity::query()->where('participants', '>', 0)->whereHas('event', static function ($query) use ($category, $start, $end) {
                $query->where('category_id', $category->id)->where('start', '>=', $start)->where('end', '<=', $end);
            })->sum('attendees');
        }

        $events = Event::query()->selectRaw('YEAR(FROM_UNIXTIME(start)) AS Year, WEEK(FROM_UNIXTIME(start)) AS Week, start as Start, COUNT(*) AS Total')
            ->whereNull('deleted_at')
            ->groupBy(DB::raw('YEAR(FROM_UNIXTIME(start)), MONTH(FROM_UNIXTIME(start))'))
            ->get();

        $totalEvents = Event::query()->where('start', '>=', $start)->where('end', '<=', $end)->count();

        $changeGMM = Carbon::parse('01-09-2010');
        foreach ($events as $event) {
            $event->Board = Carbon::createFromTimestamp($event->Start)->diffInYears($changeGMM);
        }

        return view('queries.activity_statistics', ['start' => $start, 'end' => $end, 'events' => $events->groupBy('Board'), 'totalEvents' => $totalEvents, 'eventCategories' => $eventCategories]);
    }
}
