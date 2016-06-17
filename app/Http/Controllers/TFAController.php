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

    public function timebasedForm($user_id, Request $request, Google2FA $google2fa)
    {
        $user = User::findOrFail($user_id);

        if (($user->id != Auth::id()) && (!Auth::user()->can('board'))) {
            abort(403);
        }

        $secret = ($request->session()->has('2fa_secret') ? $request->session()->get('2fa_secret') : $google2fa->generateSecretKey(32));
        $request->session()->flash('2fa_secret', $secret);
        $qrcode = $google2fa->getQRCodeGoogleUrl('S.A. Proto', $user->name, $secret);

        return view('users.2fa.timebased', ['user' => $user, 'qrcode' => $qrcode, 'secret' => $secret]);
    }

    public function timebasedPost($user_id, Request $request, Google2FA $google2fa)
    {

        $user = User::findOrFail($user_id);

        if (($user->id != Auth::id()) && (!Auth::user()->can('board'))) {
            abort(403);
        }

        if (!$request->session()->has('2fa_secret')) {
            return Redirect::route('user::2fa::addtimebased', ['user_id' => $user->id]);
        }

        $code = $request->input('2facode');
        $secret = $request->session()->get('2fa_secret');

        if ($google2fa->verifyKey($secret, $code)) {

            $user->tfa_totp_key = $secret;
            $user->save();

            $request->session()->flash('flash_message', 'Time-Based 2 Factor Authentication enabled!');
            return Redirect::route('user::dashboard', ['id' => $user->id]);

        } else {

            $request->session()->reflash();
            $request->session()->flash('flash_message', 'The code you entered is not correct. Try again.');
            return Redirect::route('user::2fa::addtimebased', ['user_id' => $user->id]);

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
