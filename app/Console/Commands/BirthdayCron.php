<?php

namespace App\Console\Commands;

use App\Enums\MembershipTypeEnum;
use App\Mail\BirthdayEmail;
use App\Mail\BirthdayEmailForBoard;
use App\Models\User;
use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;
use Illuminate\Contracts\Database\Query\Builder;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\Mail;

#[Description('Cronjob that sends the daily birthday e-mails.')]
#[Signature('proto:birthdaycron')]
class BirthdayCron extends Command
{
    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $users = User::query()
            ->whereMonth('birthdate', Date::now()->month)
            ->whereDay('birthdate', Date::now()->day)
            ->whereHas('member', static function (Builder $q) {
                $q->whereNot('membership_type', MembershipTypeEnum::PENDING);
            })
            ->get();

        if ($users->count() > 0) {
            $this->info('Sending birthday notification to '.$users->count().' people.');

            $adminoverview = [];

            foreach ($users as $user) {
                $adminoverview[] = [
                    'id' => $user->getPublicId(),
                    'name' => $user->name,
                    'age' => $user->age(),
                ];

                Mail::to($user)->queue(new BirthdayEmail($user)->onQueue('medium'));
            }

            Mail::to('board@'.Config::string('proto.emaildomain'))->queue(new BirthdayEmailForBoard($adminoverview)->onQueue('low'));

            $this->info('Done!');
        } else {
            $this->info('There are no jarige joppen today.');
        }

        return 0;
    }
}
