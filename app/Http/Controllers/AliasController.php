<?php

namespace Proto\Http\Controllers;

use Illuminate\Http\Request;

use Proto\Http\Requests;
use Proto\Http\Controllers\Controller;

use Proto\Models\User;
use Proto\Models\Member;

use Auth;
use Redirect;
use Session;

class AliasController extends Controller
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
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
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

        $aliasbase = strtolower(substr($user->name_first, 0, 1) . '.' . str_replace(' ', '', $user->name_last));
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
