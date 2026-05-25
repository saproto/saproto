<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\App;

#[Description('Give a user sys-admin rights. This command only works on non-production databases.')]
#[Signature('proto:makeadmin {email}')]
class MakeAdmin extends Command
{
    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        if (App::environment('production')) {
            $this->error('Cannot do this on production.');
        }

        $user = User::query()->where('email', $this->argument('email'))->firstOrFail();

        if (! $user->hasRole('sysadmin')) {
            $user->assignRole('sysadmin');
            $this->info('User '.$user->name.' now has sysadmin role.');
        } else {
            $this->info('User '.$user->name.' already had sysadmin role.');
        }
    }
}
