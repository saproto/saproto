<?php

namespace Proto\Http\Controllers;

use Illuminate\Http\Request;

use Proto\Http\Requests;
use Proto\Http\Controllers\Controller;

use PragmaRX\Google2FA\Google2FA;
use Proto\Models\User;

use Auth;
use Redirect;

class TFAController extends Controller
{

    public function timebasedPost(Request $request, $user_id, Google2FA $google2fa)
    {

        $user = User::findOrFail($user_id);

        if (($user->id != Auth::id()) && (!Auth::user()->can('board'))) {
            abort(403);
        }

        $code = $request->input('2facode');
        $secret = $request->input('2fakey');

        if ($google2fa->verifyKey($secret, $code)) {

            $user->tfa_totp_key = $secret;
            $user->save();

            $request->session()->flash('flash_message', 'Time-Based 2 Factor Authentication enabled!');
            return Redirect::route('user::dashboard', ['id' => $user->id]);

        } else {

            $request->session()->flash('flash_message', 'The code you entered is not correct. Remove the account from your 2FA app and try again.');
            return Redirect::route('user::dashboard', ['id' => $user->id]);

        }

    }

    public function timebasedDelete($user_id, Request $request)
    {

        $user = User::findOrFail($user_id);

        if (($user->id != Auth::id()) && (!Auth::user()->can('board'))) {
            abort(403);
        }

        if ($user->tfa_totp_key !== null) {
            $user->tfa_totp_key = null;
            $user->save();
        }

        $request->session()->flash('flash_message', 'Time-Based 2 Factor Authentication disabled!');
        return Redirect::route('user::dashboard', ['id' => $user->id]);

    }

}
