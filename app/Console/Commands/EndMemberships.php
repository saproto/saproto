<?php

namespace Proto\Console\Commands;

use Carbon;
use Exception;
use Illuminate\Console\Command;
use Proto\Http\Controllers\UserAdminController;
use Proto\Models\Member;

class EndMemberships extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'proto:endmemberships';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command terminates all memberships that have an end date in the past';

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
     *
     * @throws Exception
     */
    public function handle()
    {
        foreach(Member::all()->whereNotNull('until') as $member){
            if(Carbon::createFromTimestamp($member->until) < Carbon::now()->timestamp){
                (new UserAdminController())->endMembership($member->user->id);
                $this->info("Membership from $member->proto_username ended!");
            }
        }
    }
}
