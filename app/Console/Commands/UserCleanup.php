<?php

namespace Proto\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

use Proto\Models\Member;
use Proto\Models\AchievementOwnership;
use Proto\Models\Address;
use Proto\Models\Bank;
use Proto\Models\CommitteeMembership;
use Proto\Models\EmailListSubscription;
use Proto\Models\OrderLine;
use Proto\Models\PlayedVideo;
use Proto\Models\Quote;
use Proto\Models\RfidCard;
use Proto\Models\StudyEntry;
use Proto\Models\User;

class UserCleanup extends Command
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'proto:usercleanup';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clears all users registrations that have not been completed (users without password and no data associated).';

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

        $this->info('Starting clean-up.');

        $count = 0;

        foreach (User::withTrashed()->get() as $user) {
            if (!$user->isStale()) continue;
            $count++;
            $user->forceDelete();
        }

        $this->info("Found and deleted $count stale users.");

    }

}
