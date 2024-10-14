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
    protected $signature = 'proto:movememberstomembershiptype';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Move the membership type of members to the new column.';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {

        $bar = $this->output->createProgressBar(Member::query()->count());
        $bar->start();

        Member::query()->chunk(25, function ($members) use ($bar) {
            $bar->advance();
            foreach ($members as $member) {
                /** @var Member $member */
                if ($member->is_pending) {
                    $member->update([
                        'membership_type' => MembershipTypeEnum::PENDING,
                    ]);

                    continue;
                }

                if ($member->is_pet) {
                    $member->update([
                        'membership_type' => MembershipTypeEnum::PET,
                    ]);

                    continue;
                }

                if ($member->is_lifelong) {
                    $member->update([
                        'membership_type' => MembershipTypeEnum::LIFELONG,
                    ]);

                    continue;
                }

                if ($member->is_honorary) {
                    $member->update([
                        'membership_type' => MembershipTypeEnum::HONORARY,
                    ]);

                    continue;
                }

                if ($member->is_donor) {
                    $member->update([
                        'membership_type' => MembershipTypeEnum::DONOR,
                    ]);

                    continue;
                }

                $member->update([
                    'membership_type' => MembershipTypeEnum::REGULAR,
                ]);
            }
        });

        $bar->finish();
    }
}
