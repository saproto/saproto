<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;

#[Description('Give a user the sysadmin role.')]
#[Signature('proto:addsysadmin {user_id}')]
class AddSysadmin extends Command
{
    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $user_id = (int) $this->argument('user_id');
        $user = User::query()->find($user_id);
        if (! $user) {
            $this->error('User could not be found.');

            return 1;
        }

        if ($this->confirm('Give '.$user->name.' admin right?')) {
            $user->assignRole('sysadmin');
            $this->info('Sysadmin role granted!');
        }

        return 0;
    }
}
