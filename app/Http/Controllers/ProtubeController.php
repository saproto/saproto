<?php

namespace Proto\Http\Controllers;

use Illuminate\Http\Request;

use Auth;

use Proto\Http\Requests;
use Proto\Http\Controllers\Controller;

class ProtubeController extends Controller
{
    public function admin()
    {
        if(Auth::user()->can('board') || Auth::user()->isTempadmin()) {
            return view('protube.admin');
        }else{
            abort(403);
        }
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
