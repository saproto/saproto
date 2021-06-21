<?php

namespace Proto\Http\Controllers;

use Illuminate\Http\Request;
use Proto\Models\Leaderboard;
use Proto\Models\LeaderboardEntry;
use Proto\Models\User;
use Redirect;
use Session;

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
        $leaderboard = Leaderboard::findOrFail($request->input('leaderboard_id'));
        if ($leaderboard->entries()->where('user_id', $request->user_id)->first()) {
            Session::flash('flash_message', 'There is already a entry for this user');
            return Redirect::back();
        }

        $entry = LeaderboardEntry::create($request->all());
        $user = User::findOrFail($request->user_id);
        $entry->leaderboard()->associate($leaderboard);
        $entry->user()->associate($user);
        $entry->save();

        Session::flash('flash_message', 'Added new entry successfully.');
        return Redirect::back();
    }

    /**
     * Update resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     */
    public function update(Request $request)
    {
        $entry = LeaderboardEntry::findOrFail($request->id);
        $entry->points = $request->points;
        $entry->save();
        return response()->json(['points' => $entry->points]);
    }

    /**
     * Delete leaderboard entry.
     *
     * @param  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $entry = LeaderboardEntry::findOrFail($id);
        $entry->delete();
        Session::flash('flash_message', 'The entry has been deleted.');
        return Redirect::back();
    }
}
