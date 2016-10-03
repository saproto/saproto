<?php

namespace Proto\Http\Controllers;

use Illuminate\Http\Request;

use Proto\Http\Middleware\Member;
use Proto\Http\Requests;
use Proto\Http\Controllers\Controller;

use PragmaRX\Google2FA\Google2FA;

use Proto\Models\Achievement;
use Proto\Models\AchievementOwnership;
use Proto\Models\Address;
use Proto\Models\Alias;
use Proto\Models\Bank;
use Proto\Models\EmailList;
use Proto\Models\EmailListSubscription;
use Proto\Models\Quote;
use Proto\Models\RfidCard;
use Proto\Models\StudyEntry;
use Proto\Models\User;

use Auth;
use Redirect;
use Yubikey;
use Hash;
use Mail;

class AuthController extends Controller
{

    public function getLogin()
    {
        if (Auth::check()) {
            return Redirect::route('homepage');
        } else {
            return view('auth.login');
        }
    }

    /**
     * This static function takes a supplied username and password, and returns the associated user if the combination is valid. Accepts either e-mail / password or UTwente credentials.
     *
     * @param $username The e-mail address or UTwente username.
     * @param $password The password or UTwente password.
     * @return User The user associated with the credentials, or null if no user could be found or credentials are invalid.
     */
    public static function verifyCredentials($username, $password)
    {

        // First, we try matching our own records.
        $user = User::where('email', $username)->first();

        // See if we can authenticate the user ourselves.
        if ($user && Hash::check($password, $user->password)) {

            return $user;

        } else {

            // We cannot authenticate to our own records. Try RADIUS.
            $user = User::where('utwente_username', $username)->first();

            if ($user) {

                if (AuthController::verifyUtwenteCredentials($user->utwente_username, $password)) {
                    return $user;
                }

            }

        }

        return null;

    }


    public static function verifyUtwenteCredentials($username, $password)
    {

        // Do weird escape character stuff, because DotEnv doesn't support newlines :(
        $publicKey = str_replace('_!n_', "\n", env('UTWENTEAUTH_KEY'));

        $token = md5(rand()); // Generate random token

        // Store userdata in array to create JSON later on
        $userData = array(
            'user' => $username,
            'password' => $password,
            'token' => $token
        );

        // Encrypt userData in JSON with public key
        openssl_public_encrypt(json_encode($userData), $userDataEncrypted, $publicKey);

        // Start CURL to secureAuth on WESP
        $ch = curl_init(env('UTWENTEAUTH_SRV'));

        // Tell CURL to post encrypted userData in base64
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, "challenge=" . urlencode(base64_encode($userDataEncrypted)));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        // Execute CURL, store response
        $response = curl_exec($ch);
        curl_close($ch);

        // If response matches token, user is verified.
        if ($response == $token) {
            return true;
        }

