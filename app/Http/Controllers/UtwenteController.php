<?php

namespace Proto\Http\Controllers;

use Illuminate\Http\Request;

use Proto\Http\Requests;
use Proto\Http\Controllers\Controller;

use Proto\Models\User;

use Auth;
use Redirect;
use Session;

class UtwenteController extends Controller
{

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id, Request $request)
    {
        $user = User::findOrFail($id);

        if ($user->id != Auth::id() && !Auth::user()->can('board')) {
            abort(403);
        }

        if($request->wizard > 0) Session::flash("wizard", true);

        return view('users.study.utwente', ['user' => $user]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $id)
    {

        $user = User::findOrFail($id);

        if ($user->id != Auth::id() && !Auth::user()->can('board')) {
            abort(403);
        }

        if (AuthController::verifyUtwenteCredentials($request->username, $request->password)) {
            $user->utwente_username = $request->username;
            $user->save();
            $request->session()->flash('flash_message', 'We have associated your UT account ' . $user->utwente_username . ' with your Proto account.');
            if(Session::get('wizard')) return Redirect::route('becomeamember');
            return Redirect::route('user::dashboard', ['id' => $user->id]);
        }

        $request->session()->flash('flash_message', 'Your UTwente credentials were not correct.');
        return Redirect::back();

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $user = User::findOrFail($id);

        if ($user->id != Auth::id() && !Auth::user()->can('board')) {
            abort(403);
        }

        $user->utwente_username = null;
        $user->save();

        $request->session()->flash('flash_message', 'The link with your University of Twente account has been deleted.');
        return Redirect::route('user::dashboard', ['id' => $user->id]);
    }
}
