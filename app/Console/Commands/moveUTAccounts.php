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

class moveUTAccounts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'proto:moveutaccounts';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    //todo: handle the case where an account is not found anymore
    //todo: Not always create but update the account
    public function handle(): void
    {
        //set all accounts to not found
        UtAccount::query()->update(['found' => false]);

        //get all users who are currently studying and have a UT account
        $query = User::query()->whereHas('member', function ($member) {
            $member->where('membership_type', MembershipTypeEnum::REGULAR);
        })->where(function (Builder $query) {
            $query->whereHas('UtAccount', function ($q) {
                $q->where('found', false);
            })->orDoesntHave('UtAccount');
        });

        $this->syncStudents((clone $query), '(|(department=*B-CREA*)(department=*M-ITECH*))');

        $pastCreaTersQuery = (clone $query)->where(function (Builder $query) {
            $query->where('did_study_itech', true)->orWhere('did_study_create', true);
        });
        $this->syncStudents($pastCreaTersQuery);
    }

    public function syncStudents($query, $constraints = ''): void
    {
        //try to find the users by their student number
        $usersById = (clone $query)->whereNotNull('utwente_username')->get();
        $this->info('Checking'.$usersById->count().' by Student number');
        $newAccounts = $this->syncColumnToUTTrait($usersById, 'uid', 'utwente_username', $constraints);
        UtAccount::query()->insert($newAccounts->toArray());

        //try to find the users by their email
        $usersByEmail = (clone $query)->whereNotNull('email')->get();
        $this->info('Checking the remaining '.$usersByEmail->count().' users by email');
        $newerAccounts = $this->syncColumnToUTTrait($usersByEmail, 'userprincipalname', 'email', $constraints);
        UtAccount::query()->insert($newerAccounts->toArray());

        //try to find the users by their name
        $usersByName = (clone $query)->whereNotNull('name')->get();
        $this->info('Checking another '.$usersByName->count().' users by email');
        $sns = implode('', array_map(function ($name): string {
            $names = explode(' ', $name);
            if (count($names) === 1) {
                return '';
            }

            return "(&(givenname=$names[0])(sn=".$names[count($names) - 1].'))';
        }, $usersByName->pluck('name')->toArray()));

        $students = $this->getUtwenteResults($sns, $constraints);
        $bar = $this->output->createProgressBar(count($students));
        $bar->start();

        $newUTAccounts = collect();
        foreach ($students as $student) {
            /** @var User $account */
            $account = $usersByName->filter(function (array $user) use ($student): bool {
                $names = explode(' ', $user['name']);

                return strtolower($names[0].' '.$names[count($names) - 1]) === strtolower($student['givenname'].' '.$student['sn']);
            })->first();

            if ($account == null) {
                $this->error('Could not find user with '.$student['givenname'].' '.$student['sn']);

                continue;
            }

            $newUTAccounts->push($this->formatUserInfo($account, $student));
            $bar->advance();
        }

        UtAccount::query()->insert($newUTAccounts->toArray());
        $this->info('Created '.$newUTAccounts->count().' UT accounts for users who studied CreaTe or I-Tech in the past.');
        $bar->finish();
    }

    public function syncColumnToUTTrait(Collection $users, string $UTIdentifier, string $userColumn, string $constraints = ''): Collection
    {
        $sns = implode('', array_map(fn ($studentNumber): string => "({$UTIdentifier}={$studentNumber})", $users->pluck($userColumn)->toArray()));

        $students = $this->getUtwenteResults($sns, $constraints);
        $bar = $this->output->createProgressBar(count($students));
        $bar->start();

        $newUTAccounts = collect();
        foreach ($students as $student) {
            $bar->advance();
            /** @var User $account */
            $account = $users->filter(fn ($user): bool => strtolower($user[$userColumn]) === strtolower($student[$UTIdentifier]))->first();

            //if we have found a match in the UT system but can not find the user anymore
            if ($account === null) {
                $this->error('Could not find user we did find in the UT system called: '.$student[$UTIdentifier]);

                continue;
            }

            //if the user does not have a UT account yet, create one
            if (! $account->UtAccount) {
                $newUTAccounts->push($this->formatUserInfo($account, $student));

                continue;
            }

            if (! $account->did_study_itech && Str::contains($student['department'], 'I-TECH')) {
                $account->update(['did_study_itech' => true, ['department' => $student['department'], 'found' => true]]);

                continue;
            }

            if (! $account->did_study_create && Str::contains($student['department'], 'B-CREA')) {
                $account->update(['did_study_create' => true, ['department' => $student['department'], 'found' => true]]);

                continue;
            }

            $account->UtAccount->update(['found' => true]);
        }

        $this->info('Created '.$newUTAccounts->count().' UT accounts for users who have their '.$userColumn.' as their '.$UTIdentifier);
        $bar->finish();

        return $newUTAccounts;
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

    private function getUtwenteResults(string $sns, $constraints = '')
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
