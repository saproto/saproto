<?php


namespace Proto\Http\Controllers;

use Illuminate\Http\Request;
use Proto\Models\Committee;
use Proto\Models\Leaderboard;

use Session;
use Redirect;

class LeaderboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $leaderboards = Leaderboard::all();
        if (count($leaderboards) > 0) {
            return view('leaderboards.list', ['leaderboards' => $leaderboards]);
        } else {
            Session::flash("flash_message", "There are currently no leaderboards, but please check back real soon!");
            return Redirect::back();
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function adminIndex()
    {
        return view('leaderboards.adminlist', ['leaderboards' => Leaderboard::all()]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('leaderboards.edit', ['leaderboard' => null]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $leaderboard = new Leaderboard();
        $committee = Committee::findOrFail($request->input('committee'));
        $leaderboard->committee()->associate($committee);
        $leaderboard->name = $request->name;
        $leaderboard->description = $request->description;
        $leaderboard->icon = $request->icon;
        $leaderboard->points_name = $request->points_name;
        $leaderboard->save();


        Session::flash("flash_message", "Your leaderboard '" . $leaderboard->name . "' has been added.");
        return Redirect::route('leaderboards::edit', ['id'=>$leaderboard->id]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $leaderboard = Leaderboard::findOrFail($id);
        $entries = $leaderboard->entries->sortByDesc('points');
        return view('leaderboards.edit', ['leaderboard' => $leaderboard, 'entries' => $entries]);
    }

    public function update(Request $request, $id)
    {
        $leaderboard = Leaderboard::findOrFail($id);

        $leaderboard->name = $request->name;
        $leaderboard->description = $request->description;
        $leaderboard->points_name = $request->points_name;
        $leaderboard->icon = $request->icon;

        $committee = Committee::findOrFail($request->input('committee'));
        if($committee != $leaderboard->committee) {
            $leaderboard->committee()->associate($committee);
        }

        $leaderboard->save();

        Session::flash("flash_message", "Leaderboard has been updated.");

        return Redirect::back();
    }

    public function destroy($id)
    {
        $leaderboard = Leaderboard::findOrFail($id);

        Session::flash("flash_message", "The leaderboard '" . $leaderboard->name . "' has been deleted.");
        $leaderboard->delete();
        return Redirect::route('leaderboards::admin');
    }
}