<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Proto\Models\Committee;
use Proto\Models\CommitteeMembership;
use Proto\Models\Member;
use Proto\Models\User;

class ImportLiveDataSeeder extends Seeder
{
    /**
     * This seeder imports some non-sensitive data from the live environment to make your development environment more 'real'.
     *
     * @return void
     * @throws Exception
     */
    public function run()
    {

        // First let's create our user.
        $userData = (array) self::getDataFromExportApi('user');
        $memberData = (array) (array_key_exists('member', $userData) ? $userData['member'] : null);
        unset($userData['member']);
        unset($userData['photo']);
        unset($userData['roles']);
        unset($userData['is_member']);
        unset($userData['photo_preview']);
        unset($userData['welcome_message']);
        unset($userData['is_protube_admin']);
        unset($userData['use_dark_theme']);
        unset($userData['created_at']);
        unset($memberData['created_at']);
        $userData['id'] = 1;

        $newUser = User::create($userData);
        $newUser->save();

        $newPassword = str_random(16);
        $newUser->setPassword($newPassword);

        if ($memberData) {
            $newMember = Member::create($memberData);
            $newMember->user_id = 1;
            $newMember->save();
        }

        echo 'Your new user has been created with your own log-in details password: '.$newPassword.PHP_EOL;

        // Now let's import all data we can from the live environment.
        $tables = [
            ['name' => 'accounts'],
            ['name' => 'achievement'],
            ['name' => 'activities'],
            ['name' => 'committees'],
            ['name' => 'committees_activities'],
            ['name' => 'companies'],
            ['name' => 'events', 'excluded_columns' => ['formatted_date', 'is_future']],
            ['name' => 'mailinglists'],
            ['name' => 'menu_items'],
            ['name' => 'products'],
            ['name' => 'products_categories'],
            ['name' => 'product_categories'],
            ['name' => 'tickets'],
        ];

        foreach ($tables as $table) {
            echo 'Importing table '.$table['name'].PHP_EOL;
            $data = (array) self::getDataFromExportApi($table['name']);
            foreach ($data as $entry) {
                $entry = (array) $entry;

                if (isset($table['exclude_columns'])) {
                    foreach ($table['excluded_columns'] as $column) {
                        unset($entry[$column]);
                    }
                }

                DB::table($table['name'])->insert($entry);
            }
        }

        echo 'All data has been imported.'.PHP_EOL;

        // Now let's add our user account so that they can access everything.

        $root = Committee::where('slug', config('proto.rootcommittee'))->first();
        CommitteeMembership::create([
            'user_id' => $newUser->id,
            'committee_id' => $root->id,
            'role' => 'Automatically Added',
        ]);
        $newUser->assignRole('sysadmin');

        echo 'Your new user now has admin rights.'.PHP_EOL;
    }

    public static function getDataFromExportApi($table)
    {
        $local_url = route('api::user::dev_export', ['personal_key' => config('app-proto.personal-proto-key'), 'table' => $table]);
        $remote_url = str_replace(config('app-proto.app-url'), 'https://www.proto.utwente.nl/', $local_url);
        $encoded_data = file_get_contents($remote_url);
        return json_decode($encoded_data);
    }
}
