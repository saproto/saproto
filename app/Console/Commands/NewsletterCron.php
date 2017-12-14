<?php

namespace Proto\Console\Commands;

use Illuminate\Console\Command;

use Proto\Mail\Newsletter;
use Proto\Models\EmailList;
use Proto\Models\Event;

use Mail;

class NewsletterCron extends Command
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'proto:newslettercron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cronjob that sends the weekly newsletter';

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

        $newsletterlist = EmailList::findOrFail(config('proto.weeklynewsletter'));

        $events = Event::getEventsForNewsletter();

        if ($events->count() > 0) {

            $this->info('Sending weekly newsletter to ' . $newsletterlist->users->count() . ' people.');

            foreach ($newsletterlist->users as $user) {

                Mail::to($user)->queue((new Newsletter($user, $newsletterlist))->onQueue('low'));

            }

            $this->info("Done!");

        } else {

            $this->info("No activities scheduled for the newsletter. Newsletter not sent.");

        }

    }

}
