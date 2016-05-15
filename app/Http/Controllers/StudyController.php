<?php

namespace Proto\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

use Proto\Http\Requests;
use Proto\Http\Controllers\Controller;

use Proto\Models\Study;
use Proto\Models\StudyEntry;
use Proto\Models\User;

use Auth;
use Entrust;
use Session;
use Redirect;


class StudyController extends Controller
{

    public function linkForm($user_id)
    {
        $user = User::find($user_id);
        if ($user == null) {
            abort(404);
        }
        if (($user->id != Auth::id()) && (!Auth::user()->can('board'))) {
            abort(403);
        }
        return view('users.study.edit', ['link' => null, 'user' => $user, 'studies' => Study::all()]);
    }

    public function editLinkForm($user_id, $link_id)
    {
        $link = StudyEntry::find($link_id);
        if ($link == null) {
            abort(404);
        }
        if (($link->user->id != Auth::id()) && (!Auth::user()->can('board'))) {
            abort(403);
        }
        return view('users.study.edit', ['link' => $link, 'user' => $link->user]);
    }

    public function link($user_id, Request $request)
    {

        $user = User::find($user_id);
        if ($user == null) {
            abort(404);
        }
        if (($user->id != Auth::id()) && (!Auth::user()->can('board'))) {
            abort(403);
        }

        $start = null;
        if (($time = strtotime($request->input("start"))) === false) {
            abort(500);
        } else {
            $start = $time;
        }

        $end = null;
        if ($request->input('end') != "" && strtotime($request->input("end")) === false) {
            abort(500);
        } else {
            $time = strtotime($request->input("end"));
            $end = $time;
        }

        $study = Study::find($request->input("study"));
        if ($study == null) {
            abort(404);
        }

        $user->studies()->attach($study->id, ['end' => $end, 'start' => $start, 'user_id' => $user->id, 'study_id' => $study->id]);
        return Redirect::route('user::dashboard', ['id' => $user->id]);
    }

    public function editLink($user_id, $link_id, Request $request)
    {
        $link = StudyEntry::find($link_id);
        if (!$link) {
            abort(404);
        }
        if (($link->user->id != Auth::id()) && (!Auth::user()->can('board'))) {
            abort(403);
        }

        $start = null;
        if (($time = strtotime($request->input("start"))) === false) {
            abort(500);
        } else {
            $start = $time;
        }

        $end = null;
        if ($request->input('end') != "" && strtotime($request->input("end")) === false) {
            abort(500);
        } else {
            $time = strtotime($request->input("end"));
            $end = $time;
        }

        $link->start = $start;
        $link->end = $end;
        $link->save();

        return Redirect::route('user::dashboard', ['id' => $link->user->id]);
    }

    public function unlink($user_id, $link_id)
    {
        $link = StudyEntry::find($link_id);
        if ($link == null) {
            abort(404);
        }
        if (($link->user->id != Auth::id()) && (!Auth::user()->can('board'))) {
            abort(403);
        }
        $link->delete();
        return Redirect::route('user::dashboard', ['id' => $link->user->id]);
    }

}