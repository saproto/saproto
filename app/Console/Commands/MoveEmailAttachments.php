<?php

namespace App\Console\Commands;

use App\Models\Email;
use Exception;
use Illuminate\Console\Command;

class MoveEmailAttachments extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'proto:move-email-attachments';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Copies the email attachments from our own storage entries to the laravel media library';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $query = Email::query()->whereHas('attachments')
            ->with('attachments')->orderBy('id');

        $bar = $this->output->createProgressBar($query->count());
        $bar->start();

        $query->chunkById(100, function ($emails) use ($bar) {
            /** @var Email $item */
            foreach ($emails as $item) {
                foreach ($item->attachments as $attachment) {
                    try {
                        $item->addMedia($attachment->generateLocalPath())
                            ->preservingOriginal()
                            ->toMediaCollection();
                        $attachment->delete();
                    } catch (Exception $exception) {
                        $this->warn('Email: '.$item->id.' attachment: '.$attachment->id.' error: '.$exception->getMessage());
                    }
                }

                $bar->advance();
            }
        });
        $bar->finish();
    }
}
