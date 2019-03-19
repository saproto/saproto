<?php

namespace Proto\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Proto\Console\Commands\MemberRenewCron;

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
        Commands\MailAliasSync::class,
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
        Commands\VerifyPersonalDetailsEmailCron::class,
        Commands\HelperNotificationsCron::class,
        Commands\HelperReminderCron::class,
        Commands\PrintActiveMembers::class,
        Commands\MemberRenewCron::class,
        Commands\OmNomComCleanup::class
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('proto:aliassync')->everyMinute();
        $schedule->command('proto:emailcron')->everyMinute();

        $schedule->command('proto:adsync')->everyTenMinutes();
        $schedule->command('proto:spotifyupdate')->everyTenMinutes();

        $schedule->command('proto:flickrsync')->hourly();
        $schedule->command('proto:usercleanup')->hourly();

        $schedule->command('proto:birthdaycron')->daily()->at('00:01');
        $schedule->command('proto:achievementscron')->daily()->at('00:10');
        $schedule->command('proto:clearsessions')->daily()->at('01:00');
        $schedule->command('proto:feecron')->daily()->at('02:00');
        $schedule->command('proto:adsync --full')->daily()->at('03:00');
        $schedule->command('proto:filecleanup')->daily()->at('04:00');
        $schedule->command('proto:spotifysync')->daily()->at('05:00');
        $schedule->command('proto:omnomcleanup')->daily()->at('06:00');
        $schedule->command('proto:helperremindercron')->daily()->at('08:00');

        $schedule->command('proto:playsound ' . config('proto.soundboardSounds')['1337'])->daily()->at('13:37');

        $schedule->command('proto:checkutaccounts')->monthly();
        $schedule->command('proto:verifydetailscron')->monthlyOn(1, '12:00');

        $schedule->command('proto:memberrenewcron')->cron('0 2 1 8 *');
    }
}
