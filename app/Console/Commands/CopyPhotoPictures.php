<?php

namespace App\Console\Commands;

use App\Models\Photo;
use App\Models\PhotoAlbum;
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
        $albums = PhotoAlbum::query()->withoutGlobalScopes()->with(['items'=> function ($q){
            $q->withoutGlobalScopes()->whereHas('file')->with('file');
        }]);
        $bar = $this->output->createProgressBar($albums->count());
        $bar->start();
        $albums
           ->chunkById(100, function ($albums) use(&$bar) {
                foreach ($albums as $album) {

                    foreach ($album->items as $photo) {
                        $disk = $photo->private || $album->private ? 'local' : 'public';
                        try {
                            $photo->addMedia($photo->file->generateLocalPath())
                                ->usingName($photo->file->original_filename)
                                ->usingFileName($album->id.'_'.$photo->id)
                                ->preservingOriginal()
                                ->toMediaCollection(diskName: $disk);
                            if(!$photo->private && $album->private){
                                $photo->update(['private' => true]);
                            }
                        } catch (Exception $e) {
                            $this->warn('Photo: '.$photo->id.' error: '.$e->getMessage());
                        }
                    }
                    $bar->advance();
                }
            });

        $bar->finish();
    }
}
