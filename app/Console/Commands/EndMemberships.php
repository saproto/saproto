<?php

namespace App\Console\Commands;

use App\Http\Controllers\UserAdminController;
use App\Mail\MembershipEndedForBoard;
use App\Models\Member;
use Exception;
use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\Mail;

#[Description('This command terminates all memberships that have an end date in the past')]
#[Signature('proto:endmemberships')]
class EndMemberships extends Command
{
    /**
     * Execute the console command.
     *
     * @throws Exception
     */
    public function handle(): void
    {
        $deleted = [];
        foreach (Member::query()->whereNotNull('until')->get() as $member) {
            if ($member->until < Date::now()->timestamp) {
                (new UserAdminController)->endMembership($member->user->id);
                $this->info("Membership from $member->proto_username ended!");
                $deleted[] = $member;
            }
        }

        if ($deleted !== []) {
            Mail::queue(new MembershipEndedForBoard($deleted)->onQueue('high'));
        } else {
            $this->info("No users who's membership to end!");
        }
    }
}
