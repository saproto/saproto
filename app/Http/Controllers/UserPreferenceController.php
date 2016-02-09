<?php

namespace Proto\Http\Controllers;

use Illuminate\Http\Request;

use Proto\Http\Requests;
use Proto\Http\Controllers\Controller;

use Proto\Models\User;

use Auth;

class UserPreferenceController extends Controller
{

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::find($id);

        return view('info.profile', ['user' => $user]);
    }


    /**
     * Display the profile of the current user.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showOwn()
    {
        $user = User::find(Auth::id());

        return view('info.profile', ['user' => $user]);
    }

    /**
     * Show the form for editing a user profile.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if(Auth::user()->hasRole('admin')) {
            $user = User::find($id);
            return view('forms.profile', ['user' => $user]);
        }else{
            return reponse()->redirectTo('/auth/login');
        }
    }


    /**
     * Show the form for editing the users own profile.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function editOwn()
    {
        $user = User::find(Auth::id());
        return view('forms.profile', ['user' => $user]);
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

        return response()->redirectTo('/');
    }
}
