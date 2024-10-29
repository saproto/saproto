<?php

namespace App\Console\Commands;

use App\Http\Controllers\LdapController;
use App\Models\Member;
use Illuminate\Console\Command;

class MarkMembersAsPrimary extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'proto:markmembersasprimary';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Mark the current members as primary according to the current way of determining primary members.';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        //code copied from the FeeCron.php file
        $students = LdapController::searchStudents();
        $names = $students['names'];
        $emails = $students['emails'];
        $usernames = $students['usernames'];
        /** @var Member[] $members */
        $members = Member::query()->where([
            ['is_pending', false],
            ['is_honorary', false],
            ['is_donor', false],
            ['is_pet', false],
        ])->get();
        $bar = $this->output->createProgressBar(count($members));
        $bar->start();
        foreach ($members as $member) {
            if (in_array(strtolower($member->user->email), $emails) || in_array($member->user->utwente_username, $usernames) || in_array(strtolower($member->user->name), $names)) {
                $member->primary = true;
                $member->save();
            }

            $bar->advance();
        }

        $bar->finish();

        return 0;
    }
}
