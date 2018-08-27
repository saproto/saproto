<?php

namespace Proto\Console\Commands;

use Illuminate\Console\Command;

use Proto\Mail\FeeEmail;
use Proto\Mail\FeeEmailForBoard;
use Proto\Mail\MembershipRenew;
use Proto\Models\Member;
use Proto\Models\OrderLine;
use Proto\Models\Product;

use Mail;

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

        foreach (Member::all() as $member) {

            Mail::to($member->user)->queue((new MembershipRenew($member->user))->onQueue('low'));

        }

    }

}
