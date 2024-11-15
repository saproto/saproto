<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Socialite;
use Symfony\Component\HttpFoundation\RedirectResponse as HttpFoundationRedirectResponse;

class SurfConextController extends Controller
{
    const SESSION_FLASH_KEY = 'surfconext_action';

    const CREATE_ACCOUNT = 'create_account';

    const LINK_ACCOUNT = 'link_account';

    const LOGIN = 'login';

    /**
     * Send the user to surfconext to login
     */
    public function login(): HttpFoundationRedirectResponse
    {
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
     */
    public function callback(): void
    {
        $user = Socialite::driver('saml2')->stateless()->user();
        dd($user->uid, $user->email, $user->last_name, $user->first_name, $user->organization, Session::get('surfconext_action'), Session::getId());

        switch (Session::get(self::SESSION_FLASH_KEY)) {
            case self::CREATE_ACCOUNT:
                $this->createNewAccount($user);
                break;
            case self::LINK_ACCOUNT:
                $this->linkAccount($user);
                break;
            case self::LOGIN:
                $this->loginUser($user);
                break;
        }
    }

    private function loginUser(mixed $user)
    {
        $UtAccount = ::where('email', $user->email)->first();


    }

    // protected function createNewAccount(string $email, )

    /**
     * @return RedirectResponse
     */
    public function create(Request $request)
    {
        $user = Auth::user();

        if ($request->wizard) {
            Session::flash('wizard', true);
        }

        Session::flash('link_edu_to_user', $user);

        if ($request->has('wizard')) {
            Session::flash('link_wizard', true);
        }

        return Redirect::route('login::edu');
    }

    /**
     * @return RedirectResponse
     */
    public function destroy(Request $request)
    {
        $user = Auth::user();

        $user->utwente_username = null;
        $user->edu_username = null;
        $user->utwente_department = null;
        $user->save();

        Session::flash('flash_message', 'The link with your university account has been deleted.');

        return Redirect::route('user::dashboard::show');
    }
}
