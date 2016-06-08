<?php

namespace Proto\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

use Proto\Http\Requests;
use Proto\Http\Controllers\Controller;

use Proto\Models\User;
use Proto\Models\Event;
use Proto\Models\Activity;

use Auth;

class ApiController extends Controller
{
    public function members(Request $request)
    {

        if (!Auth::check() || !Auth::user()->member) {
            abort(403);
        }

        $users = User::all();
        $data = array();

        foreach ($users as $user) {
            if (!$user->member) continue;
            if ($request->has('term') && strpos(strtolower($user->name), strtolower($request->term)) === false) continue;

            $member = new \stdClass();
            $member->name = $user->name;
            $member->id = $user->id;
            $data[] = $member;
        }

        return $data;

    }

    public function events(Request $request)
    {

        if (!Auth::check() || !Auth::user()->member) {
            abort(403);
        }

        $events = Event::all();
        $data = array();

        foreach ($events as $event) {
            $item = new \stdClass();
            $item->id = $event->id;
            $item->title = $event->title;
            $item->description = $event->description;
            $item->start = $event->start;
            $item->end = $event->end;
            $item->location = $event->location;
            $data[] = $item;
        }

        return $data;

    }

    public function eventsSingle($id, Request $request)
    {

        if (!Auth::check() || !Auth::user()->member) {
            abort(403);
        }

        $event = Event::findOrFail($id);

        $item = new \stdClass();
        $item->id = $event->id;
        $item->title = $event->title;
        $item->description = $event->description;
        $item->start = $event->start;
        $item->end = $event->end;
        $item->location = $event->location;

        return (array) $item;

    }

    public function activities(Request $request)
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

    public function activitiesSingle($id, Request $request)
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

    public function activitiesMembers($id, Request $request)
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

    public function train(Request $request) {

        return stripslashes(file_get_contents("http://@ews-rpx.ns.nl/mobile-api-avt?station=".$_GET['station']));

    }

}
