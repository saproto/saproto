<?php

namespace App\Console\Commands;

use App\Mail\Newsletter as NewsletterMail;
use App\Models\EmailList;
use App\Models\Newsitem;
use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Mail;

#[Description('Cronjob that sends the weekly newsletter')]
#[Signature('proto:newslettercron {id}')]
class NewsletterCron extends Command
{
    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $newsletterlist = EmailList::query()->findOrFail(Config::integer('proto.weeklynewsletter'));

        $newsitem = Newsitem::query()->findOrFail($this->argument('id'));

        if (! $newsitem->is_weekly) {
            $this->error('This is not a weekly newsletter item!');

            return;
        }

        if ($newsitem->published_at != null) {
            $this->error('This newsletter has already been sent!');

            return;
        }

        $image_url = $newsitem->getImageUrl();

        $events = $newsitem->events;

        $this->info('Sending weekly newsletter to '.$newsletterlist->users->count().' people.');

        foreach ($newsletterlist->users as $user) {
            Mail::to($user)->queue(new NewsletterMail($user, $newsletterlist, $newsitem->content, $events, $image_url)->onQueue('low'));
        }

        $this->info('Done!');
    }
}
