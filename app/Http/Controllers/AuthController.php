<?php

namespace Proto\Http\Controllers;

use Illuminate\Http\Request;

use PragmaRX\Google2FA\Google2FA;

use Adldap\Adldap;
use Adldap\Connections\Provider;

use nickurt\PwnedPasswords\PwnedPasswords;

use Proto\Mail\PasswordResetEmail;
use Proto\Mail\PwnedPasswordNotification;
use Proto\Mail\UsernameReminderEmail;
use Proto\Mail\RegistrationConfirmation;
use Proto\Models\AchievementOwnership;
use Proto\Models\Address;
use Proto\Models\Alias;
use Proto\Models\Bank;
use Proto\Models\EmailListSubscription;
use Proto\Models\PasswordReset;
use Proto\Models\RfidCard;
use Proto\Models\User;
use Proto\Models\Member;
use Proto\Models\HashMapItem;

use Auth;
use Proto\Models\WelcomeMessage;
use Redirect;
use Hash;
use Mail;
use Session;

class AuthController extends Controller
{

    /******************************************************
     * These are the regular, non-static methods serving as entry point to the AuthController
     *
     *
     *
     */

    /*
     * Present the login page.
     */
    public function getLogin(Request $request)
    {


        if (Auth::check()) {
            if ($request->has('SAMLRequest')) {
                return AuthController::handleSAMLRequest(Auth::user(), $request->input('SAMLRequest'));
            }
            return Redirect::route('homepage');
        } else {
            if ($request->has('SAMLRequest')) {
                Session::flash('incoming_saml_request', $request->get('SAMLRequest'));
            }
            return view('auth.login');
        }

    }

    /**
     * Handle a submitted log-in form. Returns the application's response.
     *
     * @param Request $request The request object, needed for the log-in data.
     * @param Google2FA $google2fa The Google2FA object, because this is apparently the only way to access it.
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postLogin(Request $request, Google2FA $google2fa)
    {

        Session::keep('incoming_saml_request');

        if (Auth::check()) { // User is already logged in

            AuthController::postLoginRedirect($request);

        } else { // User is not yet logged in.

            // Catch a login form submission for two factor authentication.
            if ($request->session()->has('2fa_user')) {
                return AuthController::handleTwofactorSubmit($request, $google2fa);
            }

            // Otherwise this is a regular login.
            return AuthController::handleRegularLogin($request);

        }

    }

    /**
     * Handle a request to the log-out URL.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function getLogout()
    {
        Auth::logout();
        return Redirect::route('homepage');
    }

    /**
     * Handle a request for the register-an-account page.
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function getRegister(Request $request)
    {
        if (Auth::check()) {
            $request->session()->flash('flash_message', 'You already have an account. To register an account, please log off.');
            return Redirect::route('user::dashboard');
        }

        if ($request->wizard) Session::flash('wizard', true);

        return view('users.register');
    }

    /**
     * Handle a submission of the register-an-account page.
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
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
            'g-recaptcha-response' => 'required|recaptcha',
            'privacy_policy_acceptance' => 'required'
        ]);

        $this->registerAccount($request);

        $request->session()->flash('flash_message', 'Your account has been created. You will receive an e-mail with instructions on how to set your password shortly.');
        return Redirect::route('homepage');
    }

    /**
     * Handle a submission of the register-an-account-with-a-university-account page.
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postRegisterSurfConext(Request $request)
    {
        if (Auth::check()) {
            $request->session()->flash('flash_message', 'You already have an account. To register an account, please log off.');
            return Redirect::route('user::dashboard');
        }

        if (!Session::has('surfconext_create_account')) {
            $request->session()->flash('flash_message', 'Account creation expired. Please try again.');
            return Redirect::route('login::show');
        }

        $remote_data = Session::get('surfconext_create_account');

        $request->request->add([
            'email' => $remote_data['mail'],
            'name' => $remote_data['givenname'] . " " . $remote_data['surname'],
            'calling_name' => $remote_data['givenname'],
            'edu_username' => $remote_data['uid-full'],
            'utwente_username' => $remote_data['org'] == 'utwente.nl' ? $remote_data['uid'] : null
        ]);

        $this->validate($request, [
            'email' => 'required|email|unique:users',
            'name' => 'required|string',
            'calling_name' => 'required|string',
            'privacy_policy_acceptance' => 'required'
        ]);

        $this->registerAccount($request);

        $request->session()->flash('flash_message', 'Your account has been created. You will receive a confirmation e-mail shortly.');
        return Redirect::route('login::edu');
    }

    /**
     * Shared logic for creating and verifying a user account.
     *
     * @param $request
     * @return $this|\Illuminate\Database\Eloquent\Model
     */
    private function registerAccount($request)
    {

        $user = User::create($request->only(['email', 'name', 'calling_name']));

        if (Session::get('wizard')) {

            HashMapItem::create([
                'key' => 'wizard',
                'subkey' => $user->id,
                'value' => 1
            ]);
        }

        $user->save();

        AuthController::makeLdapAccount($user);

        Mail::to($user)->queue((new RegistrationConfirmation($user))->onQueue('high'));

        AuthController::dispatchPasswordEmailFor($user);

        EmailListController::autoSubscribeToLists('autoSubscribeUser', $user);

        return $user;

    }

