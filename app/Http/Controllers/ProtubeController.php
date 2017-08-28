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
        if (Auth::user()->can('protube') || Auth::user()->isTempadmin()) {
            return view('protube.admin');
        } else {
            abort(403);
        }
    }

    public function screen(Request $request)
    {
        return view('protube.screen', ['showPin' => $request->has('showPin')]);
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
