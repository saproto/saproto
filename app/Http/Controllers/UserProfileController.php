<?php

namespace Proto\Http\Controllers;

use Illuminate\Http\Request;

use Proto\Http\Requests;
use Proto\Http\Controllers\Controller;

use Proto\Models\User;

use Auth;
use Session;

class UserProfileController extends Controller
{

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id = null)
    {
        if ($id == null) {
            $id = Auth::id();
        }

        $user = User::find($id);

        return view('users.profile', ['user' => $user]);
    }

    /**
     * Show the form for editing a user profile.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if(Auth::user()->can('board')) {
            $user = User::find($id);
            return view('forms.profile', ['user' => $user]);
        }else{
            return reponse()->redirectTo('/auth/login');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        $user = User::find($id);

        $user->name = $request->name;
        $user->email = $request->email;
        if(!empty($request->password)) $user->password = bcrypt($request->password);

        $user->save();

        Session::flash('flash_message', 'Profile updated.');

        return response()->redirectTo('/');
    }

    public function updateOwn(Request $request)
    {

        $user = User::find(Auth::id());

        $user->name = $request->name;
        $user->email = $request->email;
        if(!empty($request->password)) $user->password = bcrypt($request->password);

        $user->save();

        Session::flash('flash_message', 'Profile updated.');

        return response()->redirectTo('/');
    }
}
