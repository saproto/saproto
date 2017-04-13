<?php

namespace Proto\Handlers\Events;

use Proto\Models\Committee;
use Proto\Models\Role;
use Proto\Models\User;
use Proto\Models\Token;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Session;

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
    public function handle(User $user, $remember)
    {
        $token = new Token();
        $token->generate($user);
        Session::put('token', $token->token);

        // We will grant the user all roles to which he is entitled!
        $rootcommittee = Committee::where('slug', config('proto.rootcommittee'))->first();
        $boardcommittee = Committee::find(2108);
        $omnomcom = Committee::find(26);
        $pilscie = Committee::find(22);
        $drafters = Committee::find(3336);

        if ($user->isInCommittee($rootcommittee)) {
            if (!$user->hasRole('protube')) {
                $user->attachRole(Role::where('name', '=', 'protube')->first());
            }
        } else {
            if ($user->hasRole('protube')) {
                $user->detachRole(Role::where('name', '=', 'protube')->first());
            }
        }

        if ($user->isInCommittee($boardcommittee)) {
            if (!$user->hasRole('board')) {
                $user->attachRole(Role::where('name', '=', 'board')->first());
            }
        } else {
            if ($user->hasRole('board')) {
                $user->detachRole(Role::where('name', '=', 'board')->first());
            }
        }

        if ($user->isInCommittee($omnomcom)) {
            if (!$user->hasRole('omnomcom')) {
                $user->attachRole(Role::where('name', '=', 'omnomcom')->first());
            }
        } else {
            if ($user->hasRole('omnomcom')) {
                $user->detachRole(Role::where('name', '=', 'omnomcom')->first());
            }
        }

        if ($user->isInCommittee($pilscie)) {
            if (!$user->hasRole('pilscie')) {
                $user->attachRole(Role::where('name', '=', 'pilscie')->first());
            }
        } else {
            if ($user->hasRole('pilscie')) {
                $user->detachRole(Role::where('name', '=', 'pilscie')->first());
            }
        }

        if ($user->isInCommittee($drafters)) {
            if (!$user->hasRole('drafters')) {
                $user->attachRole(Role::where('name', '=', 'drafters')->first());
            }
        } else {
            if ($user->hasRole('drafters')) {
                $user->detachRole(Role::where('name', '=', 'drafters')->first());
            }
        }
    }
}
