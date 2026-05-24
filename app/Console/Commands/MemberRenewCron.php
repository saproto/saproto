<?php

namespace App\Console\Commands;

use App\Mail\MembershipRenew;
use App\Models\Member;
use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

#[Description('Cronjob that takes care of sending out the membership renewal mail.')]
#[Signature('proto:memberrenewcron')]
class MemberRenewCron extends Command
{
    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        foreach (Member::all() as $member) {
            Mail::to($member->user)->queue(new MembershipRenew($member->user)->onQueue('low'));
        }
    }
}
