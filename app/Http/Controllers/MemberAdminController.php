<?php

namespace Proto\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

use Proto\Http\Requests;
use Proto\Http\Controllers\Controller;

use Proto\Models\Member;
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

    public function showSearch(Request $request)
    {
        $search = $request->input('query');

        if ($search) {
            $users = User::where('name_first', 'LIKE', '%' . $search . '%')->orWhere('name_last', 'LIKE', '%' . $search . '%')->orWhere('name_initials', 'LIKE', '%' . $search . '%')->orWhere('email', 'LIKE', '%' . $search . '%')->orWhere('utwente_username', 'LIKE', '%' . $search . '%')->paginate(20);
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

    public function showDetails($id)
    {
        $user = User::find($id);
        return view('users.members.nested.details', ['user' => $user]);
    }

    /**
     * Allows impersonation of another user.
     *
     * @param $id
     * @return mixed
     */
    public function impersonate($id)
    {
        if (Auth::user()->hasRole('admin')) {
            Session::put("impersonator", Auth::user()->id);
            Auth::loginUsingId($id);
            return redirect('/');
        } else {
            return abort(403);
        }
    }

    /**
     * Returns to the original user when impersonating.
     *
     * @return mixed
     */
    public function quitImpersonating()
    {
        if (Session::has("impersonator")) {
            Auth::loginUsingId(Session::get("impersonator"));
            Session::pull("impersonator");
            return response()->redirectTo("/");
        }
    }

    /**
     * Adds a member object to a user.
     *
     * @param $id
     * @return mixed
     */
    public function addMembership($id, Request $request)
    {
        $user = User::findOrFail($id);

        $member = Member::create();
        $member->is_associate = !$request->input('is_primary');
        $member->user()->associate($user);

        $member->save();

        Session::flash("flash_message", "Congratulations! " . $user->name . " is now our newest member!");

        return redirect()->route('user::member::list');
    }

    /**
     * Adds membership end date to member object.
     * Member object will be removed by cron job on end date.
     *
     * @param $id
     * @return mixed
     */
    public function endMembership($id)
    {
        $user = User::findOrFail($id);

        $user->member->delete();

        Session::flash("flash_message", "Membership of " . $user->name . " has been termindated.");

        return redirect()->route('user::member::list');
    }

}
