<?php

namespace App\Console\Commands;

use App\Models\Event;
use Exception;
use Illuminate\Console\Command;

class MoveMedia extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'proto:move-media';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        Event::query()->whereHas('media')->with('media')->chunk(100, function ($events) {
            foreach ($events as $event) {
                try {
                    $this->info('Processing Event '.$event->id);
                    $media = $event->getFirstMediaPath('header');
                    $event->addMedia($media)->toMediaCollection('header');
                } catch (Exception $exception) {
                    $this->error('Error processing event '.$event->id.': '.$exception->getMessage());
                }
            }
        });
    }
}
