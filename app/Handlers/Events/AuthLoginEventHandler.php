<?php

namespace Proto\Handlers\Events;

use Proto\Models\Committee;

class AuthLoginEventHandler
{
    /**
     * Create the event handler.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  Events $event
     * @return void
     */
    public function handle($event)
    {
        $user = $event->user;
        $user->generateNewToken();

        // We will grant the user all roles to which he is entitled!
        $rootcommittee = Committee::where('slug', config('proto.rootcommittee'))->first();
        $boardcommittee = Committee::find(config('proto.committee')['board']);
        $omnomcom = Committee::find(config('proto.committee')['omnomcom']);
        $tipcie = Committee::find(config('proto.committee')['tipcie']);
        $drafters = Committee::find(config('proto.committee')['drafters']);
        $protography = Committee::find(config('proto.committee')['protography']);

        if ($user->isInCommittee($rootcommittee) && $user->signed_nda) {
            if (!$user->hasRole('protube')) {
                $user->assignRole('protube');
            }
        } else {
            if ($user->hasRole('protube')) {
                $user->removeRole('protube');
            }
        }

        if ($user->isInCommittee($boardcommittee) && $user->signed_nda) {
            if (!$user->hasRole('board')) {
                $user->assignRole('board');
            }
        } else {
            if ($user->hasRole('board')) {
                $user->removeRole('board');
            }
        }

        if ($user->isInCommittee($omnomcom) && $user->signed_nda) {
            if (!$user->hasRole('omnomcom')) {
                $user->assignRole('omnomcom');
            }
        } else {
            if ($user->hasRole('omnomcom')) {
                $user->removeRole('omnomcom');
            }
        }

        if ($user->isInCommittee($tipcie) && $user->signed_nda) {
            if (!$user->hasRole('tipcie')) {
                $user->assignRole('tipcie');
            }
        } else {
            if ($user->hasRole('tipcie')) {
                $user->removeRole('tipcie');
            }
        }

        if ($user->isInCommittee($drafters)) {
            if (!$user->hasRole('drafters')) {
                $user->assignRole('drafters');
            }
        } else {
            if ($user->hasRole('drafters')) {
                $user->removeRole('drafters');
            }
        }

        if ($user->isInCommittee($protography)) {
            if (!$user->hasRole('protography')) {
                $user->assignRole('protography');
            }
        } else {
            if ($user->hasRole('protography')) {
                $user->removeRole('protography');
            }
        }

    }
}
