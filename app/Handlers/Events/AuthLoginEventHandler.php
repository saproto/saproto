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
     * @param $event
     * @return void
     */
    public function handle($event)
    {
        $user = $event->user;
        $user->generateNewToken();

        // We will grant the user all roles to which they are entitled to!
        $committees = [
            ['committee' => Committee::where('slug', config('proto.rootcommittee'))->first(), 'permission' => 'protube', 'nda' => true],
            ['committee' => Committee::find(config('proto.committee')['board']), 'permission' => 'board', 'nda' => true],
            ['committee' => Committee::find(config('proto.committee')['omnomcom']), 'permission' => 'omnomcom', 'nda' => true],
            ['committee' => Committee::find(config('proto.committee')['tipcie']), 'permission' => 'tipcie', 'nda' => true],
            ['committee' => Committee::find(config('proto.committee')['drafters']), 'permission' => 'drafters', 'nda' => false],
            ['committee' => Committee::find(config('proto.committee')['protography']), 'permission' => 'protography', 'nda' => false],
        ];

        foreach($committees as $committee) {
            if ($user->isInCommittee($committee['committee']) && ($user->signed_nda and $committee['nda'])) {
                if (! $user->hasRole($committee['permission'])) {
                    $user->assignRole($committee['permission']);
                }
            } else {
                if ($user->hasRole($committee['permission'])) {
                    $user->removeRole($committee['permission']);
                }
            }
        }
    }
}
