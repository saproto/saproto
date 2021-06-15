<?php

namespace Proto\Console\Commands;

use Illuminate\Console\Command;
use Mail;
use Proto\Mail\DailyHelperMail;
use Proto\Models\HelpingCommittee;
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

        $handledHelpIds = [];

        foreach ($users as $user) {
            if (! $user->isActiveMember()) {
                continue;
            }

            $events = [];

            foreach ($user->committees as $committee) {
                $helps = HelpingCommittee::where('committee_id', $committee->id)->where('notification_sent', '0')
                    ->with('activity')->with('activity.event')->get()->sortBy('activity.event.start');

                foreach ($helps as $help) {
                    if ($help->activity && $help->activity->event && $help->amount > $help->getHelpingCount() && $help->activity->event->start > time()) {
                        if (isset($help->activity->event->id)) {
                            if (! isset($events[$help->activity->event->id])) {
                                $events[$help->activity->event->id] = new \stdClass();
                                $events[$help->activity->event->id]->help = [];
                            }

                            $helpInfo = new \stdClass();
                            $helpInfo->amount = $help->amount;
                            $helpInfo->committeeName = $help->committee->name;

                            $events[$help->activity->event->id]->help[] = $helpInfo;
                        }

                        if (! in_array($help->id, $handledHelpIds)) {
                            $handledHelpIds[] = $help->id;
                        }
                    }
                }

                unset($committee);
                unset($helps);
            }

            if (count($events) > 0) {
                $this->info('Sending notification mail to '.$user->name.' with '.count($events).' events.');
                Mail::to($user)->queue((new DailyHelperMail($user, $events))->onQueue('low'));
            }

            unset($user);
        }

        foreach ($handledHelpIds as $handledHelpId) {
            $handledHelp = HelpingCommittee::find($handledHelpId);
            $handledHelp->notification_sent = true;
            $handledHelp->save();
        }

        $this->info('Done.');
    }
}
