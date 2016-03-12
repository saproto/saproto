<?php

namespace Proto\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

use Proto\Http\Requests;
use Proto\Http\Controllers\Controller;

use Proto\Models\Study;
use Proto\Models\User;

use Auth;
use Entrust;
use Session;
use Redirect;


class StudyController extends Controller
{

    public function linkForm($id)
    {
        $user = User::find($id);
        if ($user == null) {
            abort(404, "Member $id not found.");
        }
        if (($user->id != Auth::id()) && (!Auth::user()->can('board'))) {
            abort(403, "You cannot link a study for " . $user->name . ".");
        }
        return view('users.study.link', ['user' => $user, 'studies' => Study::all()]);
    }

    public function editLinkForm($id, $study_id)
    {
        $user = User::find($id);
        if ($user == null) {
            abort(404, "Member $id not found.");
        }
        if (($user->id != Auth::id()) && (!Auth::user()->can('board'))) {
            abort(403, "You cannot link a study for " . $user->name . ".");
        }
        $study = Study::find($study_id);
        if ($study == null) {
            abort(404, "Study $id not found.");
        }
        if (!$user->studies->contains($study_id)) {
            abort(500, $user->name . " is not linked to " . $study->name . ".");
        }
        return view('users.study.edit', ['user' => $user, 'study' => $user->studies()->find($study_id)]);
    }

    public function link($id, Request $request)
    {
        if ($request->input("start") == "") {
            abort(500, "The start date is required.");
        }

        $user = User::find($id);
        if ($user == null) {
            abort(404, "Member $id not found.");
        }
        if (($user->id != Auth::id()) && (!Auth::user()->can('board'))) {
            abort(403, "You cannot link a study for " . $user->name . ".");
        }

        $study = Study::find($request->input("study"));
        if ($study == null) {
            abort(404, "Study $id not found.");
        }
        if ($user->studies->contains($study->id)) {
            abort(500, $user->name . " is already linked to " . $study->name . ".");
        }

        $user->studies()->attach($study->id, ['created_at' => $request->input("start"), 'till' => ($request->input("end") == "" ? null : $request->input("end"))]);
        return Redirect::route('user::dashboard', ['id' => $id]);
    }

    public function editLink($id, $study_id, Request $request) {
        if ($request->input("start") == "") {
            abort(500, "The start date is required.");
        }

        $user = User::find($id);
        if ($user == null) {
            abort(404, "Member $id not found.");
        }
        if (($user->id != Auth::id()) && (!Auth::user()->can('board'))) {
            abort(403, "You cannot unlink a study for " . $user->name . ".");
        }

        $study = Study::find($study_id);
        if ($study == null) {
            abort(404, "Study $id not found.");
        }
        if (!$user->studies->contains($study_id)) {
            abort(500, $user->name . " is not linked to " . $study->name . ".");
        }

        $study = $user->studies->find($study->id);
        $study->pivot->created_at = $request->input("start");
        $study->pivot->till = ($request->input("end") == '' ? null : $request->input("end"));
        $study->pivot->save();
        return Redirect::route('user::dashboard', ['id' => $id]);
    }

    public function unlink($id, $study_id)
    {
        $user = User::find($id);
        if ($user == null) {
            abort(404, "Member $id not found.");
        }
        if (($user->id != Auth::id()) && (!Auth::user()->can('board'))) {
            abort(403, "You cannot unlink a study for " . $user->name . ".");
        }
        $study = Study::find($study_id);
        if ($study == null) {
            abort(404, "Study $id not found.");
        }
        if (!$user->studies->contains($study_id)) {
            abort(500, $user->name . " is not linked to " . $study->name . ".");
        }
        $user->studies()->detach($study->id);
        return Redirect::route('user::dashboard', ['id' => $id]);
    }

}