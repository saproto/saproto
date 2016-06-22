<?php

namespace Proto\Http\Controllers;

use Illuminate\Http\Request;

use Proto\Models\StorageEntry;
use Proto\Http\Requests;

use Proto\Models\User;
use Proto\Models\Achievement;
use Proto\Models\AchievementOwnership;

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
        if (!$achievement) abort(404);
        return view('achievement.edit', ['new' => false, 'achievement' => $achievement]);
    }

    public function destroy($id)
    {
        $achievement = Achievement::find($id);
        if (!$achievement) abort(404);
        if (count($achievement->users) > 0) {
            Session::flash('flash_message', "Achievement '" . $achievement->name . "' has users associated with it. You cannot remove it.");
            return Redirect::route("achievement::list");
        }
        $achievement->delete();
        Session::flash('flash_message', "Achievement '" . $achievement->name . "' has been removed.");
        return Redirect::route("achievement::list");
    }

    public function wrap($id)
    {
        $achievement = Achievement::find($id);
        if (!$achievement) abort(404);
        return view("achievement.give", ['achievement' => $achievement]);
    }

    public function give($achievement_id, Request $request)
    {
        $achievement = Achievement::find($achievement_id);
        $user = User::find($request->id);
        if (!$user || !$achievement) abort(404);
        $achieved = $user->achieved();
        $hasAchievement = false;
        foreach ($achieved as $entry) {
            if ($entry->id == $achievement_id) $hasAchievement = true;
        }
        if (!$hasAchievement) {
            $new = array(
                'user_id' => $request->id,
                'achievement_id' => $achievement_id
            );
            $relation = new AchievementOwnership($new);
            $relation->save();
            Session::flash('flash_message', "Achievement '" . $achievement->name . "' has been given to " . $user->name);
        } else {
            Session::flash('flash_message', "This user already has this achievement");
        }
        return Redirect::route("achievement::list");
    }
}