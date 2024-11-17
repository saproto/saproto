<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Socialite;
use Symfony\Component\HttpFoundation\RedirectResponse as HttpFoundationRedirectResponse;

class SurfConextController extends Controller
{
    // Some constants to keep track of the action we're performing
    const SESSION_FLASH_KEY = 'surfconext_action';
    const SESSION_FLASH_KEY_EMAIL = 'new_account_email';

    const CREATE_ACCOUNT = 'create_account';
    const LINK_ACCOUNT = 'link_account';
    const LOGIN = 'login';

    /**
     * Send the user to surfconext to login to login
     */
    public function login(): HttpFoundationRedirectResponse
    {
        Session::flash(self::SESSION_FLASH_KEY, self::LOGIN);
        return Socialite::driver('saml2')
            ->redirect();
    }

    /**
     * Send the user to surfconext to login to link their account
     */
    public function linkAccount(): HttpFoundationRedirectResponse
    {
        Session::flash(self::SESSION_FLASH_KEY, self::LINK_ACCOUNT);
        return Socialite::driver('saml2')
            ->redirect();
    }

    /**
     * Unlink the surfconext account from the user
     */
    public function unlinkAccount()
    {
        $user = Auth::user();

        $user->utwente_username = null;
        $user->edu_username = null;
        $user->utwente_department = null;
        $user->save();

        Session::flash('flash_message', 'The link with your university account has been deleted.');

        return Redirect::route('user::dashboard::show');
    }

    /**
     * Send the user to surfconext to login to create a new account
     */
    public static function createAccount(string $email): HttpFoundationRedirectResponse
    {
        Session::flash(self::SESSION_FLASH_KEY, self::CREATE_ACCOUNT);
        Session::flash(self::SESSION_FLASH_KEY_EMAIL, $email);
        return Socialite::driver('saml2')
            ->redirect();
    }

    /**
     * Provide metadata for surfconext
     */
    public function provideMetadataForSurfConext(): Response
    {
        return Socialite::driver('saml2')
            ->getServiceProviderMetadata();
    }

    /**
     * Handle the callback from surfconext
     * This route must be excluded from CSRF protection
     */
    public function callback()
    {
        // Attributes: uid, email, last_name, first_name, organization
        $user = Socialite::driver('saml2')->stateless()->user();

        if ($user->organization !== 'utwente.nl') {
            Session::flash('flash_message', 'We only support University of Twente accounts.');
            return Redirect::back();
        }

        switch (Session::get(self::SESSION_FLASH_KEY)) {
            case self::CREATE_ACCOUNT:
                return $this->handleCreateNewAccount($user);
                break;
            case self::LINK_ACCOUNT:
                return $this->handleLinkAccount($user);
                break;
            case self::LOGIN:
                return $this->handleLoginUser($user);
                break;
            default:
                throw new \Exception('Invalid action');
        }
    }

    /**
     * Process the response from SurfConext and log the user in
     */
    protected function handleLoginUser(mixed $utAccount): RedirectResponse
    {
        $user = User::where('utwente_username', $utAccount->uid)->first();

        if (!$user) {
            Session::flash('flash_message', 'This University of Twente account is not registered to a user.');
            return Redirect::route('login::show');
        }

        return AuthController::loginUser($user);
    }

    /**
     * Process the response from SurfConext and create a new account
     */
    protected function handleCreateNewAccount(mixed $user): RedirectResponse
    {
        $email = Session::get(self::SESSION_FLASH_KEY_EMAIL);

        if (empty($email)) {
            throw new \Exception('An error occurred while creating the account');
        }

        // We're in a create new account attempt, do not log them in
        if ($this->accountAlreadyExists($user->uid)) {
            Session::flash('flash_message', 'This University of Twente account is already registered to a user.');
            return Redirect::route('login::register::index');
        }

        User::register(
            $email, 
            $user->first_name, 
            $user->last_name . " " . $user->first_name, 
            $user->uid,
            $user->email);

        Session::flash('flash_message', 'Your account has been created. You will receive an e-mail with instructions on how to set your password shortly.');

        return Redirect::route('homepage');
    }

    /**
     * Process the response from SurfConext and link the account
     */
    protected function handleLinkAccount(mixed $utUser): RedirectResponse
    {
        // We're in a create new account attempt, do not log them in
        if ($this->accountAlreadyExists($utUser->uid)) {
            Session::flash('flash_message', 'This University of Twente account is already registered to a user.');
            return Redirect::back();
        }

        $user = Auth::user();
        $user->edu_username = $utUser->email;
        $user->utwente_username = $utUser->uid;
        $user->save();

        Session::flash('flash_message', 'Successfully linked your University of Twente account.');
        return Redirect::route('user::dashboard::show');
    }

    /**
     * Helper function to check if the user already exists, based on the utwente username
     * 
     * @param string $utwenteId (studentnumber)
     * @return bool
     */
    protected function accountAlreadyExists (string $utwenteId): bool
    {
        return User::where('utwente_username', $utwenteId)->exists();
    }
}
