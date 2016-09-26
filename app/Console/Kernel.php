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
        Commands\EmailCron::class,
        Commands\NewsletterCron::class,
        Commands\BirthdayCron::class
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
        $schedule->command('proto:emailcron')->everyMinute();
        $schedule->command('proto:newslettercron')->weekly()->mondays()->at('11:00');
        $schedule->command('proto:birthdaycron')->daily()->at('00:01');
    }
}
