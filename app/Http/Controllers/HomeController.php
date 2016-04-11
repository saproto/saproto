<?php

namespace Proto\Http\Controllers;

use Illuminate\Http\Request;

use Proto\Http\Requests;
use Proto\Http\Controllers\Controller;

class HomeController extends Controller
{
    /**
     * Display the homepage.
     */
    public function show()
    {
        if(\Auth::check()) {
            return view('website.home.members');
        }else {
            return view('website.home.external');
        }
    }
}
