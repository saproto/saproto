<?php

namespace Proto\Http\Controllers;

use ApiPostcode\Facade\Postcode;
use Illuminate\Http\Request;

use Proto\Models\Address;

use Auth;
use Session;
use Redirect;
use PostcodeApi;

use Exception;


class AddressController extends Controller
{

    public function addForm(Request $request)
    {
        $user = Auth::user();

        if ($user->address) {
            return Redirect::route('user::address::edit', ['id' => $user->id, 'wizard' => $request->wizard]);
        }

        if ($request->has('wizard')) Session::flash("wizard", true);

        return view('users.addresses.edit', ['user' => $user, 'action' => 'add']);
    }

    public function delete()
    {
        $user = Auth::user();
        if (!$user->address) {
            Session::flash("flash_message", "We don't have an address for you?");
            return Redirect::back();
        }
        if ($user->is_member) {
            Session::flash("flash_message", "You are a member. You can't delete your address!");
            return Redirect::back();
        }
        $user->address->delete();
        Session::flash("flash_message", "Your address has been deleted.");
        return Redirect::route('user::dashboard');
    }

    public function add(Request $request)
    {

        $user = Auth::user();

        // Establish new address
        $address = new Address();

        return AddressController::saveAddressData($request, $address, $user);

    }

    public function edit(Request $request)
    {

        $user = Auth::user();
        $address = $user->address;

        if ($address == null) {
            Session::flash("flash_message", "We don't have an address for you?");
            return Redirect::back();
        }

        return AddressController::saveAddressData($request, $address, $user);

    }

    public function editForm(Request $request)
    {
        $user = Auth::user();
        $address = $user->address;

        if ($address == null) {
            Session::flash("flash_message", "We don't have an address for you?");
            return Redirect::back();
        }

        if ($request->has('wizard')) Session::flash("wizard", true);

        return view('users.addresses.edit', ['user' => $user, 'address' => $address, 'action' => 'edit']);
    }

    public function toggleHidden()
    {

        $user = Auth::user();

        $user->address_visible = !$user->address_visible;
        $user->save();

        Session::flash("flash_message", "Your primary address is now " . ($user->address_visible ? 'visible' : 'hidden') . " for members.");

        return Redirect::back();

    }

    public static function saveAddressData($request, $address, $user)
    {

        $addressdata = $request->all();
        $addressdata['user_id'] = $user->id;

        if ($request->has(['nl-lookup'])) {

            try {
                $fetched_address = PostcodeApi::create('ApiPostcode')->findByPostcodeAndHouseNumber($addressdata['zipcode-nl'], $addressdata['number-nl']);
                $fetched_address_array = $fetched_address->toArray();
                $address->fill([
                    'street' => $fetched_address_array['street'],
                    'number' => $fetched_address_array['house_no'],
                    'zipcode' => $addressdata['zipcode-nl'],
                    'city' => $fetched_address_array['town'],
                    'country' => 'The Netherlands'
                ]);

                Session::flash("flash_message", sprintf("The address has been saved as: %s %s, %s, %s (%s)",
                    $address->street, $address->number, $address->zipcode, $address->city, $address->country));
            } catch (Exception $e) {
                Session::flash("flash_message", sprintf("No address could be found for %s, %s.",
                    $addressdata['zipcode-nl'], $addressdata['number-nl']));
                    return Redirect::back();
            }

        } else {

            if (!$address->validate($addressdata)) {
                return Redirect::route('user::address::edit')->withErrors($address->errors());
            }
            $address->fill($request->except(['zipcode-nl', 'number-nl']));
            Session::flash("flash_message", "Your address has been saved!");

        }

        $address['user_id'] = $user->id;
        $address->save();

        if (Session::get('wizard')) return Redirect::route('becomeamember');

        return Redirect::route('user::dashboard');

    }

}