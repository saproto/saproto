<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Socialite;

class SamlController extends Controller
{
    //
    public function login() {
        // Socialite::driver('saml2')->clearIdentityProviderMetadataCache();
        // dd(Socialite::driver('saml2')->getServiceProviderEntityId());
        // dd(Socialite::driver('saml2')->getIdentityProviderEntityDescriptorManually());
        return Socialite::driver('saml2')
            ->redirect();
    }

    public function provideMetadataForSurfConext() {
        // return Socialite::driver('saml2')
        //     ->getServiceProviderMetadata();
    }

    public function callback() {
        $user = Socialite::driver('saml2')->stateless()->user();
        dd($user->uid, $user->email, $user->last_name, $user->first_name, $user->organization);

    }
}
