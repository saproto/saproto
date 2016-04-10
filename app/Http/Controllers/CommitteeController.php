<?php

namespace Proto\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

use PhpParser\Node\Expr\Cast\Object_;
use Proto\Models\StorageEntry;
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

        if (!$committee->public && (!Auth::check() || !Auth::user()->can('board'))) {
            abort(404, "Committee $id not found.");
        }

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

    public function add(Request $request)
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

    public function edit($id, Request $request)
    {

        $committee = Committee::find($id);

        if (!Auth::check() || !Auth::user()->can('board')) {
            abort(403, "You are not allowed to edit a committee.");
        }

        $committee->fill($request->all());

        $committee->save();

        Session::flash("flash_message", "Changes have been saved.");

        return Redirect::route('committee::show', ['id' => $id]);

    }

    public function image($id, Request $request) {

        $committee = Committee::find($id);

        if (!Auth::check() || !Auth::user()->can('board')) {
            abort(403, "You are not allowed to edit a committee.");
        }

        $image = $request->file('image');
        $name = date('U') . "-" . mt_rand(1000,9999);
        Storage::disk('local')->put($name,  File::get($image));

        $file = new StorageEntry();
        $file->mime = $image->getClientMimeType();
        $file->original_filename = $image->getClientOriginalName();
        $file->filename = $name;
        $file->save();

        $committee->image()->associate($file);
        $committee->save();

        return Redirect::route('committee::show', ['id' => $id]);

    }

    public function addForm()
    {
        if (!Auth::check() || !Auth::user()->can('board')) {
            abort(403, "You are not allowed to add a committee.");
        }

        return view('committee.edit', ['new' => true]);
    }

    public function editForm($id)
    {
        $committee = Committee::find($id);

        if ($committee == null) {
            abort(404, "Committee $id not found.");
        }

        if (!Auth::check() || !Auth::user()->can('board')) {
            abort(403, "You are not allowed to edit a committee.");
        }

        return view('committee.edit', ['new' => false, 'id' => $id, 'committee' => $committee]);
    }

    public function toggleHidden($id, Request $request)
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