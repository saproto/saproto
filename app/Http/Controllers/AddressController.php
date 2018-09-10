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

    public function addForm(Request $request)
    {
        $user = Auth::user();

        if ($user->address) {
            return Redirect::route('user::address::edit', ['id' => $user->id, 'wizard' => $request->wizard]);
        }

        if ($request->wizard) Session::flash("wizard", true);

        return view('users.addresses.add', ['user' => $user]);
    }

    public function delete()
    {
        $user = Auth::user();
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
        return Redirect::route('user::dashboard');
    }

    public function add(Request $request)
    {

        $user = Auth::user();

        // Establish new address
        $address = new Address();

        $addressdata = $request->all();
        $addressdata['user_id'] = $user->id;
        if (!$address->validate($addressdata)) {
            return Redirect::route('user::address::add')->withErrors($address->errors());
        }
        $address->fill($addressdata);

        // Save it baby!
        $address->save();

        Session::flash("flash_message", "The address has been added.");

        if (Session::get('wizard')) return Redirect::route('becomeamember');

        return Redirect::route('user::dashboard');

    }

    public function edit(Request $request)
    {

        $user = Auth::user();
        $address = $user->address;

        if ($address == null) {
            Session::flash("flash_message", "We don't have an address for you?");
            return Redirect::back();
        }

        $addressdata = $request->all();
        $addressdata['user_id'] = $user->id;

        if (!$address->validate($addressdata)) {
            return Redirect::route('user::address::edit')->withErrors($address->errors());
        }
        $address->fill($addressdata);
        $address->save();

        Session::flash("flash_message", "The address has been edited.");

        if (Session::get('wizard')) return Redirect::route('becomeamember');

        return Redirect::route('user::dashboard');

    }

    public function editForm(Request $request)
    {

        $user = Auth::user();
        $address = $user->address;

        if ($address == null) {
            Session::flash("flash_message", "We don't have an address for you?");
            return Redirect::back();
        }

        if ($request->wizard) Session::flash("wizard", true);

        return view('users.addresses.edit', ['user' => $user, 'address' => $address]);
    }

    public function toggleHidden()
    {

        $user = Auth::user();

        $user->address_visible = !$user->address_visible;
        $user->save();

        Session::flash("flash_message", "Your primary address is now " . ($user->address_visible ? 'visible' : 'hidden') . " for members.");

        return Redirect::back();

    }

}