<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Artisan;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        if (getenv('APP_ENV') !== 'local') {
            return "You cannot seed your database outside the development environment.";
        }

        echo "Starting database seeding." . PHP_EOL;
        $time_start = microtime(true);

        Model::unguard();

        $this->call(ImportLiveDataSeeder::class);
        $this->call(OtherDataSeeder::class);

        echo "Fixing roles." . PHP_EOL;

        Artisan::call('proto:generateroles');

        Model::reguard();

        $time_end = microtime(true);
        echo "Seeding took " . ($time_end - $time_start)/60 . " minutes" . PHP_EOL;

        echo "Done!" . PHP_EOL;
    }
}