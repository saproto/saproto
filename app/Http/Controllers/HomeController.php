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
use Proto\Models\WelcomeMessage;

class HomeController extends Controller
{

    /**
     * Display the homepage.
     */
    public function show()
    {

        $events = Event::where('secret', false)->where('start', '>=', date('U'))->orderBy('start')->limit(5)->get();
        $companies = Company::where('in_logo_bar', true)->get();

        if (Auth::check()) {
            $message = WelcomeMessage::where('user_id', Auth::user()->id)->first();
            return view('website.home.members', ['events' => $events, 'companies' => $companies, 'message' => $message]);
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

}
