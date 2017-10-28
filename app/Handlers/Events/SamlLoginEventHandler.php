<?php

namespace Proto\Handlers\Events;

use Proto\Models\User;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

use Session;

class SamlLoginEventHandler
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
        $remoteUser = $event->getSaml2User()->getAttributes();
        Session::flash('surfconext_sso_user', $remoteUser);
    }
}
