<?php

namespace Proto\Http\Controllers;

use ApiPostcode\Facade\Postcode;
use Auth;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Proto\Models\Address;
use Proto\Models\User;
use Redirect;
use Session;

class AddressController extends Controller
{
    /**
     * @param Request $request
     * @return View|RedirectResponse
     */
    public function add(Request $request)
    {
        $user = Auth::user();

        if ($user->address) {
            return Redirect::route('user::address::edit', ['id' => $user->id, 'wizard' => $request->wizard]);
        }

        if ($request->has('wizard')) {
            Session::flash('wizard', true);
        }

        return view('users.addresses.edit', ['user' => $user, 'action' => 'add']);
    }

    /**
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request)
    {
        $user = Auth::user();
        $address = new Address();

        return self::saveAddressData($request, $address, $user);
    }

    /**
     * @param Request $request
     * @return View|RedirectResponse
     */
    public function edit(Request $request)
    {
        $user = Auth::user();
        $address = $user->address;

        if ($address == null) {
            Session::flash('flash_message', "We don't have an address for you?");
            return Redirect::back();
        }

        if ($request->has('wizard')) {
            Session::flash('wizard', true);
        }

        return view('users.addresses.edit', ['user' => $user, 'action' => 'edit']);
    }

    /**
     * @param Request $request
     * @return RedirectResponse
     */
    public function update(Request $request)
    {
        $user = Auth::user();
        $address = $user->address;

        if ($address == null) {
            Session::flash('flash_message', "We don't have an address for you?");
            return Redirect::back();
        }

        return self::saveAddressData($request, $address, $user);
    }

    /**
     * @return RedirectResponse
     * @throws Exception
     */
    public function destroy()
    {
        $user = Auth::user();

        if (! $user->address) {
            Session::flash('flash_message', "We don't have an address for you?");
            return Redirect::back();
        }

        if ($user->is_member) {
            Session::flash('flash_message', "You are a member. You can't delete your address!");
            return Redirect::back();
        }

        $user->address->delete();

        Session::flash('flash_message', 'Your address has been deleted.');
        return Redirect::route('user::dashboard');
    }

    /** @return RedirectResponse */
    public function toggleHidden()
    {
        $user = Auth::user();

        $user->address_visible = ! $user->address_visible;
        $user->save();

        Session::flash('flash_message', 'Your primary address is now '.($user->address_visible ? 'visible' : 'hidden').' for members.');
        return Redirect::back();
    }

    /**
     * @param Request $request
     * @param Address $address
     * @param User $user
     * @return RedirectResponse
     */
    public static function saveAddressData(Request $request, $address, $user)
    {
        $addressData = $request->all();
        $addressData['user_id'] = $user->id;

        if ($request->has(['nl-lookup'])) {
            try {
                /** @var \ApiPostcode\Model\Address $fetched_address */
                $fetched_address = Postcode::fetchAddress($addressData['zipcode-nl'], $addressData['number-nl']);

                $address->fill([
                    'street' => $fetched_address->getStreet(),
                    'number' => $fetched_address->getHouseNumber(),
                    'zipcode' => $fetched_address->getZipCode(),
                    'city' => $fetched_address->getCity(),
                    'country' => 'The Netherlands',
                ]);

                Session::flash('flash_message', sprintf(
                    'The address has been saved as: %s %s, %s, %s (%s)',
                    $address->street,
                    $address->number,
                    $address->zipcode,
                    $address->city,
                    $address->country
                ));
            } catch (Exception $e) {
                Session::flash('flash_message', sprintf(
                    'No address could be found for %s, %s.',
                    $addressData['zipcode-nl'],
                    $addressData['number-nl']
                ));

                return Redirect::back();
            }
        } else {
            if (! $address->validate($addressData)) {
                return Redirect::route('user::address::edit')->withErrors($address->errors());
            }
            $address->fill($request->except(['zipcode-nl', 'number-nl']));
            Session::flash('flash_message', 'Your address has been saved!');
        }

        $address['user_id'] = $user->id;
        $address->save();

        if (Session::get('wizard')) {
            return Redirect::route('becomeamember');
        }

        return Redirect::route('user::dashboard');
    }
}
