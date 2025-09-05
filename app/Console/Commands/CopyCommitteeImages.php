<?php

namespace App\Console\Commands;

use App\Models\Committee;
use Exception;
use Illuminate\Console\Command;

class CopyCommitteeImages extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'proto:copy-committee-pictures';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Copies the committee pictures from our own storage entries to the laravel media library';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        Committee::query()->whereHas('image')
            ->with('image')->chunkById(100, function ($committees) {
                /** @var Committee $committee */
                foreach ($committees as $committee) {
                    try {
                        $committee->addMedia($committee->image->generateLocalPath())
                            ->usingName($committee->image->original_filename)
                            ->usingFileName('committee_'.$committee->id)
                            ->preservingOriginal()
                            ->toMediaCollection();

                        $committee->update(['image_id' => null]);
                    } catch (Exception $e) {
                        $this->warn('Committee: '.$committee->id.' error: '.$e->getMessage());
                    }
                }
            });
    }
}
