<?php


namespace Proto\Http\Controllers;

use Illuminate\Http\Request;
use Proto\Models\Leaderboard;

class LeaderboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $leaderboards = Leaderboard::get();
        if (count($leaderboards) > 0) {
            return view('leaderboards.list', ['leaderboards' => $leaderboards]);
        } else {
            Session::flash("flash_message", "There is currently nothing to see on the leaderboards page, but please check back real soon!");
            return Redirect::back();
        }
    }
}