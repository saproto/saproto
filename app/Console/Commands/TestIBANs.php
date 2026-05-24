<?php

namespace App\Console\Commands;

use App\Models\Bank;
use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;

#[Description('Verify all active SEPA withdrawal contracts and check whether they seem valid and within the SEPA zone.')]
#[Signature('proto:testibans')]
class TestIBANs extends Command
{
    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $this->info('Starting clean-up.');

        foreach (Bank::all() as $bank) {
            if (! verify_iban($bank->iban)) {
                $this->info('INVALID -- '.$bank->iban.' of '.$bank->user->name.'(#'.$bank->user->id.')');

                continue;
            }

            if (! iban_country_is_sepa(iban_get_country_part($bank->iban))) {
                $this->info('NONSEPA -- '.$bank->iban.' of '.$bank->user->name.'(#'.$bank->user->id.')');

                continue;
            }
        }

        $this->info('Check complete.');
    }
}
