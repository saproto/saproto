<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * @return string
     */
    public function run()
    {
        if (config('app.env') !== 'debug') {
            return "You cannot seed your database outside the development environment.";
        }

        echo "Starting database seeding." . PHP_EOL;

        $this->call(ImportLiveDataSeeder::class);
        $this->call(OtherDataSeeder::class);

        echo "Fixing roles." . PHP_EOL;

        Artisan::call('proto:generateroles');

        echo "Done!" . PHP_EOL;
    }
}
