<?php

namespace App\Console\Commands;

use App\Mail\CloseActivitiesReminder;
use App\Mail\ReviewStickersMail;
use App\Models\Activity;
use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\Mail;

#[Signature('proto:closeactivitiesremindercron')]
#[Description('Remind the treasurer to close open activities')]
class CloseActivitiesReminderCron extends Command
{
    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $activities = Activity::query()
            ->whereHas('event', function ($query) {
                $query->where('end', '<', Date::now()->subWeeks(4)->timestamp);
            })
            ->where('closed', false)
            ->orderBy('registration_end')
            ->get();

        if ($activities->count() > 0) {
            $this->info('Sending an email to remind the treasurer to close activities.');
            Mail::queue(new CloseActivitiesReminder($activities)->onQueue('low'));
        } else {
            $this->info('No new activities that have to be closed!');
        }
    }
}
