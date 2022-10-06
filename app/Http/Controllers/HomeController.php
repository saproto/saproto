<?php

namespace Proto\Http\Controllers;

use Auth;
use Carbon;
use Illuminate\View\View;
use Proto\Models\Committee;
use Proto\Models\CommitteeMembership;
use Proto\Models\Company;
use Proto\Models\Dinnerform;
use Proto\Models\HeaderImage;
use Proto\Models\Newsitem;
use Proto\Models\User;
use Proto\Models\Video;
use Proto\Models\WelcomeMessage;

class HomeController extends Controller
{
    /** @return View Display the homepage. */
    public function show()
    {
        $companies = Company::where('in_logo_bar', true)->inRandomOrder()->get();
        $newsitems = Newsitem::where('published_at', '<=', Carbon::now())->where('published_at', '>', Carbon::now()->subWeeks(2))->orderBy('published_at', 'desc')->take(3)->get();
        $birthdays = User::has('member')->where('show_birthday', true)->where('birthdate', 'LIKE', date('%-m-d'))->get()->reject(function ($user, $index) {
                return $user->member->is_pending == true;
        });
        $dinnerforms = Dinnerform::where('closed', false)->where('start', '<=', Carbon::now())->where('end', '>', Carbon::now()->subHour())->where('visible_home_page', true)->orderBy('end')->get();
        $header = HeaderImage::inRandomOrder()->first();
        $videos = Video::orderBy('video_date', 'desc')->where('video_date', '>', Carbon::now()->subMonths(3))->limit(3)->get();

        if (Auth::check() && Auth::user()->is_member) {
            $message = WelcomeMessage::where('user_id', Auth::user()->id)->first();
            return view('website.home.members', ['companies' => $companies, 'message' => $message, 'newsitems' => $newsitems, 'birthdays' => $birthdays, 'dinnerforms' => $dinnerforms, 'header' => $header, 'videos' => $videos, ]);
        } else {
            return view('website.home.external', ['companies' => $companies, 'header' => $header]);
        }
    }

    /** @return View Display the most important page of the whole site. */
    public function developers()
    {
        $committee = Committee::where('slug', '=', config('proto.rootcommittee'))->first();
        $developers = [
            'current' => CommitteeMembership::where('committee_id', $committee->id)->groupBy('user_id')->get(),
            'old' => CommitteeMembership::withTrashed()->where('committee_id', $committee->id)->whereNotNull('deleted_at')->orderBy('created_at', 'ASC')->groupBy('user_id')->get(),
        ];

        return view('website.developers', ['developers' => $developers, 'committee' => $committee]);
    }

    /** @return View Display FishCam. */
    public function fishcam() {
        return view('misc.fishcam');
    }
}
