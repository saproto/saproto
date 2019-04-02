<?php

namespace Proto\Console\Commands;

use Illuminate\Console\Command;

use Proto\Models\User;

class HelperNotificationsCron extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'proto:helpernotificationcron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cronjob that sends the helper notifications.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $users = User::all();

        foreach($users as $user) {
            if(!$user->isActiveMember()) break;

            $user_events_per_committee = [];

            foreach($users->committees as $committee) {
                $committee_events = new \stdClass();
                $committee_events->committee = $committee;
                $committee_events->events = [];

                foreach($committee->helpedEvents() as $helpedEvent) {
                    if(!$helpedEvent->activity->notification_sent) {
                        $committee_events->events[] = $helpedEvent;
                    }
                }

                $user_events_per_committee[] = $committee_events;
            }

            if(sizeof($user_events_per_committee > 0)) {
                dd($user_events_per_committee);
            }
        }
    }
}
