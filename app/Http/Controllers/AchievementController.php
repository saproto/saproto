<?php

namespace Proto\Http\Controllers;

use Illuminate\Http\Request;
use Proto\Http\Requests;

use Proto\Models\StorageEntry;
use Proto\Models\User;
use Proto\Models\Achievement;
use Proto\Models\AchievementOwnership;

use Session;
use Auth;
use Redirect;

class AchievementController extends Controller
{

    public function overview()
    {
        return view('achievement.list', ['achievements' => Achievement::orderBy('created_at', 'asc')->get()]);
    }

    public function create()
    {
        return view('achievement.manage', ['new' => true]);
    }

    public function store(Request $request)
    {
        $achievement = new Achievement($request->all());
        $achievement->save();
        Session::flash('flash_message', "Achievement '" . $achievement->name . "' has been created.");
        return Redirect::route("achievement::manage", ['id' => $achievement->id]);
    }

    public function update($id, Request $request)
    {
        $achievement = Achievement::find($id);
        if (!$achievement) abort(404);
        $achievement->fill($request->all());
        $achievement->save();
        Session::flash('flash_message', "Achievement '" . $achievement->name . "' has been updated.");
        return Redirect::back();
    }

    public function manage($id)
    {
        $achievement = Achievement::find($id);
        if (!$achievement) abort(404);
        return view('achievement.manage', ['new' => false, 'achievement' => $achievement]);
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

    public function give($achievement_id, Request $request)
    {
        $achievement = Achievement::find($achievement_id);
        $user = User::find($request->user_id);
        if (!$user || !$achievement) abort(404);
        $achieved = $user->achieved();
        $hasAchievement = false;
        foreach ($achieved as $entry) {
            if ($entry->id == $achievement_id) $hasAchievement = true;
        }
        if (!$hasAchievement) {
            $new = array(
                'user_id' => $request->user_id,
                'achievement_id' => $achievement_id
            );
            $relation = new AchievementOwnership($new);
            $relation->save();
            Session::flash('flash_message', "Achievement $achievement->name has been given to $user->name.");
        } else {
            Session::flash('flash_message', "This user already has this achievement");
        }
        return Redirect::back();
    }

    public function take($achievement_id, $user_id)
    {
        $achievement = Achievement::find($achievement_id);
        $user = User::find($user_id);
        if (!$user || !$achievement) abort(404);
        $achieved = AchievementOwnership::all();
        foreach ($achieved as $entry) {
            if ($entry->achievement_id == $achievement_id && $entry->user_id == $user_id) {
                $entry->delete();
                Session::flash('flash_message', "Achievement $achievement->name taken from $user->name.");
            }
        }
        return Redirect::back();
    }

    public function image($id, Request $request)
    {

        $achievement = Achievement::find($id);

        $image = $request->file('image');
        if ($image) {
            $file = new StorageEntry();
            $file->createFromFile($image);

            $achievement->image()->associate($file);
            $achievement->save();
        } else {
            $achievement->image()->dissociate();
            $achievement->save();
        }
        Session::flash('flash_message', "Achievement Icon set");
        return Redirect::route('achievement::manage', ['id' => $id]);

    }
}