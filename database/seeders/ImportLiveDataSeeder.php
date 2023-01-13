<?php

namespace Database\Seeders;

use Exception;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
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
    public function run($password)
    {
        echo "\e[33mSeeding:\e[0m   \e[1mImportDataSeeder\e[0m".PHP_EOL;
        $seeder_start = microtime(true);

        // First let's create our user.
        $userData = (array) self::getDataFromExportApi('user');
        if ($userData == null) {
            /** @var User $newUser */
            $newUser = factory(User::class)->create(['id' => 1]);
            /** @var Member $newMember */
            $newMember = factory(Member::class)->create(['user_id' => 1]);
            $newUser->setPassword($password);

            echo PHP_EOL;
            echo "\e[32mCreated:\e[0m   admin user".PHP_EOL;
            echo "\e[1musername:\e[0m  $newMember->proto_username".PHP_EOL;
            echo "\e[1mpassword:\e[0m  $password".PHP_EOL;
            echo PHP_EOL;

            throw new Exception(
                'You are not allowed to import data from the live website.'.PHP_EOL.
                'Make sure you are a member of the HYTTIOAOAc and have signed an NDA.'.PHP_EOL.
                'Otherwise you can continue without seeding the database.'
            );
        } else {
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
            unset($userData['permissions']);
            unset($memberData['created_at']);
            $userData['id'] = 1;

            $newUser = User::create($userData);
            $newUser->save();

            if ($memberData) {
                $newMember = Member::create($memberData);
                $newMember->user_id = 1;
                $newMember->save();
            }

            $newUser->setPassword($password);
        }

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
            ['name' => 'menuitems'],
            ['name' => 'products', 'excluded_columns' => ['image_url']],
            ['name' => 'products_categories'],
            ['name' => 'product_categories'],
            ['name' => 'tickets'],
        ];

        foreach ($tables as $table) {
            echo "\e[33mImporting:\e[0m ".$table['name'].PHP_EOL;
            $time_start = microtime(true);
            $data = (array) self::getDataFromExportApi($table['name']);
            foreach ($data as $entry) {
                $entry = (array) $entry;

                if (array_key_exists('excluded_columns', $table)) {
                    foreach ($table['excluded_columns'] as $column) {
                        unset($entry[$column]);
                    }
                }

                DB::table($table['name'])->insert($entry);
            }
            $time_end = microtime(true);
            echo "\e[32mImported:\e[0m  ".$table['name'].' ('.round(($time_end - $time_start), 2).'s)'.PHP_EOL;
        }

        // Now let's add our user account so that they can access everything.

        $root = Committee::where('slug', config('proto.rootcommittee'))->first();
        CommitteeMembership::create([
            'user_id' => $newUser->id,
            'committee_id' => $root->id,
            'role' => 'Automatically Added',
        ]);
        $newUser->assignRole('sysadmin');

        $seeder_end = microtime(true);
        echo "\e[32mSeeded:\e[0m    \e[1mImportDataSeeder\e[0m (".round(($seeder_end - $seeder_start), 2).'s)'.PHP_EOL;
    }

    /**
     * Import data from the live website export API.
     *
     * @param $table string The table to import from live website.
     * @return string|null Decoded JSON response.
     */
    public static function getDataFromExportApi($table)
    {
        $local_url = route('api::user::dev_export', ['personal_key' => config('app-proto.personal-proto-key'), 'table' => $table]);
        $remote_url = str_replace(config('app-proto.app-url'), 'https://www.proto.utwente.nl/', $local_url);
        $response = Http::get($remote_url);
        if ($response->failed()) {
            return null;
        }
        return json_decode($response);
    }
}
