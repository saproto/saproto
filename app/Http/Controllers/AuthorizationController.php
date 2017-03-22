<?php

namespace Proto\Http\Controllers;

use Illuminate\Http\Request;

use Proto\Http\Requests;
use Proto\Http\Controllers\Controller;

use Proto\Models\Permission;
use Proto\Models\Role;
use Proto\Models\User;

use Redirect;

class AuthorizationController extends Controller
{

    public function index()
    {
        $roles = Role::all();
        $permissions = Permission::all();
        return view('authorization.overview', ['roles' => $roles, 'permissions' => $permissions]);
    }

    public function grant(Request $request, $id)
    {
        if ($id == config('proto.rootrole')) {
            $request->session()->flash('flash_message', 'This role can only be manually added in the database.');
            return Redirect::back();
        }

        $role = Role::findOrFail($id);
        $user = User::findOrFail($request->user);
        $user->roles()->attach($role->id);

        $request->session()->flash('flash_message', $user->name . ' has been granted <strong>' . $role->name . '</strong>.');
        return Redirect::back();
    }

    public function revoke(Request $request, $id, $user)
    {
        if ($id == config('proto.rootrole')) {
            $request->session()->flash('flash_message', 'This role can only be manually removed in the database.');
            return Redirect::back();
        }

        $role = Role::findOrFail($id);
        $user = User::findOrFail($user);
        $user->roles()->detach($role->id);
        
        // Call Herbert webhook to run check through all connected admins. Will result in kick for users whose
        // temporary adminpowers were removed.
        file_get_contents(env('HERBERT_SERVER') . "/adminCheck");

        $request->session()->flash('flash_message', '<strong>' . $role->name . '</strong> has been revoked from ' . $user->name . '.');
        return Redirect::back();
    }


}
