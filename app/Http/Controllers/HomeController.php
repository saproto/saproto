<?php

namespace Proto\Http\Controllers;

use Illuminate\Http\Request;

use Proto\Http\Requests;
use Proto\Http\Controllers\Controller;

use Proto\Models\ActivityParticipation;
use Proto\Models\Company;
use Proto\Models\Event;
use Auth;
use Proto\Models\OrderLine;

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
            return view('website.home.members', ['events' => $events, 'companies' => $companies]);
        } else {
            return view('website.home.external', ['events' => $events, 'companies' => $companies]);
        }

    }
}
