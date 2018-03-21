<?php

namespace Proto\Console\Commands;

use Illuminate\Console\Command;

use Proto\Mail\HelperReminder;
use Proto\Models\Event;
use Proto\Models\HelpingCommittee;

use Mail;

class HelperReminderCron extends Command
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'proto:helperremindercron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cronjob that sends helper reminder e-mails.';

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
     */
    public function handle()
    {

        $events = Event::where('start', '>', strtotime('+3 days'))->where('start', '<', strtotime('+40 days'))->get();
        if ($events->count() == 0) {
            $this->info('No events in three days. Exiting.');
            return;
        }

        foreach ($events as $event) {
            $this->info(sprintf("Handling event %s.", $event->title));
            if (!$event->activity) {
                $this->info('Event has no activity. Skipping');
                continue;
            }
            $helping_committees = HelpingCommittee::where('activity_id', $event->activity->id)->get();
            if ($helping_committees->count() == 0) {
                $this->info('Event has no helping committees. Skipping');
                continue;
            }

            foreach ($helping_committees as $helping_committee) {
                if ($helping_committee->getHelpingCount() >= $helping_committee->amount) {
                    $this->info(sprintf('%s has enough helpers, skipping.', $helping_committee->committee->name));
                    continue;
                } elseif (count($helping_committee->committee->getHelperReminderSubscribers()) == 0) {
                    $this->info(sprintf('%s has no people subscribed to helper reminders, skipping.', $helping_committee->committee->name));
                    continue;
                } else {
                    $this->error(sprintf('Sending reminder e-mail for %s (%s/%s helping).', $helping_committee->committee->name, $helping_committee->getHelpingCount(), $helping_committee->amount));
                    Mail::queue((new HelperReminder($helping_committee))->onQueue('medium'));
                }
            }

        }

    }

}
