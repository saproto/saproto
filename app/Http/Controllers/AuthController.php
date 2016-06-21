<?php

namespace Proto\Http\Controllers;

use Illuminate\Http\Request;

use Proto\Http\Requests;
use Proto\Http\Controllers\Controller;

use PragmaRX\Google2FA\Google2FA;

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

                // First, we try matching our own records.
                $user = User::where('email', $username)->first();

                // See if we can authenticate the user ourselves.
                if ($user && Hash::check($password, $user->password)) {

                    // Catch users that have 2FA enabled.
                    if ($user->tfa_totp_key || $user->tfa_yubikey_identity) {
                        $request->session()->flash('2fa_user', $user);
                        $request->session()->flash('2fa_remember', $remember);
                        return view('auth.2fa');
                    } else {
                        Auth::login($user, $remember);
                        return Redirect::intended(route('homepage'));
                    }

                } else {

                    // We cannot authenticate to our own records. Try RADIUS.
                    $user = User::where('utwente_username', $username)->first();

                    if ($user) {

                        // Do weird escape character stuff, because DotEnv doesn't support newlines :(
                        $publicKey = str_replace('_!n_', "\n", env('UTWENTEAUTH_KEY'));

                        $token = md5(rand()); // Generate random token

                        // Store userdata in array to create JSON later on
                        $userData = array(
                            'user' => $user->utwente_username,
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

        $this->validate($request, [
            'email' => 'required|email|unique:users',
            'name_first' => 'required|string',
            'name_last' => 'required|string',
            'name_initials' => 'required|regex:(([A-Za-z]\.)+)',
            'birthdate' => 'required|date_format:Y-m-d',
            'gender' => 'required|in:1,2,9',
            'nationality' => 'required|string',
            'phone' => 'required|regex:(\+[0-9]{1,16})',
            'g-recaptcha-response' => 'required|recaptcha'
        ]);

        $user = User::create($request->except('g-recaptcha-response'));

        $password = str_random(16);
        $user->password = Hash::make($password);

        $user->save();
        
        Mail::send('emails.registration', ['user' => $user, 'password' => $password], function ($m) use ($user) {
            $m->replyTo('haveyoutriedturningitoffandonagain@proto.utwente.nl', 'Have You Tried Turning It Off And On Again committee');
            $m->to($user->email, $user->name);
        });

        if (!Auth::check()) {
            $request->session()->flash('flash_message', 'Your account has been created. You will receive an e-mail with your password shortly.');
            return Redirect::route('homepage');
        }
    }

}