    /**
     * Handle a request to delete the current user account.
     *
     * @param Request $request
     * @param $id The user id.
     * @return \Illuminate\Http\RedirectResponse
     */
    public function deleteUser(Request $request, $id)
    {
        $user = User::findOrFail($id);

        if ($user->id != Auth::id() && !Auth::user()->can('board')) {
            abort(403);
        }

        if ($user->member) {
            $request->session()->flash('flash_message', 'You cannot deactivate your account while you are a member.');
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
        $user->phone = null;
        $user->website = null;
        $user->utwente_username = null;
        $user->edu_username = null;
        $user->utwente_department = null;
        $user->tfa_totp_key = null;

        $user->did_study_create = 0;
        $user->phone_visible = 0;
        $user->address_visible = 0;
        $user->receive_sms = 0;

        $user->email = 'deleted-' . $user->id . '@deleted.' . config('proto.emaildomain');

        $user->save();

        $user->delete();

        $request->session()->flash('flash_message', 'Your account has been deactivated.');
        return Redirect::route('homepage');
    }

    /**
     * Handle a request to see the begin-with-password-reset page.
     *
     * @return mixed
     */
    public function getEmail()
    {
        return view('auth.passreset_mail');
    }

    /**
     * Handle a submission of the begin-with-password-reset page.
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postEmail(Request $request)
    {
        $user = User::where('email', $request->email)->first();
        if ($user !== null) {
            AuthController::dispatchPasswordEmailFor($user);
        }
        $request->session()->flash('flash_message', 'If an account exists at this e-mail address, you will receive an e-mail with instructions to reset your password.');
        return Redirect::route('login::show');
    }

    /**
     * Handle a request to see the continue-with-password-reset page.
     *
     * @param Request $request
     * @param $token The reset token, as e-mailed to the user.
     * @return \Illuminate\Http\RedirectResponse
     */
    public function getReset(Request $request, $token)
    {
        PasswordReset::where('valid_to', '<', date('U'))->delete();
        $reset = PasswordReset::where('token', $token)->first();
        if ($reset !== null) {
            return view('auth.passreset_pass', ['reset' => $reset]);
        } else {
            $request->session()->flash('flash_message', 'This reset token does not exist or has expired.');
            return Redirect::route('login::resetpass');
        }
    }

    /**
     * Handle a submission of the continue-with-password-reset page.
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postReset(Request $request)
    {
        PasswordReset::where('valid_to', '<', date('U'))->delete();
        $reset = PasswordReset::where('token', $request->token)->first();
        if ($reset !== null) {

            if ($request->password !== $request->password_confirmation) {
                $request->session()->flash('flash_message', 'Your passwords don\'t match.');
                return Redirect::back();
            } elseif (strlen($request->password) < 10) {
                $request->session()->flash('flash_message', 'Your new password should be at least 10 characters long.');
                return Redirect::back();
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

    public function passwordChangeGet(Request $request)
    {
        if (!Auth::check()) {
            $request->session()->flash('flash_message', 'Please log-in first.');
            return Redirect::route('login::show');
        }
        return view('auth.passchange');
    }

    /**
     * Handle a submitted password change form.
     *
     * @param Request $request The request object.
     * @return \Illuminate\Http\RedirectResponse
     */
    public function passwordChangePost(Request $request)
    {

        if (!Auth::check()) {
            $request->session()->flash('flash_message', 'Please log-in first.');
            return Redirect::route('login::show');
        }

        $user = Auth::user();

        $pass_old = $request->get('old_password');
        $pass_new1 = $request->get('new_password1');
        $pass_new2 = $request->get('new_password2');

        $user_verify = AuthController::verifyCredentials($user->email, $pass_old);

        if ($user_verify && $user_verify->id === $user->id) {
            if ($pass_new1 !== $pass_new2) {
                $request->session()->flash('flash_message', 'The new passwords do not match.');
                return view('auth.passchange');
            } elseif (strlen($pass_new1) < 10) {
                $request->session()->flash('flash_message', 'Your new password should be at least 10 characters long.');
                return view('auth.passchange');
            } elseif ((new PwnedPasswords())->setPassword($pass_new1)->isPwnedPassword()) {
                $request->session()->flash('flash_message', 'The password you would like to set is unsafe because it has been exposed in one or more data breaches. Please choose a different password and <a href="https://wiki.proto.utwente.nl/ict/pwned-passwords" target="_blank">click here to learn more</a>.');
                return view('auth.passchange');
            } else {
                $user->setPassword($pass_new1);
                $request->session()->flash('flash_message', 'Your password has been changed.');
                return Redirect::route('user::dashboard');
            }
        }

        $request->session()->flash('flash_message', 'Old password incorrect.');
        return view('auth.passchange');

    }

    /**
     * Display the password sync form to users to allow them to sync their password between services.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function passwordSyncGet(Request $request)
    {
        if (!Auth::check()) {
            $request->session()->flash('flash_message', 'Please log-in first.');
            return Redirect::route('login::show');
        }
        return view('auth.sync');
    }

    /**
     * Process a request to synchronize ones password.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function passwordSyncPost(Request $request)
    {
        if (!Auth::check()) {
            $request->session()->flash('flash_message', 'Please log-in first.');
            return Redirect::route('login::show');
        }

        $pass = $request->get('password');
        $user = Auth::user();

        $user_verify = AuthController::verifyCredentials($user->email, $pass);

        if ($user_verify && $user_verify->id === $user->id) {
            $user->setPassword($pass);
            $request->session()->flash('flash_message', 'Your password was successfully synchronized.');
            return Redirect::route('user::dashboard');
        } else {
            $request->session()->flash('flash_message', 'Password incorrect.');
            return view('auth.sync');
        }

        return view('auth.sync');
    }


    /**
     * Handle a request for UTwente SSO auth.
     *
     * @return Redirect
     */
    public function startSurfConextAuth()
    {
        Session::reflash();
        return redirect('saml2/login');
    }

    /**
     * This is where we land after a successfull SurfConext SSO auth.
     * We do the authentication here because only using the Event handler for the SAML login doesn't let us do the proper redirects.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function surfConextAuthPost()
    {

        if (!Session::has('surfconext_sso_user')) {
            return Redirect::route('login::show');
        }

        $remoteUser = Session::pull('surfconext_sso_user');
        $remoteData = [
            'uid' => $remoteUser[config('saml2-attr.uid')][0],
            'surname' => $remoteUser[config('saml2-attr.surname')][0],
            'mail' => $remoteUser[config('saml2-attr.email')][0],
            'givenname' => $remoteUser[config('saml2-attr.givenname')][0],
            'org' => isset($remoteUser[config('saml2-attr.institute')]) ? $remoteUser[config('saml2-attr.institute')][0] : 'utwente.nl'
        ];
        $remoteEduUsername = $remoteData['uid'] . '@' . $remoteData['org'];
        $remoteData['uid-full'] = $remoteEduUsername;

        // We can be here for two reasons:
        // Reason 1: we were trying to link a university account to a user
        if (Session::has('link_edu_to_user')) {
            $user = Session::get('link_edu_to_user');
            $user->utwente_username = ($remoteData['org'] == 'utwente.nl' ? $remoteData['uid'] : null);
            $user->edu_username = $remoteEduUsername;
            $user->save();
            Session::flash('flash_message', 'We linked your institution account ' . $remoteEduUsername . ' to your Proto account.');
            if (Session::has('link_wizard')) {
                return Redirect::route('becomeamember');
            } else {
                return Redirect::route('user::dashboard', ['id' => $user->id]);
            }
        }

        // Reason 2: we were trying to login using a university account
        Session::keep('incoming_saml_request');
        $localUser = User::where('edu_username', $remoteEduUsername)->first();

        // If we can't find a user account to login to, we have to options:
        if ($localUser == null) {
            $localUser = User::where('email', $remoteData['mail'])->first();
            // If we recognize the e-mail address, reminder the user they may already have an account.
            if ($localUser) {
                Session::flash('flash_message', 'We recognize your e-mail address, but you have not explicitly allowed authentication to your account using your university account. You can link your university account on your dashboard after you have logged in.');
                return Redirect::route('login::show');
            } // Else, we'll allow them to create an account using their university account
            else {
                Session::flash('surfconext_create_account', $remoteData);
                return view('users.registersurfconext', ['remote_data' => $remoteData]);
            }
        }

        $localUser->name = $remoteData['givenname'] . " " . $remoteData['surname'];
        $localUser->calling_name = $remoteData['givenname'];
        $localUser->save();

        return AuthController::continueLogin($localUser);

    }

    /**
     * Handle a request for a user's username
     *
     * @return Redirect
     */
    public function requestUsername(Request $request)
    {
        if ($request->has('email')) {
            $user = User::whereEmail($request->get('email'))->first();
            if ($user) {
                AuthController::dispatchUsernameEmailFor($user);
            }
            Session::flash('flash_message', 'If your e-mail belongs to an account, we have just e-mailed you the username.');
            return Redirect::route('login::show');
        } else {
            return view('auth.username');
        }
    }

    /******************************************************
     * These are the static helper functions of the AuthController for more overview and modularity. Heuh!
     *
     *
     *
     */

    /**
     * This static function takes a supplied username and password, and returns the associated user if the combination is valid. Accepts either Proto username or e-mail and password.
     *
     * @param $username The e-mail address or Proto username.
     * @param $password The password.
     * @return User The user associated with the credentials, or null if no user could be found or credentials are invalid.
     */
    public static function verifyCredentials($username, $password)
    {

        $user = User::where('email', $username)->first();
        if ($user == null) {
            $member = Member::where('proto_username', $username)->first();
            $user = ($member ? $member->user : null);
        }

        if ($user != null && Hash::check($password, $user->password)) {
            if (HashMapItem::where('key', 'pwned-pass')->where('subkey', $user->id)->first() === null && (new PwnedPasswords())->setPassword($password)->isPwnedPassword()) {
                Mail::to($user)->queue((new PwnedPasswordNotification($user))->onQueue('high'));
                HashMapItem::create(['key' => 'pwned-pass', 'subkey' => $user->id, 'value' => date('r')]);
            }
            return $user;
        }

        return null;

    }

    /**
     * Login the supplied user and perform post-login checks and redirects. Returns the application's response.
     *
     * @param User $user The user to be logged in.
     * @param Request $request The request object, needed to handle some checks.
     * @return \Illuminate\Http\RedirectResponse
     */
    public static function loginUser(User $user)
    {
        Auth::login($user, true);
        if (Session::has('incoming_saml_request')) {
            return AuthController::handleSAMLRequest(Auth::user(), Session::get('incoming_saml_request'));
        }
        return AuthController::postLoginRedirect();
    }

    /**
     * The login has been completed (succesfull or not). Return where the user is supposed to be redirected.
     *
     * @param Request $request The request object.
     */
    private static function postLoginRedirect()
    {
        return Redirect::intended('/');
    }

    /**
     * Handle the submission of a regular log-in form with username and password. Return the application's response.
     *
     * @param Request $request Thje request object for the data.
     * @return \Illuminate\Http\RedirectResponse
     */
    private static function handleRegularLogin(Request $request)
    {

        $username = $request->input('email');
        $password = $request->input('password');

        $user = AuthController::verifyCredentials($username, $password);

        if ($user) {
            return AuthController::continueLogin($user);
        }

        $request->session()->flash('flash_message', 'Invalid username or password provided.');
        return Redirect::route('login::show');

    }

    /**
     * We know a user has identified itself, but we still need to check for other stuff like SAML or Two Factor Authentication. We do this here.
     *
     * @param User $user The username to be logged in.
     * @param Request $request Thje request object for the data.
     * @return null
     */
    public static function continueLogin(User $user)
    {
        // Catch users that have 2FA enabled.
        if ($user->tfa_totp_key) {
            Session::flash('2fa_user', $user);
            return view('auth.2fa');
        } else {
            return AuthController::loginUser($user);
        }

    }

    /**
     * Handle the submission of two factor authentication data. Return the application's response.
     *
     * @param Request $request The request object for the data.
     * @param Google2FA $google2fa The Google2FA object, because this is apparently the only way to access it.
     * @return \Illuminate\Http\RedirectResponse
     */
    private static function handleTwofactorSubmit(Request $request, Google2FA $google2fa)
    {

        $user = $request->session()->get('2fa_user');

        /*
         * Time based Two Factor Authentication (Google2FA)
         */
        if ($user->tfa_totp_key && $request->has('2fa_totp_token') && $request->input('2fa_totp_token') != '') {

            // Verify if the response is valid.
            if ($google2fa->verifyKey($user->tfa_totp_key, $request->input('2fa_totp_token'))) {
                return AuthController::loginUser($user);
            } else {
                $request->session()->flash('flash_message', 'Your code is invalid. Please try again.');
                $request->session()->reflash();
                return view('auth.2fa');
            }

        }

        /*
         * Something we don't recognize
         */
        $request->session()->flash('flash_message', 'Please complete the requested challenge.');
        $request->session()->reflash();
        return view('auth.2fa');

    }

    /**
     * Static helper function that will prepare an LDAP account associated with a new local user.
     *
     * @param $user The user to make the LDAP account for.
     */
    public static function makeLdapAccount($user)
    {
        if (config('app.env') !== 'local') {
            $ad = new Adldap();
            $provider = new Provider(config('adldap.proto'));
            $ad->addProvider('proto', $provider);
            $ad->connect('proto');

            $ldapuser = $provider->make()->user();
            $ldapuser->cn = "user-" . $user->id;
            $ldapuser->description = $user->id;
            $ldapuser->save();
        }
    }

    /**
     * Static helper function that will dispatch a password reset e-mail for a user.
     *
     * @param User $user The user to submit the e-mail for.
     */
    public static function dispatchPasswordEmailFor(User $user)
    {

        $reset = PasswordReset::create([
            'email' => $user->email,
            'token' => str_random(128),
            'valid_to' => strtotime('+1 hour')
        ]);

        Mail::to($user)->queue((new PasswordResetEmail($user, $reset->token))->onQueue('high'));

    }

    /**
     * Static helper function that will dispatch a username reminder for a user.
     *
     * @param User $user
     */
    public static function dispatchUsernameEmailFor(User $user)
    {

        Mail::to($user)->queue((new UsernameReminderEmail($user))->onQueue('high'));

    }

    /**
     * Static helper function to handle a SAML request.
     * The function expects an authed user for which to complete the SAML request.
     * This function assumes the user has already been authenticated one way or another.
     *
     * @param $user The (currently logged in) user to complete the SAML request for.
     * @param $saml The SAML data (deflated and encoded).
     * @return \Illuminate\Http\RedirectResponse
     */
    private static function handleSAMLRequest($user, $saml)
    {
        if (!$user->member) {
            Session::flash('flash_message', 'Only members can use the Proto SSO. You only have a user account.');
            return Redirect::route('becomeamember');
        }

        // SAML is transmitted base64 encoded and GZip deflated.
        $xml = gzinflate(base64_decode($saml));

        // LightSaml Magic. Taken from https://imbringingsyntaxback.com/implementing-a-saml-idp-with-laravel/
        $deserializationContext = new \LightSaml\Model\Context\DeserializationContext();
        $deserializationContext->getDocument()->loadXML($xml);

        $authnRequest = new \LightSaml\Model\Protocol\AuthnRequest();
        $authnRequest->deserialize($deserializationContext->getDocument()->firstChild, $deserializationContext);

        if (!array_key_exists(base64_encode($authnRequest->getAssertionConsumerServiceURL()), config('saml-idp.sp'))) {
            Session::flash('flash_message', 'You are using an unknown Service Provider. Please contact the System Administrators to get your Service Provider whitelisted for Proto SSO.');
            return Redirect::route('login::show');
        }

        $response = AuthController::buildSAMLResponse($user, $authnRequest);

        $bindingFactory = new \LightSaml\Binding\BindingFactory();
        $postBinding = $bindingFactory->create(\LightSaml\SamlConstants::BINDING_SAML2_HTTP_POST);
        $messageContext = new \LightSaml\Context\Profile\MessageContext();
        $messageContext->setMessage($response)->asResponse();

        $httpResponse = $postBinding->send($messageContext);

        return view('auth.saml.samlpostbind', ['response' => $httpResponse->getData()["SAMLResponse"], 'destination' => $httpResponse->getDestination()]);
    }

    /**
     * Another static helper function to build a SAML response based on a user and a request.
     *
     * @param $user The user to generate the SAML response for.
     * @param $authnRequest The request to generate a SAML response for.
     * @return \LightSaml\Model\Protocol\Response A LightSAML response.
     */
    private static function buildSAMLResponse($user, $authnRequest)
    {

        // LightSaml Magic. Taken from https://imbringingsyntaxback.com/implementing-a-saml-idp-with-laravel/
        $audience = config('saml-idp.sp')[base64_encode($authnRequest->getAssertionConsumerServiceURL())]['audience'];
        $destination = $authnRequest->getAssertionConsumerServiceURL();
        $issuer = config('saml-idp.idp.issuer');

        $certificate = \LightSaml\Credential\X509Certificate::fromFile(base_path() . config('saml-idp.idp.cert'));
        $privateKey = \LightSaml\Credential\KeyHelper::createPrivateKey(base_path() . config('saml-idp.idp.key'), '', true);

        $response = new \LightSaml\Model\Protocol\Response();
        $response
            ->addAssertion($assertion = new \LightSaml\Model\Assertion\Assertion())
            ->setID(\LightSaml\Helper::generateID())
            ->setIssueInstant(new \DateTime())
            ->setDestination($destination)
            ->setIssuer(new \LightSaml\Model\Assertion\Issuer($issuer))
            ->setStatus(new \LightSaml\Model\Protocol\Status(new \LightSaml\Model\Protocol\StatusCode('urn:oasis:names:tc:SAML:2.0:status:Success')))
            ->setSignature(new \LightSaml\Model\XmlDSig\SignatureWriter($certificate, $privateKey));

        $email = $user->email;

        $assertion
            ->setId(\LightSaml\Helper::generateID())
            ->setIssueInstant(new \DateTime())
            ->setIssuer(new \LightSaml\Model\Assertion\Issuer($issuer))
            ->setSubject(
                (new \LightSaml\Model\Assertion\Subject())
                    ->setNameID(new \LightSaml\Model\Assertion\NameID(
                        $email,
                        \LightSaml\SamlConstants::NAME_ID_FORMAT_EMAIL
                    ))
                    ->addSubjectConfirmation(
                        (new \LightSaml\Model\Assertion\SubjectConfirmation())
                            ->setMethod(\LightSaml\SamlConstants::CONFIRMATION_METHOD_BEARER)
                            ->setSubjectConfirmationData(
                                (new \LightSaml\Model\Assertion\SubjectConfirmationData())
                                    ->setInResponseTo($authnRequest->getId())
                                    ->setNotOnOrAfter(new \DateTime('+1 MINUTE'))
                                    ->setRecipient($authnRequest->getAssertionConsumerServiceURL())
                            )
                    )
            )
            ->setConditions(
                (new \LightSaml\Model\Assertion\Conditions())
                    ->setNotBefore(new \DateTime())
                    ->setNotOnOrAfter(new \DateTime('+1 MINUTE'))
                    ->addItem(
                        new \LightSaml\Model\Assertion\AudienceRestriction($audience)
                    )
            )
            ->addItem(
                (new \LightSaml\Model\Assertion\AttributeStatement())
                    ->addAttribute(new \LightSaml\Model\Assertion\Attribute(
                        'urn:mace:dir:attribute-def:mail',
                        $email
                    ))
                    ->addAttribute(new \LightSaml\Model\Assertion\Attribute(
                        'urn:mace:dir:attribute-def:displayName',
                        $user->name
                    ))
                    ->addAttribute(new \LightSaml\Model\Assertion\Attribute(
                        'urn:mace:dir:attribute-def:cn',
                        $user->name
                    ))
                    ->addAttribute(new \LightSaml\Model\Assertion\Attribute(
                        'urn:mace:dir:attribute-def:givenName',
                        $user->given_name
                    ))
                    ->addAttribute(new \LightSaml\Model\Assertion\Attribute(
                        'urn:mace:dir:attribute-def:uid',
                        $user->member->proto_username
                    ))
            )
            ->addItem(
                (new \LightSaml\Model\Assertion\AuthnStatement())
                    ->setAuthnInstant(new \DateTime('-10 MINUTE'))
                    ->setSessionIndex('_some_session_index')
                    ->setAuthnContext(
                        (new \LightSaml\Model\Assertion\AuthnContext())
                            ->setAuthnContextClassRef(\LightSaml\SamlConstants::AUTHN_CONTEXT_PASSWORD_PROTECTED_TRANSPORT)
                    )
            );

        return $response;

    }
}
