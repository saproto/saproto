<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;

#[Description('Clears all users registrations that have not been completed (users without password and no data associated).')]
#[Signature('proto:usercleanup')]
class UserCleanup extends Command
{
    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $this->info('Starting clean-up.');

        $count = 0;

        foreach (User::withTrashed()->get() as $user) {
            if (! $user->isStale()) {
                continue;
            }

            $count++;
            $user->forceDelete();
        }

        $this->info("Found and deleted {$count} stale users.");
    }
}
