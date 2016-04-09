<?php

namespace Proto\Http\Controllers;

use Illuminate\Http\Request;
use Redirect;
use Hash;

use Proto\Http\Requests;
use Proto\Http\Controllers\Controller;

use Proto\Models\User;

use Auth;
use Session;

class UserProfileController extends Controller
{

    /**
     * Display the profile for a specific user.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id = null)
    {
        if ($id == null) {
            $id = Auth::id();
        }

        $user = User::find($id);

        if ($user == null) {
            abort(404, "This user does not exist.");
        }

        $ldap = null;
        if ($user->utwente_username) {
            $data = json_decode(file_get_contents(getenv("LDAP_URL") . "?query=uid=" . md5($user->utwente_username)));
            if ($data->count > 0) {
                $ldap = $data->entries[0];
            }
        }

        return view('users.profile.profile', ['user' => $user, 'ldap' => $ldap]);
    }

}
