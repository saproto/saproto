<?php

namespace App\Console\Commands;

use App\Models\Event;
use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;

#[Description('A command to recount the unique users count for all events.')]
#[Signature('proto:refreshuniqueusers')]
class RefreshEventUniqueUsers extends Command
{
    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $query = Event::query()
            ->with('tickets');

        $bar = $this->output->createProgressBar($query->count());
        $bar->start();

        $query->chunk(25, static function ($events) use ($bar) {
            foreach ($events as $event) {
                $event->updateUniqueUsersCount();
                $bar->advance();
            }
        });
    }
}
