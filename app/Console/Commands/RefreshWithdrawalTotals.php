<?php

namespace App\Console\Commands;

use App\Models\Withdrawal;
use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;

#[Description('Refresh the calculated totals of each withdrawal.')]
#[Signature('proto:refreshwithdrawals')]
class RefreshWithdrawalTotals extends Command
{
    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $query = Withdrawal::query();
        $bar = $this->output->createProgressBar($query->count());
        $bar->start();
        $query->chunk(25, static function ($withdrawals) use ($bar) {
            foreach ($withdrawals as $withdrawal) {
                $withdrawal->recalculateTotals();
                $bar->advance();
            }
        });
    }
}
