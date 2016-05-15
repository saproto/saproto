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

    public function delete($id, $address_id)
    {
        $user = User::find($id);
        if ($user == null) {
            abort(404);
        }
        if (($user->id != Auth::id()) && (!Auth::user()->can('board'))) {
            abort(403);
        }
        $address = Address::find($address_id);
        if ($address == null) {
            abort(404);
        }
        if ($address->is_primary && $user->member != null) {
            abort(404);
        }
        $address->delete();
        Session::flash("flash_message", "Your address has been deleted.");
        return Redirect::route('user::dashboard', ['id' => $id]);
    }

    public function makePrimary($id, $address_id)
    {
        $user = User::find($id);
        if ($user == null) {
            abort(404);
        }
        if (($user->id != Auth::id()) && (!Auth::user()->can('board'))) {
            abort(403);
        }
        $address = Address::find($address_id);
        if ($address == null) {
            abort(404);
        }
        foreach ($user->address as $address) {
            if ($address->id != $address_id) {
                $address->is_primary = false;
            } else {
                $address->is_primary = true;
            }
            $address->save();
        }
        Session::flash("flash_message", "Your primary address has been saved.");
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

        // See if we have a primary address already...
        $address->is_primary = true;
        foreach ($user->address as $a) {
            if ($a->is_primary == true) {
                $address->is_primary = false;
                break;
            }
        }

        // Save it baby!
        $address->save();

        Session::flash("flash_message", "The address has been added.");

        return Redirect::route('user::dashboard', ['id' => $id]);

    }

    public function edit($id, $address_id, Request $request)
    {

        $address = Address::find($address_id);
        $user = $address->user;

        if ($address == null) {
            abort(404);
        }

        if ($user == null) {
            abort(404);
        }

        if (($user->id != Auth::id()) && (!Auth::user()->can('board'))) {
            abort(403);
        }

        $addressdata = $request->all();
        $addressdata['user_id'] = $user->id;

        if (!$address->validate($addressdata)) {
            return Redirect::route('user::address::edit', ['id' => $id, 'address_id' => $address_id])->withErrors($address->errors());
        }
        $address->fill($addressdata);
        $address->save();

        Session::flash("flash_message", "The address has been edited.");

        return Redirect::route('user::dashboard', ['id' => $id]);

    }

    public function editForm($id, $address_id)
    {
        $address = Address::find($address_id);
        if ($address == null) {
            abort(404);
        }
        $user = $address->user;
        if ($user == null) {
            abort(404);
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