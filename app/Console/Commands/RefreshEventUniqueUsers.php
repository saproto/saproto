<?php

namespace App\Console\Commands;

use App\Models\Event;
use App\Models\Withdrawal;
use Illuminate\Console\Command;

class RefreshEventUniqueUsers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'proto:refreshuniqueusers';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'A command to recount the unique users count for all events.';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $query=Event::query()
            ->with('activity.users')
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
