<?php


namespace Proto\Http\Controllers;

use Illuminate\Http\Request;
use Proto\Models\Leaderboard;
use Proto\Models\LeaderboardEntry;

use Session;
use Redirect;

class LeaderboardEntryController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $entry = LeaderboardEntry::create($request->all());
        $leaderboard = Leaderboard::findOrFail($request->input('leaderboard_id'));
        $user = User::findOrFail($request->input('user_id'));
        $entry->leaderboard()->associate($leaderboard);
        $entry->user()->associate($user);
        $entry->save();
        Session::flash("flash_message", "Added new entry successfully.");
        return Redirect::back();
    }

    /**
     * Update resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $entry = LeaderboardEntry::findOrFail($request->id);
        $entry->user_id = $request->user_id;
        $entry->points = $request->points;
        $user = User::findOrFail($request->input('user_id'));
        if($user != $entry->user()) {
            $entry->user()->associate($user);
        }
        $entry->save();
        Session::flash("flash_message", "Updated entry successfully.");
        return Redirect::back();
    }

    /**
     * Delete leaderboard entry
     *
     * @param  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $entry = LeaderboardEntry::findOrFail($id);
        $entry->delete();
        Session::flash("flash_message", "The entry has been deleted.");
        return Redirect::back();
    }
}