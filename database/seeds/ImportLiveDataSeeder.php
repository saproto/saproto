<?php

use Illuminate\Database\Seeder;

use Proto\Models\User;
use Proto\Models\Committee;
use Proto\Models\CommitteeMembership;

class ImportLiveDataSeeder extends Seeder
{
    /**
     * This seeder imports some non-sensitive data from the live environment to make your development environment more 'real'.
     *
     * @return void
     */
    public function run()
    {

        // First let's create our user.
        $userData = (array)ImportLiveDataSeeder::getDataFromExportApi('user');
        $memberData = (array)(array_key_exists('member', $userData) ? $userData['member'] : null);
        unset($userData['member']);
        unset($userData['created_at']);
        unset($memberData['created_at']);

        $newUser = User::create($userData);
        $newUser->id = 1;
        $newUser->save();

        $newPassword = str_random(16);
        $newUser->setPassword($newPassword);

        if ($memberData) {
            $newMember = Member::create($memberData);
            $newMember->user_id = 1;
            $newMember->save();
        }

        echo 'Your new user has been created with your own log-in details password: ' . $newPassword . PHP_EOL;

        // Now let's import all data we can from the live environment.
        $tables = [
            'accounts',
            'achievement',
            'activities',
            'committees',
            'committees_activities',
            'events',
            'mailinglists',
            'permissions',
            'permission_role',
            'products',
            'products_categories',
            'product_categories',
            'roles',
            'studies',
            'tickets'
        ];

        foreach ($tables as $table) {
            echo "Importing table `$table`" . PHP_EOL;
            $data = (array)ImportLiveDataSeeder::getDataFromExportApi($table);
            foreach ($data as $entry) {
                DB::table($table)->insert((array)$entry);
            }

        }

        echo "All data has been imported." . PHP_EOL;

        // Now let's add our user account so that they can access everything.

        $rootcommittee = Committee::where('slug', config('proto.rootcommittee'))->first();
        CommitteeMembership::create([
            'user_id' => $newUser->id,
            'committee_id' => $rootcommittee->id,
            'role' => 'Automatically Added'
        ]);
        $newUser->attachRole(Role::where('name', '=', 'sysadmin')->first());

        echo 'Your new user now has admin rights.' . PHP_EOL;

    }

    public static function getDataFromExportApi($table)
    {
        $local_url = route('api::export', ['personal_key' => config('app-proto.personal-proto-key'), 'table' => $table]);
        $remote_url = str_replace(config('app-proto.app-url'), 'https://www.proto.utwente.nl', $local_url);
        $encoded_data = file_get_contents($remote_url);
        return json_decode($encoded_data);
    }
}
