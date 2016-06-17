<?php

namespace Proto\Http\Controllers;

use Illuminate\Http\Request;

use Proto\Models\StorageEntry;
use Proto\Http\Requests;

use Proto\Models\User;
use Proto\Models\Achievement;

use Auth;
use Session;
use Redirect;

class AchievementController extends Controller
{

    public function overview()
    {
        return view('achievement.list', ['achievements' => Achievement::orderBy('created_at', 'desc')->get()]);
    }

    public function create()
    {
        return view('achievement.edit', ['new' => true]);
    }

    public function store(Request $request)
    {
        $achievement = new Achievement($request->all());
        $achievement->save();
        Session::flash('flash_message', "Achievement '" . $achievement->name . "' has been created.");
        return Redirect::route("achievement::list");
    }

    public function update($id, Request $request)
    {
        $achievement = Achievement::find($id);
        if (!$achievement) abort(404);
        $achievement->fill($request->all());
        $achievement->save();
        Session::flash('flash_message', "Achievement '" . $achievement->name . "' has been updated.");
        return Redirect::route("achievement::list");
    }

    public function edit($id)
    {
        $achievement = Achievement::find($id);
        if (!$achievement) {
            abort(404);
        }
        return view('study.edit', ['new' => false, 'achievement' => $achievement]);
    }

    public
    function destroy($id)
    {
        $achievement = Achievement::find($id);
        if (!$achievement) {
            abort(404);
        }
        if (count($achievement->users) > 0) {
            Session::flash('flash_message', "Achievement '" . $achievement->name . "' has users associated with it. You cannot remove it.");
            return Redirect::route("achievement::list");
        }
        $achievement->delete();
        Session::flash('flash_message', "Achievement '" . $achievement->name . "' has been removed.");
        return Redirect::route("achievement::list");
    }

}
