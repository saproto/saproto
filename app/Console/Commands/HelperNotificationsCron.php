<?php

namespace Proto\Console\Commands;

use Illuminate\Console\Command;

use Proto\Mail\DailyHelperMail;

use Proto\Models\User;
use Proto\Models\HelpingCommittee;

use Mail;

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

            if(!$user->isActiveMember()) {
                continue;
            }

            $events = [];

            foreach($user->committees as $committee) {
                $helps = HelpingCommittee::where('committee_id', $committee->id)->where('notification_sent', '0')->get();

                foreach($helps as $help) {
                    if(isset($help->activity->event->id)) {
                        if (!isset($events[$help->activity->event->id])) {
                            $events[$help->activity->event->id] = new \stdClass();
                            $events[$help->activity->event->id]->help = [];
                        }

                        $helpInfo = new \stdClass();
                        $helpInfo->amount = $help->amount;
                        $helpInfo->committeeName = $help->committee->name;

                        $events[$help->activity->event->id]->help[] = $helpInfo;
                    }
                }
            }

            if(count($events) > 0) {
                $this->info('Sending notification mail to ' . $user->name . ' with ' . count($events) . ' events.');
                Mail::to($user)->queue((new DailyHelperMail($user, $events))->onQueue('low'));
            }
        }
    }
}
