<?php

namespace Proto\Handlers\Events;

use Proto\Models\Role;
use Proto\Models\User;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

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
        // We will grant the user all roles to which he is entitled!
        foreach($user->committeesFilter('current') as $committee) {
            switch($committee->slug) {
                case config('proto.rootcommittee'):
                    $user->attachRole(Role::where('name', '=', 'admin')->first());
                    break;
                case config('proto.boardcommittee'):
                    $user->attachRole(Role::where('name', '=', 'board')->first());
                    break;
            }
        }
    }
}
