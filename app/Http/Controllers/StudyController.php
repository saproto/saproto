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

    public function index()
    {
        $studies = Study::all();
        return view('study.list', ['studies' => $studies]);
    }

    public function create()
    {
        return view('study.edit', ['new' => true]);
    }

    public function store(Request $request)
    {
        $study = new Study($request->all());
        if ($request->has('utwente')) {
            $study->utwente = true;
        } else {
            $study->utwente = false;
        }
        $study->save();
        Session::flash('flash_message', "Study '" . $study->name . "' has been created.");
        return Redirect::route("study::list");
    }

    public function edit($id)
    {
        $study = Study::find($id);
        if (!$study) {
            abort(404);
        }
        return view('study.edit', ['new' => false, 'study' => $study]);
    }

    public function update($id, Request $request)
    {
        $study = Study::find($id);
        if (!$study) {
            abort(404);
        }
        $study->fill($request->all());
        if ($request->has('utwente')) {
            $study->utwente = true;
        } else {
            $study->utwente = false;
        }
        $study->save();
        Session::flash('flash_message', "Study '" . $study->name . "' has been updated.");
        return Redirect::route("study::list");
    }

    public function destroy($id)
    {
        $study = Study::find($id);
        if (!$study) {
            abort(404);
        }
        if (count($study->users) > 0) {
            Session::flash('flash_message', "Study '" . $study->name . "' has users associated with it. You cannot remove it.");
            return Redirect::route("study::list");
        }
        Session::flash('flash_message', "Study '" . $study->name . "' has been removed.");
        $study->delete();
        return Redirect::route("study::list");
    }

    public function linkForm($user_id)
    {
        $user = User::find($user_id);
        if ($user == null) {
            abort(404);
        }
        if (($user->id != Auth::id()) && (!Auth::user()->can('board'))) {
            abort(403);
        }
        return view('users.study.edit', ['link' => null, 'user' => $user, 'studies' => Study::orderBy('name', 'asc')->get()]);
    }

    public function editLinkForm($user_id, $link_id)
    {
        $link = StudyEntry::withTrashed()->findOrFail($link_id);
        if (($link->user->id != Auth::id()) && (!Auth::user()->can('board'))) {
            abort(403);
        }
        return view('users.study.edit', ['link' => $link, 'user' => $link->user]);
    }

    public function link($user_id, Request $request)
    {

        $user = User::findOrFail($user_id);
        if (($user->id != Auth::id()) && (!Auth::user()->can('board'))) {
            abort(403);
        }
        $study = Study::findOrFail($request->study);
        $link = new StudyEntry();
        if (($link->created_at = date('Y-m-d H:i:s', strtotime($request->start))) === false || $request->start == "") {
            Session::flash("flash_message", "Ill-formatted start date.");
            return Redirect::back();
        }

        $link->deleted_at = null;
        if ($request->end != "" && ($link->deleted_at = date('Y-m-d H:i:s', strtotime($request->end))) === false) {
            Session::flash("flash_message", "Ill-formatted end date.");
            return Redirect::back();
        }

        $link->user()->associate($user);
        $link->study()->associate($study);

        $link->save();

        Session::flash("flash_message", "Your study has been saved.");
        return Redirect::route('user::dashboard', ['id' => $user->id]);
    }

    public function editLink($user_id, $link_id, Request $request)
    {
        $link = StudyEntry::withTrashed()->findOrFail($link_id);
        if (($link->user->id != Auth::id()) && (!Auth::user()->can('board'))) {
            abort(403);
        }

        if (($link->created_at = date('Y-m-d H:i:s', strtotime($request->start))) === false) {
            Session::flash("flash_message", "Ill-formatted start date.");
            return Redirect::back();
        }

        $link->deleted_at = null;
        if ($request->end != "" && ($link->deleted_at = date('Y-m-d H:i:s', strtotime($request->end))) === false) {
            Session::flash("flash_message", "Ill-formatted end date.");
            return Redirect::back();
        }

        $link->save();


        Session::flash("flash_message", "Your study has been saved.");
        return Redirect::route('user::dashboard', ['id' => $link->user->id]);
    }

    public function unlink($user_id, $link_id)
    {
        $link = StudyEntry::withTrashed()->findOrFail($link_id);
        if (($link->user->id != Auth::id()) && (!Auth::user()->can('board'))) {
            abort(403);
        }
        $link->forceDelete();
        Session::flash("flash_message", "Study removed!");
        return Redirect::route('user::dashboard', ['id' => $link->user->id]);
    }

}