<?php

namespace App\Console\Commands;

use App\Http\Controllers\LdapController;
use App\Models\Member;
use App\Models\User;
use App\Models\UtAccount;
use Carbon;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;

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
    public function handle()
    {
        \DB::table('ut_accounts')->truncate();
        $query = User::whereHas('member')->whereDoesntHave('UtAccount');
        $this->syncCreaters((clone $query), '(|(department=*B-CREA*)(department=*M-ITECH*))');

        $pastCreaTersQuery = (clone $query)->where(function (Builder $query) {
            $query->where('did_study_itech', true)->orWhere('did_study_create', true);
        });
        $this->syncCreaters($pastCreaTersQuery);
    }

    public function syncCreaters($query, $constraints = '')
    {
        $pastCreaTers = (clone $query)->whereNotNull('utwente_username')->get();
        $this->info('Checking' . $pastCreaTers->count() . ' by Student number');
        $newAccounts = $this->syncColumnToUTTrait($pastCreaTers, 'uid', 'utwente_username', $constraints);
        UTAccount::insert($newAccounts->toArray());

        $pastCreaTers = (clone $query)->whereNotNull('email')->get();
        $this->info('Checking the remaining ' . $pastCreaTers->count() . ' users by email');
        $newerAccounts = $this->syncColumnToUTTrait($pastCreaTers, 'userprincipalname', 'email', $constraints);
        UTAccount::insert($newerAccounts->toArray());
        $pastCreaTers = (clone $query)->whereNotNull('name')->get();

        $sns = implode('', array_map(function ($name) {
            $names = explode(' ', $name);
            if (count($names) === 1) {
                return '';
            }
            return "(&(givenname=$names[0])(sn=" . $names[count($names) - 1] . "))";
        }, $pastCreaTers->pluck('name')->toArray()));

        $students = $this->getUtwenteResults($sns, $constraints);
        $bar = $this->output->createProgressBar(count($students));
        $bar->start();

        $newUTAccounts = collect();
        foreach ($students as $student) {
            /** @var User $account */
            $account = $pastCreaTers->filter(function ($user) use ($student) {
                $names = explode(' ', $user['name']);
                return strtolower($names[0] . ' ' . $names[count($names) - 1]) == strtolower($student['givenname'] . ' ' . $student['sn']);
            })->first();

            if ($account == null) {
                $this->error('Could not find user with ' . $student['givenname'] . ' ' . $student['sn']);
                continue;
            }
            $newUTAccounts->push($this->formatUserInfo($account, $student));
            $bar->advance();
        }
        UTAccount::insert($newUTAccounts->toArray());
        $this->info('Created ' . $newUTAccounts->count() . ' UT accounts for users who studied CreaTe or I-Tech in the past.');
        $bar->finish();
    }

    function syncColumnToUTTrait(Collection $users, string $UTIdentifier, string $userColumn, string $constraints = ''): Collection
    {
        $sns = implode('', array_map(function ($studentNumber) use ($UTIdentifier) {
            return "($UTIdentifier=$studentNumber)";
        }, $users->pluck($userColumn)->toArray()));

        $students = $this->getUtwenteResults($sns, $constraints);
        $bar = $this->output->createProgressBar(count($students));
        $bar->start();

        $newUTAccounts = collect();
        //loop through all students and update their information (in_array($member->user->utwente_username, $usernames))
        foreach ($students as $student) {
            /** @var User $account */
            $account = $users->filter(function ($user) use ($student, $userColumn, $UTIdentifier) {
                return strtolower($user[$userColumn]) == strtolower($student[$UTIdentifier]);
            })->first();

            if ($account == null) {
                $this->error('Could not find user with ' . $student[$UTIdentifier]);
                continue;
            }
            $newUTAccounts->push($this->formatUserInfo($account, $student));
            $bar->advance();
        }
        $this->info('Created ' . $newUTAccounts->count() . ' UT accounts for users who studied CreaTe or I-Tech in the past.');
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
            'initials' => $student['initials'] ?? null,
            'account_expires_at' => $student['accountexpires'],
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
    }

    private function getUtwenteResults($sns, $constraints = '')
    {
        //get the results from the LDAP server
        $result = LdapController::searchUtwentePost("(&$constraints(description=Student *)(extensionattribute6=actief)(|$sns))");
        //check that we have a valid response
        if (isset($result->error)) {
            $this->error('Error: ' . $result->error);
            exit();
        }
        return $result->result;
    }

    /*private function syncCurrentCreaTers()
    {
        $result = LdapController::searchUtwentePost('(|(department=*B-CREA*)(department=*M-ITECH*))');
        if (isset($result->error)) {
            $this->error('Error: ' . $result->error);
            exit();
        }
        $students = collect($result->result);
        $bar = $this->output->createProgressBar(Member::count());
        $bar->start();
        // Loop over all members and determine if they are studying CreaTe.
        Member::chunk(100, function ($members) use ($students, $bar) {
            $newUTAccounts = collect();
            foreach ($members as $member) {
                $student = $students->first(function ($student) use ($member, $newUTAccounts) {
                    return $student['uid'] == $member->user->utwente_username
                        || $student['userprincipalname'] == strtolower($member->user->email)
                        || strtolower($member->user->name) == strtolower($student['givenname'] . ' ' . $student['sn']);
                });
                if ($student) {
                    $newUTAccounts->push($this->formatUserInfo($member->user, $student));
                }
                $bar->advance();
            }
            UTAccount::insert($newUTAccounts->toArray());
        });
        $bar->finish();
        $this->info('Created ' . UtAccount::count() . ' UT accounts for members who currently study create or ITech.');
    }*/
}