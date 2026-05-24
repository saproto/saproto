<?php

namespace App\Console\Commands;

use App\Models\QrAuthRequest;
use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;

#[Description('Clear the session table to prevent it from getting too big.')]
#[Signature('proto:clearsessions')]
class ClearSessionTable extends Command
{
    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        DB::table('sessions')->where('last_activity', '<', Date::now()->subWeek()->toDateTimeString())->delete();
        QrAuthRequest::query()->where('updated_at', '<', Date::now()->subMinutes(10)->toDateTimeString())->delete();
        $this->info('Done!');
    }
}
