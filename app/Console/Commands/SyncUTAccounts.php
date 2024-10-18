<?php

namespace App\Console\Commands;

use App\Enums\MembershipTypeEnum;
use App\Http\Controllers\LdapController;
use App\Models\User;
use App\Models\UtAccount;
use Carbon;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class SyncUTAccounts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'proto:syncutaccounts';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Search all our users in the UT system and sync their info';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        //set all accounts to not found
        UtAccount::query()->update(['found' => false]);

        //get all regular members who do not have an account yet or have not been verified in this cron yet
        $query = User::query()->whereHas('member', function ($member) {
            $member->where('membership_type', MembershipTypeEnum::REGULAR);
        })->where(function (Builder $query) {
            $query->whereHas('UtAccount', function ($q) {
                $q->where('found', false);
            })->orDoesntHave('UtAccount');
        });
        //sync the students who are currently studying, with the constraints that they are either in the I-TECH or B-CREA department
        $this->syncStudents((clone $query), '(|(department=*B-CREA*)(department=*M-ITECH*))');

        //get all past members who have studied I-TECH or B-CREA
        $pastCreaTersQuery = (clone $query)->where(function (Builder $query) {
            $query->where('did_study_itech', true)->orWhere('did_study_create', true);
        });
        $this->syncStudents($pastCreaTersQuery);

        //remove all accounts that have not been found
        $this->info('Removing. '.UtAccount::query()->where('found', false)->count().'. accounts that have not been found');
        //todo: send an email to the board that these accounts have been removed
        UtAccount::query()->where('found', false)->delete();
    }

    public function syncStudents($query, string $constraints = ''): void
    {
        //try to find the users by their student number
        $usersById = (clone $query)->whereNotNull('utwente_username')->get();
        $this->info('Checking '.$usersById->count().' users by student number');
        $newAccounts = $this->syncColumnToUTTrait($usersById, $this->standardSns(...), $this->standardCompare(...), 'utwente_username', 'uid', $constraints);
        UtAccount::query()->insert($newAccounts->toArray());

        //try to find the users by their email
        $usersByEmail = (clone $query)->whereNotNull('email')->get();
        $this->info('Checking the remaining '.$usersByEmail->count().' users by email');
        $newerAccounts = $this->syncColumnToUTTrait($usersByEmail, $this->standardSns(...), $this->standardCompare(...), 'email', 'userprincipalname', $constraints);
        UtAccount::query()->insert($newerAccounts->toArray());

        //try to find the users by their name
        $usersByName = (clone $query)->whereNotNull('name')->get();
        $this->info('Checking another '.$usersByName->count().' users by name');
        $newerAccounts = $this->syncColumnToUTTrait($usersByName, $this->nameSns(...), $this->nameCompare(...), 'name', 'givenname', $constraints);
        UtAccount::query()->insert($newerAccounts->toArray());
    }

    public function syncColumnToUTTrait(Collection $users, callable $snsMapper, callable $compareFilter, string $userColumn, string $UTIdentifier, string $constraints = ''): Collection
    {
        $sns = implode('', array_map(fn ($userIdentifier): string => $snsMapper($userIdentifier, $UTIdentifier), $users->pluck($userColumn)->toArray()));

        $students = $this->getUtwenteResults($sns, $constraints);
        $bar = $this->output->createProgressBar(count($students));
        $bar->start();

        $newUTAccounts = collect();
        foreach ($students as $student) {
            $bar->advance();
            /** @var User $account */
            $account = $users->filter(fn ($user): bool => $compareFilter($user[$userColumn], $student, $UTIdentifier))->first();

            //if we have found a match in the UT system but can not find the user anymore
            if ($account === null) {
                $this->error('Could not find user we did find in the UT system with the info:'.iconv('utf-8', 'us-ascii//TRANSLIT', strtolower($student['givenname'].' '.$student['sn'])));

                continue;
            }

            //if the user does not have a UT account yet, create one
            if (! $account->UtAccount) {
                $newUTAccounts->push($this->formatUserInfo($account, $student));

                continue;
            }

            if (! $account->did_study_itech && Str::contains($student['department'], 'I-TECH')) {
                $account->update(['did_study_itech' => true]);
                $account->UtAccount->update(['department' => $student['department'], 'found' => true]);

                continue;
            }

            if (! $account->did_study_create && Str::contains($student['department'], 'B-CREA')) {
                $account->update(['did_study_create' => true]);
                $account->UtAccount->update(['department' => $student['department'], 'found' => true]);

                continue;
            }

            $account->UtAccount->update(['found' => true]);
        }

        $this->info("\n Created ".$newUTAccounts->count().' UT accounts for users who have their '.$userColumn.' as their '.$UTIdentifier);
        $this->info('Already found '.UtAccount::query()->where('found', true)->count().' UT accounts');
        $bar->finish();

        return $newUTAccounts;
    }

    public function nameSns(string $userIdentifier, string $UtIdentifier): string
    {

        $names = explode(' ', $userIdentifier);
        if (count($names) === 1) {
            return '';
        }

        return "(&({$UtIdentifier}=$names[0])(sn=".$names[count($names) - 1].'))';
    }

    public function nameCompare(string $userValue, array $student, string $UTIdentifier): bool
    {
        //transliterate the names to ascii and compare them in lowercase because we can get cyrillic characters from the API
        setlocale(LC_CTYPE, 'en_US.UTF8');
        $names = explode(' ', $userValue);

        return strtolower(iconv('utf-8', 'us-ascii//TRANSLIT', $names[0].' '.$names[count($names) - 1])) === strtolower(iconv('utf-8', 'us-ascii//TRANSLIT', $student[$UTIdentifier].' '.$student['sn']));
    }

    public function standardSns(string $userIdentifier, string $UtIdentifier): string
    {
        return "({$UtIdentifier}={$userIdentifier})";
    }

    public function standardCompare(string $userValue, array $student, string $UTIdentifier): bool
    {
        return strtolower($userValue) === strtolower($student[$UTIdentifier]);
    }

    private function formatUserInfo(User $user, $student): array
    {
        return [
            'user_id' => $user->id,
            'department' => $student['department'] ?? null,
            'mail' => $student['userprincipalname'],
            'number' => $student['cn'],
            'givenname' => $student['givenname'],
            'middlename' => $student['middlename'] ?? null,
            'surname' => $student['sn'],
            'account_expires_at' => $student['accountexpires'],
            'found' => true,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
    }

    private function getUtwenteResults(string $sns, string $constraints = '')
    {
        //get the results from the LDAP server
        $result = LdapController::searchUtwentePost("(&{$constraints}(description=Student *)(extensionattribute6=actief)(|{$sns}))");
        //check that we have a valid response
        if (isset($result->error)) {
            $this->error('Error: '.$result->error);
            exit();
        }

        return $result->result;
    }
}
