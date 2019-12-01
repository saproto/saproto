<?php

namespace Proto\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Storage;
use Proto\Http\Requests;
use Proto\Http\Controllers\Controller;

use Proto\Models\ActivityParticipation;
use Proto\Models\Committee;
use Proto\Models\CommitteeMembership;
use Proto\Models\Company;
use Proto\Models\Event;
use Proto\Models\HeaderImage;
use Proto\Models\OrderLine;
use Proto\Models\Page;
use Proto\Models\User;
use Proto\Models\Dinnerform;

use Auth;
use Carbon;
use Proto\Models\Video;
use Proto\Models\WelcomeMessage;
use Proto\Models\Newsitem;

class HomeController extends Controller
{

    /**
     * Display the homepage.
     */
    public function show()
    {

        $companies = Company::where('in_logo_bar', true)->orderBy('sort', 'asc')->get();
        $newsitems = Newsitem::where('published_at', '<=', Carbon::now())->where('published_at', '>', Carbon::now()->subWeeks(2))->orderBy('published_at', 'desc')->take(3)->get();
        $birthdays = User::has('member')->where('show_birthday', true)->where('birthdate', 'LIKE', date('%-m-d'))->get();
        $dinnerform = Dinnerform::all()->first();
        $header = HeaderImage::inRandomOrder()->first();
        $videos = Video::orderBy('video_date', 'desc')->where('video_date', '>', Carbon::now()->subMonths(3))->limit(3)->get();

        if (Auth::check() && Auth::user()->member) {
            $message = WelcomeMessage::where('user_id', Auth::user()->id)->first();
            return view('website.home.members', ['companies' => $companies, 'message' => $message,
                'newsitems' => $newsitems, 'birthdays' => $birthdays, 'dinnerform' => $dinnerform, 'header' => $header, 'videos' => $videos]);
        } else {
            return view('website.home.external', ['companies' => $companies, 'header' => $header]);
        }

    }

    /**
     * Display the most important page of the whole site.
     */
    public function developers()
    {
        $committee = Committee::where('slug', '=', config('proto.rootcommittee'))->first();
        $developers = [
            'current' => CommitteeMembership::where('committee_id', $committee->id)->groupBy('user_id')->get(),
            'old' => CommitteeMembership::withTrashed()->where('committee_id', $committee->id)->whereNotNull('deleted_at')->orderBy('created_at', 'ASC')->groupBy('user_id')->get()
        ];
        return view('website.developers', ['developers' => $developers, 'committee' => $committee]);
    }

    public function fishcam()
    {
        return view('misc.fishcam');
    }

}
