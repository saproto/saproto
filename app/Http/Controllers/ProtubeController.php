<?php

namespace Proto\Http\Controllers;

use Illuminate\Http\Request;

use Proto\Http\Requests;
use Proto\Http\Controllers\Controller;

class ProtubeController extends Controller
{
    public function admin()
    {
        return view('protube.admin');
    }

    public function screen()
    {
        return view('protube.screen');
    }

    public function offline()
    {
        return view('protube.offline');
    }

    public function remote()
    {
        return view('protube.remote');
    }
}
