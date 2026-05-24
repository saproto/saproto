<?php

namespace App\Console\Commands;

use App\Enums\MembershipTypeEnum;
use App\Models\Member;
use Exception;
use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Date;

#[Description('Delete all pending memberships older than a month.')]
#[Signature('proto:membercleanup')]
class MemberCleanup extends Command
{
    /**
     * Execute the console command.
     *
     *
     * @throws Exception
     */
    public function handle(): int
    {
        $old_pending_memberships = Member::query()->whereMembershipType(MembershipTypeEnum::PENDING)->where('created_at', '<', Date::now()->subMonth())->get();
        foreach ($old_pending_memberships as $pending_membership) {
            $pending_membership->delete();
        }

        return 0;
    }
}
