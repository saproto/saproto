<?php

namespace App\Console\Commands;

use App\Mail\VerifyPersonalDetails;
use App\Models\User;
use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\Mail;

#[Description('Cronjob that sends the bi-yearly e-mail to remind users to keep their personal data up to date.')]
#[Signature('proto:verifydetailscron')]
class VerifyPersonalDetailsEmailCron extends Command
{
    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $users = User::query()
            ->whereMonth('created_at', Date::now()->addMonth()->month)
            ->get();

        foreach ($users as $user) {
            Mail::to($user)->queue(new VerifyPersonalDetails($user)->onQueue('low'));
        }

        $this->info(sprintf('Sent reminder e-mail to %d members.', $users->count()));
    }
}
