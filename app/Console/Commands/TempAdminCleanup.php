<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Models\Tempadmin;
use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Date;

#[Description('Deletes all Temp Protube Admin users before today.')]
#[Signature('proto:tempadmincleanup')]
class TempAdminCleanup extends Command
{
    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $this->info('Cleaning up Temp Protube Admin users...');

        $tempAdmins = Tempadmin::query()->where('end_at', '<', Date::now()->startOfDay())->get();
        $tempAdmins->each(function (Tempadmin $tempAdmin) {
            $tempAdmin->delete();
        });

        $this->info('Deleted '.$tempAdmins->count().' Temp Protube Admin users.');
    }
}
