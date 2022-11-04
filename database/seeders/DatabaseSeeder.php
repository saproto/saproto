<?php

namespace Database\Seeders;

use App;
use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Artisan;
use Proto\Models\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * @throws Exception
     */
    public function run()
    {
        if (App::environment('production')) {
            throw new Exception('You cannot seed your database outside the development environment.');
        }

        echo PHP_EOL;
        echo "\e[33mSeeding:\e[0m   \e[1mDatabaseSeeder\e[0m".PHP_EOL;
        $seeder_start = microtime(true);

        Model::unguard();

        echo "\e[33mFixing:\e[0m    roles and permissions".PHP_EOL;
        Artisan::call('proto:syncroles');
        echo "\e[32mFixed:\e[0m     roles and permissions".PHP_EOL;

        $adminPassword = str_random(16);

        echo PHP_EOL;
        $importSeeder = new ImportLiveDataSeeder();
        $importSeeder->run($adminPassword);

        // TODO: Replace deprecated factory() with new Database\Factories
        echo PHP_EOL;
        $otherSeeder = new OtherDataSeeder();
        $otherSeeder->run();

        echo PHP_EOL;
        $photoSeeder = new PhotoSeeder();
        $photoSeeder->run();

        Model::reguard();

        $adminUsername = User::find(1)->getPublicId();

        echo PHP_EOL;
        echo "\e[32mCreated:\e[0m   admin user".PHP_EOL;
        echo "\e[1musername:\e[0m  $adminUsername".PHP_EOL;
        echo "\e[1mpassword:\e[0m  $adminPassword".PHP_EOL;
        echo PHP_EOL;

        $seeder_end = microtime(true);
        echo "\e[32mSeeded:\e[0m    \e[1mDatabaseSeeder\e[0m  (".round(($seeder_end - $seeder_start), 2).'s)'.PHP_EOL;
    }
}
