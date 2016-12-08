<?php

namespace Proto\Http\Controllers;

use Illuminate\Http\Request;

use PragmaRX\Google2FA\Google2FA;

use Proto\Models\AchievementOwnership;
use Proto\Models\Address;
use Proto\Models\Alias;
use Proto\Models\Bank;
use Proto\Models\EmailListSubscription;
use Proto\Models\PasswordReset;
use Proto\Models\RfidCard;
use Proto\Models\User;
use Proto\Models\Member;

use Auth;
use Proto\Models\WelcomeMessage;
use Redirect;
use Yubikey;
use Hash;
use Mail;
use Session;

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

            // See if someone maybe used their Proto username.
            $member = Member::where('proto_username', $username)->first();

            // Check password again.
            if ($member && $member->user && Hash::check($password, $member->user->password)) {

                return $member->user;

            } else {

                // We cannot authenticate to our own records. Try RADIUS.
                $user = User::where('utwente_username', $username)->first();

                if ($user) {

                    if (AuthController::verifyUtwenteCredentials($user->utwente_username, $password)) {
                        return $user;
                    }

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

    public function updatePassword(Request $request)
    {
        $user = User::find($request->id);

        if ($user == null) {
            abort(404);
        }

        if ($user->id != Auth::id()) {
            $request->session()->flash('flash_message', 'Sorry! You cannot change another user their password. If a user forgot their password, please let them use the \'forgot password\' form on the login screen.');
            return Redirect::back();
        }

        if (
            AuthController::verifyCredentials($user->email, $request->oldpass)
            || ($user->utwente_username && AuthController::verifyUtwenteCredentials($user->utwente_username, $request->oldpass))
        ) {
            if ($request->newpass1 !== $request->newpass2) {
                $request->session()->flash('flash_message', 'The new passwords are not identical. Please try again!');
                return Redirect::route('user::dashboard');
            } elseif (strlen($request->newpass1) < 8) {
                $request->session()->flash('flash_message', 'Your new password should be at least 8 characters long.');
                return Redirect::route('user::dashboard');
            } else {
                $user->setPassword($request->newpass1);
                $request->session()->flash('flash_message', 'Your password has been changed.');
                return Redirect::route('user::dashboard');
            }
        }

        $request->session()->flash('flash_message', 'Old password incorrect! Password not updated.');
        return Redirect::route('user::dashboard');

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

        if ($request->wizard) Session::flash('wizard', true);

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

        if (Session::get('wizard')) $user->wizard = true;

        $user->save();

        $email = $user->email;
        $name = $user->mail;

        Mail::queue('emails.registration', ['user' => $user], function ($m) use ($email, $name) {
            $m->replyTo('board@proto.utwente.nl', 'Study Association Proto');
            $m->to($email, $name);
            $m->subject('Account registration at Study Association Proto');
        });

        AuthController::dispatchPasswordEmailFor($user);

        if (!Auth::check()) {
            $request->session()->flash('flash_message', 'Your account has been created. You will receive an e-mail with instructions on how to set your password shortly.');
            return Redirect::route('homepage');
        }
    }

    public function deleteUser(Request $request, $id)
    {
        $user = User::findOrFail($id);

        if ($user->id != Auth::id() && !Auth::user()->can('board')) {
            abort(403);
        }

        if ($user->member) {
            $request->session()->flash('flash_message', 'You cannot delete your account while you are a member.');
            return Redirect::back();
        }

        Address::where('user_id', $user->id)->delete();
        Bank::where('user_id', $user->id)->delete();
        EmailListSubscription::where('user_id', $user->id)->delete();
        AchievementOwnership::where('user_id', $user->id)->delete();
        Alias::where('user_id', $user->id)->delete();
        RfidCard::where('user_id', $user->id)->delete();
        WelcomeMessage::where('user_id', $user->id)->delete();

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

    public function getEmail()
    {
        return view('auth.password');
    }

    public function getReset(Request $request, $token)
    {
        PasswordReset::where('valid_to', '<', date('U'))->delete();
        $reset = PasswordReset::where('token', $token)->first();
        if ($reset !== null) {
            return view('auth.reset', ['reset' => $reset]);
        } else {
            $request->session()->flash('flash_message', 'This reset token does not exist or has expired.');
            return Redirect::route('login::resetpass');
        }
    }

    public function postReset(Request $request)
    {
        PasswordReset::where('valid_to', '<', date('U'))->delete();
        $reset = PasswordReset::where('token', $request->token)->first();
        if ($reset !== null) {

            if ($request->password !== $request->password_confirmation) {
                $request->session()->flash('flash_message', 'Your passwords don\'t match.');
                return Redirect::back();
            } elseif (strlen($request->password) < 8) {
                $request->session()->flash('flash_message', 'Your new password should be at least 8 characters long.');
                return Redirect::route('user::dashboard');
            }

            $reset->user->setPassword($request->password);

            PasswordReset::where('token', $request->token)->delete();

            $request->session()->flash('flash_message', 'Your password has been changed.');
            return Redirect::route('login::show');

        } else {
            $request->session()->flash('flash_message', 'This reset token does not exist or has expired.');
            return Redirect::route('login::resetpass');
        }
    }

    public function postEmail(Request $request)
    {
        $user = User::where('email', $request->email)->first();
        if ($user !== null) {

            AuthController::dispatchPasswordEmailFor($user);

            $request->session()->flash('flash_message', 'We\'ve dispatched an e-mail to you with instruction to reset your password.');
            return Redirect::route('homepage');

        } else {
            $request->session()->flash('flash_message', 'We could not find a user with the e-mail address you entered.');
            return Redirect::back();
        }
    }

    public static function dispatchPasswordEmailFor(User $user)
    {

        $reset = PasswordReset::create([
            'email' => $user->email,
            'token' => str_random(128),
            'valid_to' => strtotime('+1 hour')
        ]);

        $name = $user->name;
        $email = $user->email;

        Mail::queue('emails.password', ['token' => $reset->token, 'name' => $user->calling_name], function ($message) use ($name, $email) {
            $message
                ->to($email, $name)
                ->from('webmaster@' . config('proto.emaildomain'), 'Have You Tried Turning It Off And On Again committee')
                ->subject('Your password reset request for S.A. Proto.');
        });

    }

}
