<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (getenv('APP_ENV') !== 'debug') {
            return "You cannot seed your database outside the development environment.";
        }

        echo "Starting database seeding." . PHP_EOL;

        Model::unguard();

        $this->call(ImportLiveDataSeeder::class);
        $this->call(OtherDataSeeder::class);

        echo "Fixing roles." . PHP_EOL;

        Artisan::call('proto:generateroles');

        Model::reguard();

        echo "Done!" . PHP_EOL;
    }
}
