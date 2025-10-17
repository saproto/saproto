<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\Factory;
use App\Models\Address;
use App\Models\User;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\View\View;

class AddressController extends Controller
{
    /**
     * @return View|RedirectResponse
     */
    public function create(Request $request)
    {
        $user = Auth::user();

        if ($user->address) {
            return to_route('user::address::edit', ['id' => $user->id, 'wizard' => $request->wizard]);
        }

        if ($request->has('wizard')) {
            Session::flash('wizard');
        }

        return view('users.addresses.edit', ['user' => $user, 'action' => 'add']);
    }

    /**
     * @return RedirectResponse
     */
    public function store(Request $request)
    {
        $user = Auth::user();

        // Establish new address
        $address = new Address;

        return self::saveAddressData($request, $address, $user);
    }

    /**
     * @return View|RedirectResponse
     */
    public function edit(Request $request): RedirectResponse|Factory|\Illuminate\Contracts\View\View
    {
        $user = Auth::user();
        $address = $user->address;

        if ($address == null) {
            Session::flash('flash_message', "We don't have an address for you?");

            return back();
        }

        if ($request->has('wizard')) {
            Session::flash('wizard', true);
        }

        return view('users.addresses.edit', ['user' => $user, 'address' => $address, 'action' => 'edit']);
    }

    /**
     * @return RedirectResponse
     */
    public function update(Request $request)
    {
        $user = Auth::user();
        $address = $user->address;

        if ($address == null) {
            Session::flash('flash_message', "We don't have an address for you?");

            return back();
        }

        return self::saveAddressData($request, $address, $user);
    }

    /**
     * @return RedirectResponse
     *
     * @throws Exception
     */
    public function destroy()
    {
        $user = Auth::user();
        if (! $user->address) {
            Session::flash('flash_message', "We don't have an address for you?");

            return back();
        }

        if ($user->is_member) {
            Session::flash('flash_message', "You are a member. You can't delete your address!");

            return back();
        }

        $user->address->delete();

        Session::flash('flash_message', 'Your address has been deleted.');

        return to_route('user::dashboard::show');
    }

    public function toggleHidden(): RedirectResponse
    {
        $user = Auth::user();

        $user->address_visible = ! $user->address_visible;
        $user->save();

        Session::flash('flash_message', 'Your primary address is now '.($user->address_visible ? 'visible' : 'hidden').' for members.');

        return back();
    }

    /**
     * @return RedirectResponse
     */
    public static function saveAddressData(Request $request, Address $address, User $user)
    {
        $addressdata = $request->all();
        $addressdata['user_id'] = $user->id;

        if (! $address->validate($addressdata)) {
            return to_route('user::address::edit')->withErrors($address->errors());
        }

        $address->fill($addressdata);
        Session::flash('flash_message', 'Your address has been saved!');

        $address->save();

        if (Session::get('wizard')) {
            return to_route('becomeamember');
        }

        return to_route('user::dashboard::show');
    }
}