        return false;

    }

    public function postLogin(Request $request, Google2FA $google2fa)
    {

        if (Auth::check()) {
            return Redirect::route('homepage');
        } else {

            if ($request->session()->has('2fa_user') && ($request->has('2fa_totp_token') || $request->has('2fa_yubikey_token'))) {

                if ($request->has('2fa_totp_token') && $request->has('2fa_yubikey_token')) {

                    $request->session()->flash('flash_message', 'Please enter only one of the tokens.');
                    $request->session()->reflash();
                    return view('auth.2fa');

                } elseif ($request->session()->get('2fa_user')->tfa_totp_key && $request->has('2fa_totp_token') && $request->input('2fa_totp_token') != '') {

                    // Catching Two Factor Authentication attempt
                    if ($google2fa->verifyKey($request->session()->get('2fa_user')->tfa_totp_key, $request->input('2fa_totp_token'))) {
                        Auth::login($request->session()->get('2fa_user'), $request->session()->get('2fa_remember'));
                        return Redirect::intended(route('homepage'));
                    } else {
                        $request->session()->flash('flash_message', 'Invalid TOTP. Please try again.');
                        $request->session()->reflash();
                        return view('auth.2fa');
                    }

                } elseif ($request->session()->get('2fa_user')->tfa_yubikey_identity && $request->has('2fa_yubikey_token') && $request->input('2fa_yubikey_token') != '') {

                    try {

                        if (Yubikey::verify($request->input('2fa_yubikey_token'))) {
                            Auth::login($request->session()->get('2fa_user'), $request->session()->get('2fa_remember'));
                            return Redirect::intended(route('homepage'));
                        } else {
                            $request->session()->flash('flash_message', 'Invalid YubiKey token. Please try again.');
                            $request->session()->reflash();
                            return view('auth.2fa');
                        }

                    } catch (\Exception $e) {
                        $request->session()->flash('flash_message', $e->getMessage());
                        $request->session()->reflash();
                        return view('auth.2fa');
                    }

                } else {

                    $request->session()->flash('flash_message', 'Invalid authentication attempt. Try again.');
                    $request->session()->reflash();
                    return view('auth.2fa');

                }

            } else {

                // This is the real deal!
                $username = $request->input('email');
                $password = $request->input('password');
                $remember = $request->input('remember');

                $user = AuthController::verifyCredentials($username, $password);

                if ($user) {

                    // Catch users that have 2FA enabled.
                    if ($user->tfa_totp_key || $user->tfa_yubikey_identity) {
                        $request->session()->flash('2fa_user', $user);
                        $request->session()->flash('2fa_remember', $remember);
                        return view('auth.2fa');
                    } else {
                        Auth::login($user, $remember);
                        return Redirect::intended(route('homepage'));
                    }

                }

            }

        }

        $request->session()->flash('flash_message', 'Invalid username of password provided.');
        return Redirect::route('login::show');

    }

    public function getLogout()
    {
        Auth::logout();
        return Redirect::route('homepage');
    }

    public function getRegister(Request $request)
    {
        if (Auth::check()) {
            $request->session()->flash('flash_message', 'You already have an account. To register an account, please log off.');
            return Redirect::route('user::dashboard');
        }
        return view('users.register');
    }

    public function postRegister(Request $request)
    {
        if (Auth::check()) {
            $request->session()->flash('flash_message', 'You already have an account. To register an account, please log off.');
            return Redirect::route('user::dashboard');
        }

        $request->session()->flash('register_persist', $request->all());

        $this->validate($request, [
            'email' => 'required|email|unique:users',
            'name' => 'required|string',
            'calling_name' => 'required|string',
            'birthdate' => 'required|date_format:Y-m-d',
            'gender' => 'required|in:1,2,9',
            'nationality' => 'required|string',
            'phone' => 'required|regex:(\+[0-9]{8,16})',
            'g-recaptcha-response' => 'required|recaptcha'
        ]);

        $user = User::create($request->except('g-recaptcha-response'));

        $password = str_random(16);
        $user->password = Hash::make($password);

        $user->save();

        Mail::send('emails.registration', ['user' => $user, 'password' => $password], function ($m) use ($user) {
            $m->replyTo('board@proto.utwente.nl', 'Study Association Proto');
            $m->to($user->email, $user->name);
            $m->subject('Account registration at Study Association Proto');
        });

        if (!Auth::check()) {
            $request->session()->flash('flash_message', 'Your account has been created. You will receive an e-mail with your password shortly.');
            return Redirect::route('homepage');
        }
    }

    public function deleteUser(Request $request, $id)
    {
        $user = User::findOrFail($id);

        if ($user->id != Auth::id() && !Auth::user()->can('board')) {
            abort(403);
        }

        Address::where('user_id', $user->id)->delete();
        Bank::where('user_id', $user->id)->delete();
        EmailListSubscription::where('user_id', $user->id)->delete();
        AchievementOwnership::where('user_id', $user->id)->delete();
        StudyEntry::where('user_id', $user->id)->forceDelete();
        Member::where('user_id', $user->id)->forceDelete();
        Alias::where('user_id', $user->id)->delete();
        Quote::where('user_id', $user->id)->delete();
        RfidCard::where('user_id', $user->id)->delete();

        if ($user->photo) {
            $user->photo->delete();
        }

        $user->password = null;
        $user->remember_token = null;
        $user->birthdate = null;
        $user->gender = null;
        $user->nationality = null;
        $user->phone = null;
        $user->website = null;
        $user->utwente_username = null;
        $user->tfa_totp_key = null;
        $user->tfa_yubikey_identity = null;

        $user->phone_visible = 0;
        $user->address_visible = 0;
        $user->receive_sms = 0;

        $user->save();

        $user->delete();

        $request->session()->flash('flash_message', 'Your account has been deleted.');
        return Redirect::route('homepage');
    }

}
