<?php

namespace Proto\Http\Controllers;

use Illuminate\Http\Request;

use Proto\Http\Requests;
use Proto\Http\Controllers\Controller;

use Proto\Models\ActivityParticipation;
use Proto\Models\Committee;
use Proto\Models\CommitteeMembership;
use Proto\Models\Company;
use Proto\Models\Event;
use Proto\Models\OrderLine;
use Proto\Models\Page;
use Proto\Models\User;

use Auth;
use Carbon;
use Proto\Models\WelcomeMessage;
use Proto\Models\Newsitem;

class HomeController extends Controller
{

    /**
     * Display the homepage.
     */
    public function show()
    {

        $events = Event::where('secret', false)->where('end', '>=', date('U'))->orderBy('start')->limit(5)->get();
        $companies = Company::where('in_logo_bar', true)->get();
        $newsitems = Newsitem::where('published_at', '<=', Carbon::now())->where('published_at', '>', Carbon::now()->subMonths(1))->orderBy('published_at', 'desc')->take(3)->get();

        if (Auth::check()) {
            $message = WelcomeMessage::where('user_id', Auth::user()->id)->first();
            return view('website.home.members', ['events' => $events, 'companies' => $companies, 'message' => $message, 'newsitems' => $newsitems]);
        } else {
            return view('website.home.external', ['events' => $events, 'companies' => $companies]);
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
