<?php

namespace Proto\Http\Controllers;

use Illuminate\Http\Request;
use PhpParser\Node\Expr\Cast\Object_;
use Proto\Http\Requests;
use Proto\Http\Controllers\Controller;

use Proto\Models\StorageEntry;
use Proto\Models\Committee;
use Proto\Models\CommitteeMembership;
use Proto\Models\User;

use Auth;
use Entrust;
use Session;
use Redirect;


class CommitteeController extends Controller
{

    public function overview()
    {
        if (Auth::check() && Auth::user()->can('board')) {
            return view('committee.list', ['data' => Committee::orderby('name', 'asc')->get()]);
        } else {
            return view('committee.list', ['data' => Committee::where('public', 1)->orderby('name', 'asc')->get()]);
        }
    }

    public function show($id)
    {
        $committee = Committee::find($id);

        if (!$committee->public && (!Auth::check() || !Auth::user()->can('board'))) {
            abort(404);
        }

        return view('committee.show', ['committee' => $committee, 'members' => $committee->allmembers()]);
    }

    public function add(Request $request)
    {

        $committee = new Committee();

        $committee->fill($request->all());
        $committee->save();

        Session::flash("flash_message", "Your new committee has been added!");

        return Redirect::route('committee::show', ['id' => $committee->id]);

    }

    public function edit($id, Request $request)
    {

        $committee = Committee::find($id);

        if ($committee->slug == config('proto.rootcommittee') && $request->slug != $committee->slug) {

            Session::flash("flash_message", "This committee is protected. You cannot change it's e-mail alias.");

            return Redirect::back();

        }

        $committee->fill($request->all());

        $committee->save();

        Session::flash("flash_message", "Changes have been saved.");

        return Redirect::route('committee::edit', ['new' => false, 'id' => $id]);

    }

    public function image($id, Request $request)
    {

        $committee = Committee::find($id);

        $image = $request->file('image');
        if ($image) {
            $file = new StorageEntry();
            $file->createFrom($image);

            $committee->image()->associate($file);
            $committee->save();
        } else {
            $committee->image()->dissociate();
            $committee->save();
        }

        return Redirect::route('committee::show', ['id' => $id]);

    }

    public function addForm()
    {
        return view('committee.edit', ['new' => true]);
    }

    public function editForm($id)
    {
        $committee = Committee::find($id);

        if ($committee == null) {
            abort(404);
        }

        return view('committee.edit', ['new' => false, 'id' => $id, 'committee' => $committee, 'members' => $committee->allmembers()]);
    }

    /**
     * Committee membership tools below
     */
    public function addMembership(Request $request)
    {

        $user = User::find($request->user_id);
        $committee = Committee::find($request->committee_id);
        if ($user == null) {
            abort(404);
        }
        if ($committee == null) {
            abort(404);
        }

        if ($committee->slug == config('proto.rootcommittee') && !Auth::user()->can('admin')) {

            Session::flash("flash_message", "This committee is protected. You cannot add members to this committee if you are not in it.");

            return Redirect::back();

        }

        if ($user->id == Auth::id() && !Auth::user()->can('admin')) {

            Session::flash("flash_message", "You cannot add yourself to a committee. Please ask someone else to do so.");

            return Redirect::back();

        }

        $data = $request->all();

        if ($data['role'] == "") $data["role"] = null;
        if ($data['edition'] == "") $data["edition"] = null;
        if ($data['end'] == "") {
            $data["end"] = null;
        } else {
            if (($data["end"] = strtotime($data["end"])) === false) {
                abort(500);
            }
        }
        if (($data["start"] = strtotime($data["start"])) === false) {
            abort(500);
        }

        $membership = new CommitteeMembership();
        if (!$membership->validate($data)) {
            return Redirect::route('committee::edit', ['id' => $request->committee_id])->withErrors($membership->errors());
        }
        $membership->fill($data);

        $membership->save();

        Session::flash("flash_message", "You have added " . $membership->user->name . " to " . $membership->committee->name . ".");

        return Redirect::back();

    }

    public function editMembershipForm($id)
    {

        $membership = CommitteeMembership::find($id);
        if (!$membership) {
            abort(404);
        }

        return view("committee.membership-edit", ["membership" => $membership]);

    }

    public function editMembership($id, Request $request)
    {

        $membership = CommitteeMembership::find($id);
        if (!$membership) {
            abort(404);
        }

        $membership->role = $request->role;
        $membership->edition = $request->edition;
        if (($membership->start = strtotime($request->start)) === false) {
            Session::flash("flash_message", "Ill-formatted start date.");
            return Redirect::back();
        }
        if ($request->end != "" && ($membership->end = strtotime($request->end)) === false) {
            Session::flash("flash_message", "Ill-formatted end date.");
            return Redirect::back();
        }

        $membership->save();

        return Redirect::route("committee::edit", ["id" => $membership->committee->id]);

    }

    public function deleteMembership($id)
    {

        $membership = CommitteeMembership::find($id);
        if ($membership == null) {
            abort(404);
        }

        if ($membership->committee->slug == config('proto.rootcommittee') && !Auth::user()->can('admin')) {

            Session::flash("flash_message", "This committee is protected. You cannot delete members from this committee if you are not in it.");

            return Redirect::back();

        }

        if ($membership->user->id == Auth::id() && !Auth::user()->can('admin')) {

            Session::flash("flash_message", "You cannot remove yourself from a committee. Please ask someone else to do so.");

            return Redirect::back();

        }

        Session::flash("flash_message", "You have removed " . $membership->user->name . " from " . $membership->committee->name . ".");

        $committee_id = $membership->committee->id;

        $membership->delete();

        return Redirect::route("committee::edit", ["id" => $committee_id]);

    }

}