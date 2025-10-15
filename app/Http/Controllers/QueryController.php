<?php

namespace App\Http\Controllers;

use App\Enums\MembershipTypeEnum;
use App\Models\Activity;
use App\Models\ActivityParticipation;
use App\Models\Event;
use App\Models\EventCategory;
use App\Models\Member;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use Illuminate\View\View;

class QueryController extends Controller
{
    public function index(): View
    {
        return view('queries.index');
    }

    public function activityOverview(Request $request): View
    {
        if ($request->missing('start') || $request->missing('end')) {
            $year_start = intval(Date::now()->format('n')) >= 9 ? intval(Date::now()->format('Y')) : intval(Date::now()->format('Y')) - 1;
            $start = Date::parse("{$year_start}-09-01 00:00:01")->timestamp;
            $end = Date::now()->timestamp;
        } else {
            $start = $request->date('start')->timestamp;
            $end = $request->date('end')->addDay()->timestamp; // Add one day to make it inclusive.
        }

        $events = Event::with(['activity', 'activity.users', 'activity.helpingCommitteeInstances'])
            ->where('start', '>=', $start)->where('end', '<=', $end)
            ->orderBy('start')->get();

        return view('queries.activity_overview', [
            'start' => $start,
            'end' => $end,
            'events' => $events,
        ]);
    }

    public function membershipTotals(Request $request): Response|View|\Illuminate\Http\Response
    {
        $utQuery = User::query()->whereHas('member', function ($q) {
            /** @var Builder<Member> $q */
            $q->primary()->whereHas('UtAccount', function ($q) {
                $q->where('department', 'like', '%CREA%')->orWhere('department', 'like', '%TECH%');
            });
        });

        if ($request->has('export_subsidies')) {
            $export_subsidies = $utQuery->with('member.UtAccount')->get();
            $headers = [
                'Content-Encoding' => 'UTF-8',
                'Content-Type' => 'text/csv; charset=UTF-8',
                'Content-Disposition' => sprintf('attachment; filename="primary_member_overview_%s.csv"', Date::now()->format('d_m_Y')),
            ];

            return Response::make(view('queries.export_subsidies', ['users' => $export_subsidies]), 200, $headers);
        }

        $activeUserQuery = User::query()->whereHas('member', function ($query) {
            $query->whereMembershipType(MembershipTypeEnum::REGULAR);
        })->whereHas('committees');

        if ($request->has('export_active')) {
            $export_active = $activeUserQuery->with('committees')->get();
            $headers = [
                'Content-Encoding' => 'UTF-8',
                'Content-Type' => 'text/csv; charset=UTF-8',
                'Content-Disposition' => sprintf('attachment; filename="active_member_overview_%s.csv"', Date::now()->format('d_m_Y')),
            ];

            return Response::make(view('queries.export_active_members', ['export' => $export_active]), 200, $headers);
        }

        $count_per_type = Member::query()->selectRaw('membership_type, COUNT(*) as count')
            ->groupBy('membership_type')
            ->get()
            ->keyBy(fn ($item) => $item->membership_type->value)
            /** @phpstan-ignore-next-line */
            ->map(fn ($item): int => (int) $item->count);

        $count_total = $count_per_type->reject(static fn ($value, $key): bool => in_array($key, [MembershipTypeEnum::PENDING->value, MembershipTypeEnum::PET->value]))->sum();

        $count_active = $activeUserQuery->count();

        $count_primary = Member::query()->primary()->count();
        $count_secondary = $count_total - $count_primary;
        $count_ut = $utQuery->count();

        return view('queries.membership_totals', [
            'total' => $count_total,
            'primary' => $count_primary,
            'secondary' => $count_secondary,
            'ut' => $count_ut,
            'active' => $count_active,
            'count_per_type' => $count_per_type,
        ]);
    }

    public function activityStatistics(Request $request): View
    {
        if ($request->missing('start') || $request->missing('end')) {
            $now = Date::now();
            $year_start = $now->month >= 9 ? $now->year : $now->year - 1;
            $start = Date::create($year_start, 9, 1, 0, 0, 1)->timestamp;
            $end = Date::now()->timestamp;
        } else {
            $start = $request->date('start')->timestamp;
            $end = $request->date('end')->addDay()->timestamp;
        }

        $eventCategories = EventCategory::query()->withCount(['events' => static function ($query) use ($start, $end) {
            $query->where('start', '>=', $start)->where('end', '<=', $end)->whereNotLike('title', '%cancel%');
        }])->get()->sortBy('name');

        foreach ($eventCategories as $category) {
            /** @var EventCategory $category */
            /** @phpstan-ignore-next-line */
            $category->spots = Activity::query()->whereHas('event', static function ($query) use ($category, $start, $end) {
                $query->where('category_id', $category->id)->where('start', '>=', $start)->where('end', '<=', $end)->whereNotLike('title', '%cancel%');
            })->where('participants', '>', 0)
                ->sum('participants');
            /** @phpstan-ignore-next-line */
            $category->signups = ActivityParticipation::query()->whereHas('activity', static function ($query) use ($category, $start, $end) {
                $query->whereHas('event', static function ($query) use ($category, $start, $end) {
                    $query->where('category_id', $category->id)->where('start', '>=', $start)->where('end', '<=', $end)->whereNotLike('title', '%cancel%');
                })->where('participants', '>', 0);
            })->count();
            /** @phpstan-ignore-next-line */
            $category->attendees = Activity::query()->where('participants', '>', 0)->whereHas('event', static function ($query) use ($category, $start, $end) {
                $query->where('category_id', $category->id)->where('start', '>=', $start)->where('end', '<=', $end)->whereNotLike('title', '%cancel%');
            })->sum('attendees');
        }

        $events = Event::query()->selectRaw('YEAR(FROM_UNIXTIME(start)) AS year, start, COUNT(*) AS total')
            ->whereNull('deleted_at')
            ->groupBy(DB::raw('YEAR(FROM_UNIXTIME(start)), MONTH(FROM_UNIXTIME(start))'))
            ->whereNotLike('title', '%cancel%')
            ->get();

        $totalEvents = Event::query()->where('start', '>=', $start)->where('end', '<=', $end)->count();

        $changeGMM = Date::createFromDate(2010, 9, 01)->startOfDay();
        foreach ($events as $event) {
            /** @phpstan-ignore-next-line */
            $event->board = (int) $changeGMM->diffInYears(Date::createFromTimestamp($event->start, date_default_timezone_get())->startOfDay());
        }

        return view('queries.activity_statistics', ['start' => $start, 'end' => $end, 'events' => $events->groupBy('board'), 'totalEvents' => $totalEvents, 'eventCategories' => $eventCategories]);
    }
}
