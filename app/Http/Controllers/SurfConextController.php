<?php

namespace App\Http\Controllers;

use App\Models\User;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\View\View;
use Socialite;
use Symfony\Component\HttpFoundation\RedirectResponse as HttpFoundationRedirectResponse;

class SurfConextController extends Controller
{
    // Some constants to keep track of the action we're performing
    const string SESSION_FLASH_KEY = 'surfconext_action';

    const string SESSION_FLASH_KEY_EMAIL = 'new_account_email';

    const string CREATE_ACCOUNT = 'create_account';

    const string LINK_ACCOUNT = 'link_account';

    const string LOGIN = 'login';

    /**
     * Send the user to surfconext to login
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
    public function unlinkAccount(): RedirectResponse
    {
        $user = Auth::user();

        $user->utwente_username = null;
        $user->edu_username = null;
        $user->utwente_department = null;
        $user->save();

        Session::flash('flash_message', 'The link with your university account has been deleted.');

        return to_route('user::dashboard::show');
    }

    /**
     * Send the user to surfconext to log in to create a new account
     */
    public static function createAccount(string $email): View
    {
        Session::flash(self::SESSION_FLASH_KEY, self::CREATE_ACCOUNT);
        Session::flash(self::SESSION_FLASH_KEY_EMAIL, $email);
        $url = Socialite::driver('saml2')
            ->redirect()->getTargetUrl();

        return view('auth.surfconextRedirect', ['url' => $url]);
    }

    /**
     * Provide metadata for surfconext
     */
    public function provideMetadataForSurfConext(): Response
    {
        /** @phpstan-ignore-next-line  */
        return Socialite::driver('saml2')
            ->getServiceProviderMetadata();
    }

    /**
     * Handle the callback from surfconext
     * This route must be excluded from CSRF protection
     *
     * @throws Exception
     */
    public function callback(Request $request): RedirectResponse
    {
        // Attributes: uid, email, last_name, first_name, organization
        /** @phpstan-ignore-next-line  */
        $user = Socialite::driver('saml2')->stateless()->user();

        if ($user->organization !== 'utwente.nl') {
            Session::flash('flash_message', 'We only support University of Twente accounts.');

            return back();
        }

        return match (Session::get(self::SESSION_FLASH_KEY)) {
            self::CREATE_ACCOUNT => $this->handleCreateNewAccount($request, $user),
            self::LINK_ACCOUNT => $this->handleLinkAccount($request, $user),
            self::LOGIN => $this->handleLoginUser($request, $user),
            default => throw new Exception('Invalid action'),
        };
    }

    /**
     * Process the response from SurfConext and log the user in
     */
    protected function handleLoginUser(Request $request, mixed $utUser): RedirectResponse
    {
        $user = User::query()->where('utwente_username', $utUser->uid)->first();

        if (empty($user)) {
            Session::flash('flash_message', 'This University of Twente account is not registered to a user.');

            return to_route('login::show');
        }

        return AuthController::loginUser($request, $user);
    }

    /**
     * Process the response from SurfConext and create a new account
     */
    protected function handleCreateNewAccount(Request $request, mixed $utUser): RedirectResponse
    {
        $email = Session::get(self::SESSION_FLASH_KEY_EMAIL);

        throw_if(empty($email), Exception::class, 'An error occurred while creating the account');

        // We're in a create new account attempt, do not log them in
        if ($this->accountAlreadyExists($utUser->uid)) {
            Session::flash('flash_message', 'This University of Twente account is already registered to a user. We have logged you in.');
            AuthController::loginUser($request, User::query()->where('utwente_username', $utUser->uid)->first());
        }

        User::register(
            $email,
            $utUser->first_name,
            $utUser->first_name.' '.$utUser->last_name,
            $utUser->uid,
            $utUser->email);

        Session::flash('flash_message', 'Your account has been created. You will receive an e-mail with instructions on how to set your password shortly.');

        return to_route('homepage');
    }

    /**
     * Process the response from SurfConext and link the account
     */
    protected function handleLinkAccount(Request $request, mixed $utUser): RedirectResponse
    {
        // We're in a link account attempt, but it already exists. Log them in instead
        if ($this->accountAlreadyExists($utUser->uid)) {
            Session::flash('flash_message', 'This University of Twente account is already registered to a user. We have logged you in.');
            AuthController::loginUser($request, User::query()->where('utwente_username', $utUser->uid)->first());

            return to_route('user::dashboard::show');
        }

        $user = Auth::user();
        $user->edu_username = $utUser->email;
        $user->utwente_username = $utUser->uid;
        $user->save();

        Session::flash('flash_message', 'Successfully linked your University of Twente account.');

        return to_route('user::dashboard::show');
    }

    /**
     * Helper function to check if the user already exists, based on the utwente username
     *
     * @param  string  $utwenteId  (studentnumber)
     */
    protected function accountAlreadyExists(string $utwenteId): bool
    {
        return User::query()->where('utwente_username', $utwenteId)->exists();
    }
}
