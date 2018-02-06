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
        Commands\CheckUtwenteAccounts::class,
        Commands\SpotifySync::class,
        Commands\SpotifyUpdate::class,
        Commands\TestIBANs::class,
        Commands\ClearSessionTable::class,
        Commands\CountPrimaryMembers::class,
        Commands\VerifyPersonalDetailsEmailCron::class
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
        $schedule->command('proto:adsync --full')->daily()->at('04:00');
        $schedule->command('proto:clearsessions')->daily();
        $schedule->command('proto:emailcron')->everyMinute();
        $schedule->command('proto:birthdaycron')->daily()->at('00:01');
        $schedule->command('proto:flickrsync')->hourly();
        $schedule->command('proto:playsound ' . config('proto.soundboardSounds')['1337'])->daily()->at('13:37');
        $schedule->command('proto:achievementscron')->daily()->at('00:10');
        $schedule->command('proto:usercleanup')->hourly();
        $schedule->command('proto:filecleanup')->daily()->at('04:00');
        $schedule->command('proto:feecron')->daily()->at('02:00');
        $schedule->command('proto:checkutaccounts')->monthly();
        $schedule->command('proto:spotifysync')->daily()->at('00:00');
        $schedule->command('proto:spotifyupdate')->everyTenMinutes();
        $schedule->command('proto:verifydetailscron')->monthlyOn(1, '12:00');
    }
}
