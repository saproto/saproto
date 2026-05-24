<?php

namespace App\Console\Commands;

use App\Models\Member;
use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;

#[Description('Print all active members of the association and the committees they are currently in.')]
#[Signature('proto:printactivemembers')]
class PrintActiveMembers extends Command
{
    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        foreach (Member::query()->whereHas('user', function ($q) {
            $q->whereHas('committees');
        })->get() as $member) {
            /** @var Member $member */
            $this->info(sprintf('%s: %s', $member->user->name, implode(', ', $member->user->committees->pluck('name')->toArray())));
        }
    }
}
