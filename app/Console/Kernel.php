<?php

namespace Proto\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        Commands\GenerateRoles::class,
        Commands\TestEmail::class,
        Commands\DirectAdminSync::class,
        Commands\ActiveDirectorySync::class,
        Commands\EmailCron::class,
        Commands\NewsletterCron::class,
        Commands\BirthdayCron::class,
        Commands\FlickrSync::class,
        Commands\PlaySound::class,
        Commands\AchievementsCron::class,
        Commands\FileCleanup::class,
        Commands\FeeCron::class,
        Commands\UserCleanup::class,
        Commands\CheckUtwenteAccounts::class
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('proto:dasync')->everyMinute();
        $schedule->command('proto:adsync')->everyTenMinutes();
        $schedule->command('proto:emailcron')->everyMinute();
        $schedule->command('proto:birthdaycron')->daily()->at('00:01');
        $schedule->command('proto:flickrsync')->everyThirtyMinutes();
        $schedule->command('proto:playsound ganaarjecollege')->daily()->at('13:37');
        $schedule->command('proto:achievementscron')->daily()->at('00:10');
        $schedule->command('proto:usercleanup')->hourly();
        $schedule->command('proto:filecleanup')->daily()->at('04:00');
        $schedule->command('proto:feecron')->daily()->at('02:00');
        $schedule->command('proto:checkutaccounts')->monthly();
    }
}
