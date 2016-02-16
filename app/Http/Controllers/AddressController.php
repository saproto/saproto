<?php

namespace Proto\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

use Proto\Http\Requests;
use Proto\Http\Controllers\Controller;

use Proto\Models\User;

use Auth;
use Entrust;


class AddressController extends Controller
{

    public function addForm($id) {
        $user = User::find($id);
        if ($user == null) {
            abort(404, "Member $id not found.");
        }
        if (($user->id != Auth::id()) && (!Auth::user()->can('board'))) {
            abort(403, "You cannot add an address for " . $user->name . ".");
        }
        return view('users.addresses.add', ['user' => $user]);
    }

}