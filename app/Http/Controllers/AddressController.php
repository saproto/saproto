<?php

namespace Proto\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

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

    public function delete($id, $address_id) {
        $user = User::find($id);
        if ($user == null) {
            abort(404, "Member $id not found.");
        }
        if (($user->id != Auth::id()) && (!Auth::user()->can('board'))) {
            abort(403, "You cannot delete an address for " . $user->name . ".");
        }
        $address = Address::find($address_id);
        if ($address == null) {
            abort(404, "Address $address_id not found.");
        }
        if ($address->is_primary && $user->member != null) {
            abort(404, "Cannot delete primary address of a member.");
        }
        $address->delete();
        Session::flash("flash_message","Deleted address.");
        return Redirect::route('user::profile', ['id' => $id]);
    }

    public function makePrimary($id, $address_id) {
        $user = User::find($id);
        if ($user == null) {
            abort(404, "Member $id not found.");
        }
        if (($user->id != Auth::id()) && (!Auth::user()->can('board'))) {
            abort(403, "You cannot update primary address for " . $user->name . ".");
        }
        $address = Address::find($address_id);
        if ($address == null) {
            abort(404, "Address $address_id not found.");
        }
        foreach($user->address as $address) {
            if ($address->id != $address_id) {
                $address->is_primary = false;
            } else {
                $address->is_primary = true;
            }
            $address->save();
        }
        Session::flash("flash_message","Primary address updated.");
        return Redirect::route('user::profile', ['id' => $id]);
    }

    public function add($id, Request $request) {

        $user = User::find($id);

        if ($user == null) {
            abort(404, "Member $id not found.");
        }

        if (($user->id != Auth::id()) && (!Auth::user()->can('board'))) {
            abort(403, "You cannot add an address for " . $user->name . ".");
        }

        $newaddress = json_decode($request->input("address-data"));

        // Establish new address
        $address = new Address();
        $address->street = $newaddress->street;
        $address->number = $newaddress->number;
        $address->zipcode = $newaddress->zipcode;
        $address->city = $newaddress->city;
        $address->country = $newaddress->country;
        $address->user_id = $user->id;

        // See if we have a primary address already...
        $address->is_primary = true;
        foreach($user->address as $a) {
            if ($a->is_primary == true) {
                $address->is_primary = false;
                break;
            }
        }

        // Save it baby!
        $address->save();

        Session::flash("flash_message","Address added.");

        return Redirect::route('user::profile', ['id' => $id]);

    }

}