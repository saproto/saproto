<?php

namespace App\Console\Commands;

use App\Models\Event;
use Exception;
use Illuminate\Console\Command;

class CopyEventPictures extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'proto:copy-event-pictures';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Copies the event pictures from our own storage entries to the laravel media library';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        Event::query()->withTrashed()->whereHas('image')
            ->with('image')->chunkById(100, function ($events) {
                /** @var Event $event */
                foreach ($events as $event) {
                    try {
                        $event->addMedia($event->image->generateLocalPath())
                            ->usingName($event->image->original_filename)
                            ->usingFileName('event_'.$event->id)
                            ->preservingOriginal()
                            ->toMediaCollection('header');

                        $event->update(['image_id' => null]);
                    } catch (Exception $e) {
                        $this->warn('Event: '.$event->id.' error: '.$e->getMessage());
                    }
                }
            });
    }
}
