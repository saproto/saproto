<?php

namespace App\Console\Commands;

use App\Models\Withdrawal;
use Illuminate\Console\Command;

class RefreshWithdrawalTotals extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'proto:refreshwithdrawals';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Refresh the calculated totals of each withdrawal.';

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
