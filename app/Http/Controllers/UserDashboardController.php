<?php

namespace Proto\Http\Controllers;

use Illuminate\Http\Request;
use PragmaRX\Google2FA\Google2FA;

use Redirect;
use Hash;

use Proto\Http\Requests;
use Proto\Http\Controllers\Controller;

use Proto\Models\User;

use Auth;
use Session;
use Validator;

class UserDashboardController extends Controller
{

    /**
     * Display the dashboard for a specific user.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id = null)
    {
        if ($id == null) {
            $id = Auth::id();
        }

        $user = User::find($id);

        if ($user == null) {
            abort(404);
        }

        if ($user->id != Auth::id() && !Auth::user()->can('board')) {
            abort(403);
        }

        $qrcode = null;
        $tfakey = null;
        if (!$user->tfa_totp_key) {
            $google2fa = new Google2FA();
            $tfakey = $google2fa->generateSecretKey(32);
            $qrcode = $google2fa->getQRCodeGoogleUrl('S.A.%20Proto', str_replace(' ', '%20', $user->name), $tfakey);
        }

        $utwente = null;
        if ($user->utwente_username) {
            $data = json_decode(file_get_contents(getenv("LDAP_URL") . "?query=uid=" . md5($user->utwente_username)));
            if ($data->count > 0) {
                $utwente = $data->entries[0];
            }
        }

        return view('users.dashboard.dashboard', ['user' => $user, 'tfa_qrcode' => $qrcode, 'tfa_key' => $tfakey, 'utwente' => $utwente]);
    }

    public function update($id = null, Request $request)
    {
        if ($id == null) {
            $id = Auth::id();
        }

        $user = User::find($id);

        if ($user == null) {
            abort(404);
        }

        if ($user->id != Auth::id() && !Auth::user()->can('board')) {
            abort(403);
        }


        $userdata['email'] = $request->input('email');
        $userdata['phone'] = str_replace(' ', '', $request->input('phone'));
        $userdata['website'] = $request->input('website');
        $userdata['phone_visible'] = $request->has('phone_visible');
        $userdata['receive_sms'] = $request->has('receive_sms');

        $validator = Validator::make($userdata, [
            'email' => 'required|email',
            'phone' => 'required|regex:(\+[0-9]{8,16})'
        ]);

        if ($validator->fails()) {
            return Redirect::route('user::dashboard', ['id' => $user->id])->withErrors($validator);
        }

        $user->fill($userdata);
        $user->save();
        Session::flash("flash_message", "Changes saved.");
        return Redirect::route('user::dashboard', ['id' => $user->id]);

    }

    public function becomeAMemberOf()
    {
        if (Auth::check()) {
            $user = Auth::user();
        } else {
            $user = null;
        }
        return view("users.becomeamember", ['user' => $user]);
    }

}
