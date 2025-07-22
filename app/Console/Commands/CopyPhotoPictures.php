<?php

namespace App\Console\Commands;

use App\Models\Photo;
use Exception;
use Illuminate\Console\Command;

class CopyPhotoPictures extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'proto:copy-photo-pictures';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Copies the photo pictures from our own storage entries to the laravel media library';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $photoQuery = Photo::query()->whereHas('file');
        $bar = $this->output->createProgressBar($photoQuery->count());
        $bar->start();
        $photoQuery
            ->with('file')->chunkById(100, function ($photos) use(&$bar) {
                /** @var Photo $photo */
                foreach ($photos as $photo) {

                    $disk = $photo->private ? 'local' : 'public';
                    try {
                        $photo->addMedia($photo->file->generateLocalPath())
                            ->usingName($photo->file->original_filename)
                            ->usingFileName('photo_'. $photo->id)
                            ->preservingOriginal()
                            ->toMediaCollection(diskName: $disk);
                        $photo->update(['file_id' => null]);
                        $bar->advance();

                    } catch (Exception $e) {
                        $this->warn('Photo: '.$photo->id.' error: '.$e->getMessage());
                        $bar->advance();
                    }
                }
            });

        $bar->finish();
    }
}
