<?php


namespace Proto\Http\Controllers;

use Illuminate\Http\Request;
use Proto\Models\Leaderboard;
use Proto\Models\LeaderboardEntry;

use Session;
use Redirect;

class LeaderboardEntryController extends Controller
{
//    /**
//     * Display a listing of the leaderboard's entries
//     *
//     * @param $id
//     * @return \Illuminate\Http\Response
//     */
//    public function index($id)
//    {
//        $leaderboard = Leaderboard::findOrFail($id);
//        $entries = $leaderboard->entries();
//        return view('leaderboards.entries.list', ['entries' => $entries, 'leaderboard' => $leaderboard]);
//    }
//
//    /**
//     * Display a listing of the leaderboard's entries
//     *
//     * @param $id
//     * @return \Illuminate\Http\Response
//     */
//    public function adminIndex($id)
//    {
//        $leaderboard = Leaderboard::findOrFail($id);
//        $entries = $leaderboard->entries();
//        return view('leaderboards.entries.adminlist', ['entries' => $entries, 'leaderboard' => $leaderboard]);
//    }
//
//    /**
//     * Display all leaderboard entries
//     *
//     * @param $id
//     * @return \Illuminate\Http\Response
//     */
//    public function adminIndexAll() {
//        return view('leaderboards.entries.adminlist', ['entries' => LeaderboardEntry::get(), 'leaderboard' => null]);
//    }
//
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $entry = LeaderboardEntry::create($request->all());
        $leaderboard = LeaderboardEntry::find($request->input('leaderboard_id'));
        $entry->leaderboard()->associate($leaderboard);
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
        $entry->member_id = $request->member_id;
        $entry->points = $request->points;
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