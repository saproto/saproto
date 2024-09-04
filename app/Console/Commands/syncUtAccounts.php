<?php

namespace App\Console\Commands;

use App\Http\Controllers\LdapController;
use App\Models\UtAccount;
use Illuminate\Console\Command;

class syncUtAccounts extends Command
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
    protected $description = 'Syncs all users with an UT account to the database.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        /* Primary/secondary divide:
            * 1. Users who are currently studying and have a UT account, are automatically primary members
            * 2. Users who are currently studying but do not do CreaTe/I-Tech anymore, are also still primary members (assume they once have linked their account while doing create)
            * 3. Users who indicate they have another primary association, are secondary members
            * 4. Users who do not study anymore, are automatically secondary members
            * */

    }

    function syncUsers($users, string $UTIdentifier, string $userColumn): void
    {
        $sns = implode('', array_map(function ($studentNumber) use ($UTIdentifier) {
            return "($UTIdentifier=$studentNumber)";
        }, $users->pluck($userColumn)->toArray()));

        //get the results from the LDAP server
        $result = LdapController::searchUtwentePost("(&(|(department=*B-CREA*)(department=*M-ITECH*))(|$sns))");
        //check that we have a valid response
        if (isset($result->error)) {
            $this->error('Error: ' . $result->error);
            return;
        }

        $students = $result->result;

        $bar = $this->output->createProgressBar(count($students));
        $bar->start();

        $newUTAccounts = collect();
        //loop through all students and update their information (in_array($member->user->utwente_username, $usernames))
        foreach ($students as $student) {
            $account = $users->filter(function ($user) use ($student, $userColumn, $UTIdentifier) {
                return strtolower($user[$userColumn]) == strtolower($student[$UTIdentifier]);
            })->first();


            if ($account == null) {
                $this->error('Could not find user with ' . $student[$UTIdentifier]);
                continue;
            }

            $bar->advance();
        }
        UTAccount::insert($newUTAccounts->toArray());
        $bar->finish();
    }
}
