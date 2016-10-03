<?php

namespace Proto\Http\Controllers;

use Illuminate\Http\Request;

use Proto\Http\Requests;
use Proto\Http\Controllers\Controller;

use Proto\Models\Alias;
use Proto\Models\User;
use Proto\Models\Member;

use Auth;
use Redirect;
use Session;
use DB;

class AliasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $aliases = Alias::orderBy('alias', 'asc')->get();

        if ($aliases->count() > 0) {

            $data = [];
            foreach ($aliases as $alias) {
                $data[$alias->alias][] = $alias;
            }

            return view('aliases.index', ['aliases' => $data]);

        } else {

            return Redirect::route('alias::add');

        }

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        return view('aliases.add');

    }

    /**
     * Update resource.
     *
     * @return mixed
     */
    public function update(Request $request)
    {

        $from = $request->input('from');
        $into = $request->input('into');

        $affected = DB::table('alias')->where('alias', $from)->update([
            'alias' => $into,
        ]);

        if ($affected > 0) {
            $request->session()->flash('flash_message', 'Renamed ' . $from . ' into ' . $into . '.');
            return Redirect::back();
        } else {
            $request->session()->flash('flash_message', 'No such alias (' . $from . ').');
            return Redirect::back();
        }

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        if ($request->input('destination') != '') {

            $alias = Alias::create([
                'alias' => $request->input('alias'),
                'destination' => $request->input('destination')
            ]);
            $alias->save();

            $request->session()->flash('flash_message', 'Destination added to alias.');
            return Redirect::route('alias::index');


        } elseif ($request->input('user') != 'off') {

            $user = User::findOrFail($request->input('user'));

            $alias = Alias::create([
                'alias' => $request->input('alias'),
                'user_id' => $user->id
            ]);
            $alias->save();

            $request->session()->flash('flash_message', 'User added to alias.');
            return Redirect::route('alias::index');

        } else {

            $request->session()->flash('flash_message', 'No action performed.');
            return Redirect::route('alias::index');

        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $idOrAlias)
    {
        $alias = Alias::find($idOrAlias);

        if ($alias) {
            $alias->delete();
            $request->session()->flash('flash_message', 'Entry deleted.');
            return Redirect::back();
        }

        $affected = DB::table('alias')->where('alias', $idOrAlias)->delete();
        if ($affected > 0) {
            $request->session()->flash('flash_message', 'Deleted alias <strong>' . $idOrAlias . '</strong> with ' . $affected . ' destinations.');
            return Redirect::back();
        } else {
            $request->session()->flash('flash_message', 'No such alias (' . $idOrAlias . ').');
            return Redirect::back();
        }

    }

    /**
     * Create personal alias for a user.
     *
     * @param $id
     */
    public function createFor($id)
    {

        $user = User::findOrFail($id);

        if (($user->id != Auth::id()) && (!Auth::user()->can('board'))) {
            abort(403);
        }

        if (!$user->member || !$user->isActiveMember()) {
            Session::flash("flash_message", "Only active members can have a personal alias!");
            return Redirect::back();
        }

        if ($user->member->proto_mail) {
            Session::flash("flash_message", "You already have a personal alias!");
            return Redirect::back();
        }

        $name = explode(" ", $user->name);
        $aliasbase = strtolower(substr($name[0], 0, 1) . '.' . str_replace(' ', '', implode("", array_slice($name, 1))));
        $alias = $aliasbase;
        $i = 0;

        while (Member::where('proto_mail', $alias)->count() > 0) {
            $i++;
            $alias = $aliasbase . '-' . $i;
        }

        $user->member->proto_mail = $alias;
        $user->member->save();

        Session::flash("flash_message", "Your alias will be activated soon!");
        return Redirect::back();

    }

    /**
     * Delete personal alias for a user.
     *
     * @param $id
     */
    public function deleteFor($id)
    {

        $user = User::findOrFail($id);

        if (($user->id != Auth::id()) && (!Auth::user()->can('board'))) {
            abort(403);
        }

        if (!$user->member) {
            Session::flash("flash_message", "This user is not a member.");
            return Redirect::back();
        }

        if (!$user->member->proto_mail) {
            Session::flash("flash_message", "You don't have an alias.");
            return Redirect::back();
        }

        $user->member->proto_mail = null;
        $user->member->save();

        Session::flash("flash_message", "Your alias will be removed soon!");
        return Redirect::back();

    }
}
