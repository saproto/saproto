<?php

namespace App\Console\Commands;

use App\Models\OrderLine;
use App\Models\User;
use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;

#[Description('Anonymise all OmNomCom data older than 7 years for users who disabled their history.')]
#[Signature('proto:omnomcleanup')]
class OmNomComCleanup extends Command
{
    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $this->info('Starting clean-up.');

        $users = User::query()->where('keep_omnomcom_history', false)->pluck('id')->toArray();
        $orderlinesTable = (new OrderLine)->getTable();

        $affected = DB::table($orderlinesTable)
            ->whereIn('user_id', $users)
            ->where('created_at', '<', Date::now()->subYears(7)->format('Y-m-d'))
            ->update(['user_id' => null]);

        $this->info("Found and anonymised {$affected} orderlines.");
    }
}
