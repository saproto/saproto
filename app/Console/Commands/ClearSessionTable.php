<?php

namespace App\Console\Commands;

use App\Models\QrAuthRequest;
use App\Models\Token;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

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
     */
    public function handle(): void
    {
        DB::table('sessions')->where('last_activity', '<', Carbon::now()->subWeek()->getTimestamp())->delete();
        Token::query()->where('updated_at', '<', Carbon::now()->subWeek()->toDateTimeString())->delete();
        QrAuthRequest::query()->where('updated_at', '<', Carbon::now()->subMinutes(10)->toDateTimeString())->delete();
        $this->info('Done!');
    }
}
