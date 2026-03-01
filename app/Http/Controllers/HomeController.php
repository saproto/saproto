<?php

namespace App\Http\Controllers;

use App\Enums\MembershipTypeEnum;
use App\Models\Committee;
use App\Models\CommitteeMembership;
use App\Models\Company;
use App\Models\Dinnerform;
use App\Models\Event;
use App\Models\HeaderImage;
use App\Models\Newsitem;
use App\Models\PhotoAlbum;
use App\Models\User;
use App\Models\Video;
use App\Models\WelcomeMessage;
use Illuminate\Contracts\View\Factory;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Date;
use Illuminate\View\View;

class HomeController extends Controller
{
    /** Display the homepage. */
    public function show(): \Illuminate\Contracts\View\View|Factory
    {
        $companies =
            Cache::remember('home.companies', Date::tomorrow(), fn () => Company::query()
                ->where('in_logo_bar', true)
                ->with('media')
                ->get())->shuffle();

        $header = Cache::remember('home.headerimages', Date::tomorrow(), fn () => HeaderImage::query()->with('user.member')->get())->shuffle()->first();

        $albums =
            Cache::remember('home.albums', Date::tomorrow(), fn () => PhotoAlbum::query()->orderBy('date_taken', 'desc')
                ->with('thumbPhoto')
                ->where('published', true)
                ->take(4)
                ->get());

        if (! Auth::user()?->is_member) {
            return view('website.home.external', ['companies' => $companies, 'header' => $header, 'albums' => $albums]);
        }

        $weekly = Cache::remember('home.weekly', Date::tomorrow(), fn () => Newsitem::query()
            ->where('published_at', '<=', Date::now())
            ->where('published_at', '>', Date::now()->subWeek())
            ->where('is_weekly', true)
            ->orderBy('published_at', 'desc')
            ->get()
        )->first();

        $newsitems = Cache::remember('home.newsitems', Date::tomorrow(), fn () => Newsitem::query()
            ->whereNotNull('published_at')
            ->where('published_at', '<=', Date::now())
            ->where('published_at', '>', Date::now()->subWeeks(2))
            ->where('id', '!=', $weekly?->id)
            ->orderBy('published_at', 'desc')
            ->take(3)
            ->get());

        $birthdays =
            Cache::remember('home.birthdays', Date::tomorrow(), fn () => User::query()
                ->whereHas('member', static function ($q) {
                    $q->whereNot('membership_type', MembershipTypeEnum::PENDING);
                })
                ->where('show_birthday', true)
                ->whereMonth('birthdate', Date::now()->month)
                ->whereDay('birthdate', Date::now()->day)
                ->with('media')
                ->get());

        $dinnerforms =
            Cache::remember('home.dinnerforms', Date::tomorrow(), fn () => Dinnerform::query()
                ->where('closed', false)
                ->where('start', '<=', Date::now())
                ->where('end', '>', Date::now()->subHour())
                ->where('visible_home_page', true)
                ->orderBy('end')
                ->get());

        $videos =
            Cache::remember('home.videos', Date::tomorrow(), fn () => Video::query()
                ->orderBy('video_date', 'desc')
                ->where('video_date', '>', Date::now()->subMonths(3))
                ->limit(3)
                ->get());

        $message = Cache::remember(WelcomeMessage::getCacheKey(Auth::id()), Date::tomorrow(), fn () => WelcomeMessage::query()->where('user_id', Auth::id())->first());

        $upcomingQuery = Event::query()
            ->orderBy('start')
            ->with([
                'media',
                'activity.helpingCommittees',
                'tickets',
            ])
            ->where([
                ['end', '>=', Date::now()->timestamp],
                ['secret', false],
                [static function ($query) {
                    $query->where('publication', '<', Date::tomorrow()->timestamp)
                        ->orWhereNull('publication');
                }],
            ]);

        $featuredEvents = (clone $upcomingQuery)
            ->where('is_featured', true)
            ->limit(4);

        $upcomingEvents = (clone $upcomingQuery)
            ->where('is_featured', false)
            ->limit(10);

        $events = Cache::remember('home.events', Date::tomorrow(), fn () => $featuredEvents->union($upcomingEvents)->get())
            ->filter(fn ($event) => $event->publication == null || $event->publication < Date::now()->timestamp)
            ->where('end', '>=', Date::now()->timestamp)
            ->loadMissing([
                'activity.helpingCommittees.users' => function ($q) {
                    $q->where('users.id', Auth::id());
                },
            ])
            ->loadMissing(['activity.allUsers' => function ($q) {
                $q->where('activities_users.user_id', Auth::id()
                );
            }])
            ->loadMissing(['tickets.purchases' => function ($q) {
                $q->where('ticket_purchases.user_id', Auth::id());
            }]);

        return view('website.home.members', [
            'upcomingEvents' => $events->where('is_featured', false)->take(5),
            'featuredEvents' => $events->where('is_featured', true)->take(2),
            'companies' => $companies,
            'message' => $message,
            'newsitems' => $newsitems,
            'weekly' => $weekly,
            'birthdays' => $birthdays,
            'dinnerforms' => $dinnerforms,
            'header' => $header,
            'videos' => $videos,
            'albums' => $albums,
        ]);
    }

    /** @return View Display the most important page of the whole site. */
    public function developers(): View
    {
        $committee = Committee::query()->where('slug', '=', Config::string('proto.rootcommittee'))->first();
        $developers = [
            'current' => CommitteeMembership::query()
                ->where('committee_id', $committee->id)
                ->groupBy('user_id')
                ->with('user')
                ->get(),
            'old' => CommitteeMembership::withTrashed()
                ->where('committee_id', $committee->id)
                ->whereNotNull('deleted_at')
                ->orderBy('created_at', 'ASC')
                ->groupBy('user_id')
                ->with('user')
                ->get(),
        ];

        return view('website.developers', ['developers' => $developers, 'committee' => $committee]);
    }

    /** @return View Display FishCam. */
    public function fishcam(): View
    {
        return view('misc.fishcam');
    }
}
