<?php

namespace Proto\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

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

                Mail::send('emails.newsletter', [
                    'user' => $user,
                    'list' => $newsletterlist,
                    'events' => $events
                ], function ($message) use ($user) {

                    $message
                        ->to($user->email, $user->name)
                        ->from('internal@' . config('proto.emaildomain'), config('proto.internal'))
                        ->subject('S.A. Proto Weekly Newsletter (Week ' . date("W") . ')');

                });

            }

            $this->info("Done!");

        } else {

            $this->info("There are no upcomming activities.");

        }

    }

}
