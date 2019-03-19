<?php

namespace Proto\Console\Commands;

use Illuminate\Console\Command;

class HelperNotificationsCron extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'proto:helpernotificationcron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cronjob that sends the helper notifications.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {

    }
}
