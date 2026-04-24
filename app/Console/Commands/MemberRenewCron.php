<?php

namespace App\Console\Commands;

use App\Mail\MembershipRenew;
use App\Models\Member;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class MemberRenewCron extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'proto:memberrenewcron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cronjob that takes care of sending out the membership renewal mail.';

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
