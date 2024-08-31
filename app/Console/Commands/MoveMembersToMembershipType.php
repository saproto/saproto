<?php

namespace App\Console\Commands;

use App\Enums\MembershipTypeEnum;
use App\Models\Member;
use Illuminate\Console\Command;

class MoveMembersToMembershipType extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'proto:move_members_to_membership_type';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Move the membership type of members to the new column.';

    /**
     * Execute the console command.
     */
    public function handle()
    {

        $bar = $this->output->createProgressBar(Member::count());
        $bar->start();

        Member::chunk(25, function ($members) use ($bar) {
            foreach ($members as $member) {
                if (!$member->is_pending) {
                    $member->membership_type = MembershipTypeEnum::REGULAR;
                }

                if ($member->is_pet) {
                    $member->membership_type = MembershipTypeEnum::PET;
                }

                if ($member->is_lifelong) {
                    $member->membership_type = MembershipTypeEnum::LIFELONG;
                }

                if ($member->is_honorary) {
                    $member->membership_type = MembershipTypeEnum::HONORARY;
                }

                if ($member->is_donor) {
                    $member->membership_type = MembershipTypeEnum::DONOR;
                }

                $member->save();
                $bar->advance();
            }
        });

        $bar->finish();

    }
}
