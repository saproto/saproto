<?php

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Artisan;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        if (getenv('APP_ENV') !== 'local') {
            return 'You cannot seed your database outside the development environment.';
        }

        echo 'Starting database seeding.'.PHP_EOL;
        $time_start = microtime(true);

        Model::unguard();

        echo 'Fixing roles.'.PHP_EOL;
        Artisan::call('proto:generateroles');

        $this->call(ImportLiveDataSeeder::class);
        $this->call(OtherDataSeeder::class);

        Model::reguard();

        $time_end = microtime(true);
        echo "\e[32mSeeding:\e[0m Finished! (".round(($time_end - $time_start), 2).'s)'.PHP_EOL;
    }
}
