<?php

namespace Proto\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

use PhpParser\Node\Expr\Cast\Object_;
use Proto\Http\Requests;
use Proto\Http\Controllers\Controller;

use Proto\Models\Committee;

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
        $members = array('editions' => [], 'members' => ['current' => [], 'past' => []]);

        foreach ($committee->users as $user) {
            if ($user->pivot->edition) {
                $members['editions'][$user->pivot->edition][] = $user;
            } else {
                if (!$user->pivot->end || date('U', strtotime($user->pivot->end)) > date('U')) {
                    $members['members']['current'][] = $user;
                } else {
                    $members['members']['past'][] = $user;
                }
            }
        }

        return view('committee.show', ['committee' => $committee, 'members' => $members]);
    }

    public
    function delete($id)
    {
        $committee = Committee::find($id);

        if (!Auth::check() || !Auth::user()->can('board')) {
            abort(403, "You are not allowed to delete a committee.");
        }
        if ($committee == null) {
            abort(404, "Committee $id not found.");
        }

        Session::flash("flash_message", "The " . $committee->name . " has been deleted.");
        $committee->delete();
        return Redirect::route('committee::list', ['id' => $id]);
    }


    public
    function add(Request $request)
    {

        if (!Auth::check() || !Auth::user()->can('board')) {
            abort(403, "You are not allowed to add a committee.");
        }

        $committee = new Committee();

        $committeedata = $request->all();
        if (!$committee->validate($committeedata)) {
            return Redirect::route('committee::add', ['id' => $id])->withErrors($committee->errors());
        }
        $committee->fill($committeedata);

        $committee->save();

        Session::flash("flash_message", "The committee has been added.");

        return Redirect::route('committee::view', ['id' => $committee->id]);

    }

    public
    function edit($id, Request $request)
    {

        $committee = Committee::find($id);

        if (!Auth::check() || !Auth::user()->can('board')) {
            abort(403, "You are not allowed to edit a committee.");
        }

        $committeedata = $request->all();

        if (!$committeedata->validate($committeedata)) {
            return Redirect::route('committee::view', ['id' => $id])->withErrors($committee->errors());
        }
        $committeedata->fill($committeedata);

        $committee->save();

        Session::flash("flash_message", "Changes have been saved.");

        return Redirect::route('committee::view', ['id' => $id]);

    }

    public
    function addForm()
    {
        if (!Auth::check() || !Auth::user()->can('board')) {
            abort(403, "You are not allowed to add a committee.");
        }

        return view('committee.edit', ['new' => true]);
    }

    public
    function editForm($id)
    {
        $committee = Committee::find($id);

        if ($committee == null) {
            abort(404, "Committee $id not found.");
        }

        if (!Auth::check() || !Auth::user()->can('board')) {
            abort(403, "You are not allowed to edit a committee.");
        }

        return view('committee.edit', ['new' => false, 'id' => $id, 'data' => $committee]);
    }

    public
    function toggleHidden($id, Request $request)
    {

        $committee = Committee::find($id);

        if ($committee == null) {
            abort(404, "Committee $id not found.");
        }

        if (!Auth::check() || !Auth::user()->can('board')) {
            abort(403, "You are not allowed to edit a committee.");
        }

        $committee->public = !$committee->public;
        $committee->save();

        Session::flash("flash_message", "The committee is now " . ($committee->public ? 'visible' : 'hidden') . ".");

        return Redirect::back();

    }

}