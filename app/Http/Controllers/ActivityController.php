<?php

namespace Proto\Http\Controllers;

use Illuminate\Http\Request;

use Proto\Http\Requests;
use Proto\Http\Controllers\Controller;

use Proto\Models\Activity;

use Auth;

class ActivityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function apiActivities(Request $request)
    {

        if (!Auth::check() || !Auth::user()->member) {
            abort(403);
        }

        $activities = Activity::all();
        $data = array();

        foreach ($activities as $activity) {
            $item = new \stdClass();
            $item->id = $activity->id;
            $item->event_id = $activity->event_id;
            $item->price = $activity->price;
            $item->participants = $activity->participants;
            $item->registration_start = $activity->registration_start;
            $item->registration_end = $activity->registration_end;
            $item->active = $activity->active;
            $item->closed = $activity->closed;
            $item->organizing_commitee = $activity->organizing_commitee;
            $data[] = $item;
        }

        return $data;

    }

    public function apiActivitiesSingle($id, Request $request)
    {

        if (!Auth::check() || !Auth::user()->member) {
            abort(403);
        }

        $activity = Activity::findOrFail($id);

        $item = new \stdClass();
        $item->id = $activity->id;
        $item->event_id = $activity->event_id;
        $item->price = $activity->price;
        $item->participants = $activity->participants;
        $item->registration_start = $activity->registration_start;
        $item->registration_end = $activity->registration_end;
        $item->active = $activity->active;
        $item->closed = $activity->closed;
        $item->organizing_commitee = $activity->organizing_commitee;

        return (array) $item;

    }

    public function apiActivitiesMembers($id, Request $request)
    {

        if (!Auth::check() || !Auth::user()->member) {
            abort(403);
        }

        $activities = Activity::findOrFail($id)->users;
        $data = array();

        foreach ($activities as $activity) {
            $item = new \stdClass();
            $item->id = $activity->id;
            $item->email = $activity->email;
            $item->name_first = $activity->name_first;
            $item->name_last = $activity->name_last;
            $item->name_initials = $activity->name_initials;
            $item->birthdate = $activity->birthdate;
            $item->gender = $activity->gender;
            $data[] = $item;
        }

        return $data;

    }
}
