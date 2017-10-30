<?php

namespace Proto\Console\Commands;

use Illuminate\Console\Command;

use DB;

class ClearSessionTable extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'proto:clearsessions';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clear the session table to prevent it from getting too big.';

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
        DB::table('sessions')->where('last_activity', '<', strtotime('-1 week'))->delete();
        $this->info('Done!');
    }
}
