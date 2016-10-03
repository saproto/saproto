<?php

namespace Proto\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

use PhpParser\Node\Expr\Cast\Object_;
use Proto\Http\Requests;
use Proto\Http\Controllers\Controller;

use Proto\Models\Address;
use Proto\Models\User;

use Auth;
use Entrust;
use Session;
use Redirect;


class AddressController extends Controller
{

    public function addForm($id)
    {
        $user = User::find($id);
        if ($user == null) {
            abort(404);
        }
        if (($user->id != Auth::id()) && (!Auth::user()->can('board'))) {
            abort(403);
        }
        return view('users.addresses.add', ['user' => $user]);
    }

    public function delete($id)
    {
        $user = User::findOrFail($id);
        if (($user->id != Auth::id()) && (!Auth::user()->can('board'))) {
            abort(403);
        }
        if (!$user->address) {
            Session::flash("flash_message", "We don't have an address for you?");
            return Redirect::back();
        }
        if ($user->member != null) {
            Session::flash("flash_message", "You are a member. You can't delete your address!");
            return Redirect::back();
        }
        $user->address->delete();
        Session::flash("flash_message", "Your address has been deleted.");
        return Redirect::route('user::dashboard', ['id' => $id]);
    }

    public function add($id, Request $request)
    {

        $user = User::find($id);

        if ($user == null) {
            abort(404);
        }

        if (($user->id != Auth::id()) && (!Auth::user()->can('board'))) {
            abort(403);
        }

        // Establish new address
        $address = new Address();

        $addressdata = $request->all();
        $addressdata['user_id'] = $user->id;
        if (!$address->validate($addressdata)) {
            return Redirect::route('user::address::add', ['id' => $id])->withErrors($address->errors());
        }
        $address->fill($addressdata);

        // Save it baby!
        $address->save();

        Session::flash("flash_message", "The address has been added.");

        return Redirect::route('user::dashboard', ['id' => $id]);

    }

    public function edit($id, Request $request)
    {

        $user = User::findOrFail($id);
        $address = $user->address;

        if ($address == null) {
            Session::flash("flash_message", "We don't have an address for you?");
            return Redirect::back();
        }

        if (($user->id != Auth::id()) && (!Auth::user()->can('board'))) {
            abort(403);
        }

        $addressdata = $request->all();
        $addressdata['user_id'] = $user->id;

        if (!$address->validate($addressdata)) {
            return Redirect::route('user::address::edit', ['id' => $id])->withErrors($address->errors());
        }
        $address->fill($addressdata);
        $address->save();

        Session::flash("flash_message", "The address has been edited.");
        return Redirect::route('user::dashboard', ['id' => $id]);

    }

    public function editForm($id)
    {

        $user = User::findOrFail($id);
        $address = $user->address;

        if ($address == null) {
            Session::flash("flash_message", "We don't have an address for you?");
            return Redirect::back();
        }

        if (($user->id != Auth::id()) && (!Auth::user()->can('board'))) {
            abort(403);
        }

        return view('users.addresses.edit', ['user' => $user, 'address' => $address]);
    }

    public function toggleHidden($id, Request $request)
    {

        $user = User::find($id);

        if ($user == null) {
            abort(404);
        }

        if (($user->id != Auth::id()) && (!Auth::user()->can('board'))) {
            abort(403);
        }

        $user->address_visible = !$user->address_visible;
        $user->save();

        Session::flash("flash_message", "Your primary address is now " . ($user->address_visible ? 'visible' : 'hidden') . " for members.");

        return Redirect::back();

    }

}