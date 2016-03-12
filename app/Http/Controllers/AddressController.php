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
            abort(404, "Member $id not found.");
        }
        if (($user->id != Auth::id()) && (!Auth::user()->can('board'))) {
            abort(403, "You cannot add an address for this user.");
        }
        return view('users.addresses.add', ['user' => $user]);
    }

    public function delete($id, $address_id)
    {
        $user = User::find($id);
        if ($user == null) {
            abort(404, "Member $id not found.");
        }
        if (($user->id != Auth::id()) && (!Auth::user()->can('board'))) {
            abort(403, "You cannot delete an address for this user.");
        }
        $address = Address::find($address_id);
        if ($address == null) {
            abort(404, "Address $address_id not found.");
        }
        if ($address->is_primary && $user->member != null) {
            abort(404, "Cannot delete primary address of a member.");
        }
        $address->delete();
        Session::flash("flash_message", "Your address has been deleted.");
        return Redirect::route('user::dashboard', ['id' => $id]);
    }

    public function makePrimary($id, $address_id)
    {
        $user = User::find($id);
        if ($user == null) {
            abort(404, "Member $id not found.");
        }
        if (($user->id != Auth::id()) && (!Auth::user()->can('board'))) {
            abort(403, "You cannot update primary address for this user.");
        }
        $address = Address::find($address_id);
        if ($address == null) {
            abort(404, "Address $address_id not found.");
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
            abort(404, "Member $id not found.");
        }

        if (($user->id != Auth::id()) && (!Auth::user()->can('board'))) {
            abort(403, "You cannot add an address for this user.");
        }

        // Establish new address
        $address = new Address($this->parseInput($request));
        $address->user_id = $id;

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
            abort(404, "Address $address_id not found.");
        }

        if ($user == null) {
            abort(404, "Member $id not found.");
        }

        if (($user->id != Auth::id()) && (!Auth::user()->can('board'))) {
            abort(403, "You cannot edit an address for this user.");
        }

        $address->fill($this->parseInput($request));
        $address->save();

        Session::flash("flash_message", "The address has been edited.");

        return Redirect::route('user::dashboard', ['id' => $id]);

    }

    public function editForm($id, $address_id)
    {
        $address = Address::find($address_id);
        if ($address == null) {
            abort(404, "Address $id not found.");
        }
        $user = $address->user;
        if ($user == null) {
            abort(404, "Member $id not found.");
        }
        if (($user->id != Auth::id()) && (!Auth::user()->can('board'))) {
            abort(403, "You cannot edit an address for this user.");
        }
        return view('users.addresses.edit', ['user' => $user, 'address' => $address]);
    }

    private function parseInput($request)
    {
        $newaddress = json_decode($request->input("address-data"));

        $address = array();

        if ($newaddress == null) {
            abort(500, "Missing an address.");
        }

        if (!property_exists($newaddress, 'street') || $newaddress->street == "") {
            abort(500, "Address is missing a street name.");
        } else {
            $address['street'] = $newaddress->street;
        }

        if (!property_exists($newaddress, 'number') || $newaddress->number == "") {
            abort(500, "Address is missing a street number.");
        } else {
            $address['number'] = $newaddress->number;
        }

        if (!property_exists($newaddress, 'zipcode') || $newaddress->zipcode == "") {
            abort(500, "Address is missing a zipcode.");
        } else {
            $address['zipcode'] = $newaddress->zipcode;
        }

        if (!property_exists($newaddress, 'city') || $newaddress->city == "") {
            abort(500, "Address is missing a city.");
        } else {
            $address['city'] = $newaddress->city;
        }

        if (!property_exists($newaddress, 'country') || $newaddress->country == "") {
            abort(500, "Address is missing a country.");
        } else {
            $address['country'] = $newaddress->country;
        }

        return $address;
    }

    public function toggleHidden($id, Request $request)
    {

        $user = User::find($id);

        if ($user == null) {
            abort(404, "Member $id not found.");
        }

        if (($user->id != Auth::id()) && (!Auth::user()->can('board'))) {
            abort(403, "You cannot toggle address visibility for this user.");
        }

        $user->address_visible = !$user->address_visible;
        $user->save();

        Session::flash("flash_message", "Your primary address is now " . ($user->address_visible ? 'visible' : 'hidden') . " for members.");

        return Redirect::back();

    }

}