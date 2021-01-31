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
        $leaderboards = Leaderboard::get();
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
        return view('leaderboards.adminlist', ['leaderboards' => Leaderboard::get()]);
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
        $committee = Committee::find($request->input('committee'));
        $leaderboard->committee()->associate($committee);
        $leaderboard->committee_id = $committee->id;
        $leaderboard->name = $request->name;
        $leaderboard->description = $request->description;
        $leaderboard->icon = $request->icon;
        $leaderboard->points_name = $request->points_name;
        $leaderboard->save();


        Session::flash("flash_message", "Your leaderboard '" . $leaderboard->name . "' has been added.");
        return Redirect::route('leaderboards::admin');
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
        return view('leaderboards.edit', ['leaderboard' => $leaderboard]);
    }

    public function update(Request $request, $id)
    {
        $leaderboard = Leaderboard::findOrFail($id);

        $leaderboard->name = $request->name;
        $leaderboard->description = $request->description;
        $leaderboard->points_name = $request->points_name;
        $leaderboard->icon = $request->icon;

        $committee = Committee::find($request->input('committee'));
        if($committee != $leaderboard->committee) {
            $leaderboard->committee()->associate($committee);
        }

        $leaderboard->save();

        Session::flash("flash_message", "Leaderboard has been updated.");

        return redirect(route("leaderboards::admin"));
    }

    public function destroy($id)
    {
        $leaderboard = Leaderboard::findOrFail($id);

        Session::flash("flash_message", "The leaderboard '" . $leaderboard->name . "' has been deleted.");
        $leaderboard->delete();
        return Redirect::route('leaderboards::admin');
    }
}