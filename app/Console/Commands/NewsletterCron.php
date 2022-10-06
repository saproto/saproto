<?php

namespace Proto\Console\Commands;

use Illuminate\Console\Command;
use Mail;
use Proto\Mail\Newsletter as NewsletterMail;
use Proto\Models\EmailList;
use Proto\Models\Event;
use Proto\Models\Newsletter;

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

        $text = Newsletter::getText()->value;

        $this->info('Sending weekly newsletter to '.$newsletterlist->users->count().' people.');

        foreach ($newsletterlist->users as $user) {
            Mail::to($user)->queue((new NewsletterMail($user, $newsletterlist, $text))->onQueue('low'));
        }

        $this->info('Done!');
    }
}
