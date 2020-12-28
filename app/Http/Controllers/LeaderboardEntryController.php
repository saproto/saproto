<?php


namespace Proto\Http\Controllers;

use Illuminate\Http\Request;
use Proto\Models\Committee;
use Proto\Models\LeaderboardEntry;

use Session;
use Redirect;

class LeaderboardEntryController extends Controller
{
    /**
     * Display a listing of the leaderboard's entries
     *
     * @param $id
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        $leaderboard = Leaderboard::findOrFail($id);
        if(count($leaderboard) == 0) {
            Session::flash("flash_message", "Couldn't find that leaderboard!");
            return Redirect::back();
        }
        $entries = LeaderboardEntry::where('leaderboard', $leaderboard);
        return view('leaderboards.entries.list', ['entries' => $entries, 'leaderboard' => $leaderboard]);
    }

    /**
     * Display a listing of the leaderboard's entries
     *
     * @param $id
     * @return \Illuminate\Http\Response
     */
    public function adminIndex($id)
    {
        $leaderboard = Leaderboard::findOrFail($id);
        if(count($leaderboard) == 0) {
            Session::flash("flash_message", "There is no leaderboard with that id.");
            return Redirect::back();
        }
        $entries = LeaderboardEntry::where('leaderboard', $leaderboard);
        return view('leaderboards.entries.adminlist', ['entries' => $entries, 'leaderboard' => $leaderboard]);
    }

    /**
     * Display all leaderboard entries
     *
     * @param $id
     * @return \Illuminate\Http\Response
     */
    public function adminIndexAll() {
        return view('leaderboards.entries.adminlist', ['entries' => LeaderboardEntry::get(), 'leaderboard' => null]);
    }

    /**
     * Show the form for editing a leaderboard's entries. Entries are added and edited in a
     * table-style way and thus do not need a separate page for each entry.
     *
     * @param $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $leaderboard = Leaderboard::findOrFail($id);
        if(count($leaderboard) == 0) {
            Session::flash("flash_message", "There is no leaderboard with that id.");
            return Redirect::back();
        }
        return view('leaderboards.entries.edit', ['leaderboard' => $leaderboard]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $entry = LeaderboardEntry::create($request->all());
        $entry->save();

        Session::flash("flash_message", "Added new entry successfully.");
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