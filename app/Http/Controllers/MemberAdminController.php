<?php

namespace Proto\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

use Proto\Http\Requests;
use Proto\Http\Controllers\Controller;

use Proto\Models\User;

use Auth;
use Entrust;
use Session;

class MemberAdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('users.members.overview');
    }

    /**
     * Displays nested search results for member admin.
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showSearch(Request $request) {
        $search = $request->input('query');

        if ($search) {
            $users = User::where('name_first', 'LIKE', '%'.$search.'%')->orWhere('name_last', 'LIKE', '%'.$search.'%')->orWhere('email', 'LIKE', '%'.$search.'%')->orWhere('utwente_username', 'LIKE', '%'.$search.'%')->paginate(20);
        } else {
            $users = User::paginate(20);
        }

        return view('users.members.nested.list', ['users' => $users]);
    }


    /**
     * Show the nested details view for member admin.
     *
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showDetails($id) {
        $user = User::find($id);
        return view('users.members.nested.details', ['user' => $user]);
    }

    /**
     * Allows user to impersonate another user if user has root role.
     *
     * @param $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|void
     */
    public function impersonate($id) {
        if(Auth::user()->can('admin')) {
            $impersonator = Auth::id();
            Auth::loginUsingId($id);
            Session::put('impersonator', $impersonator);
            return redirect('/');
        }else{
            return abort(403, 'You are not authorized to access this');
        }
    }

    /**
     * Allows user to return to own user when impersonating another user.
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function quitImpersonating() {
        if(Session::has('impersonator')) {
            $impersonator = Session::get('impersonator');
            Session::put('impersonator', NULL);
            Auth::loginUsingId($impersonator);
            return redirect('/');
        }
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
}
