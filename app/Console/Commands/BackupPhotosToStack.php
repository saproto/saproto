<?php

namespace App\Console\Commands;

use App\Models\Photo;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class BackupPhotosToStack extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'proto:backup-photos-to-stack';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Backup the photos to the stack drive';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $photos = Photo::query()->withoutGlobalScopes()->whereHas('media')->whereHas('album', function ($q) {
            $q->withoutGlobalScopes();
        })->with(['album' => function ($q) {
            $q->withoutGlobalScopes();
        }])->orderBy('photos.id')
            ->where('photos.id', '>', 0);
        $bar = $this->output->createProgressBar($photos->count());
        $bar->start();

        $photos
            ->chunkById(200, function ($photos) use ($bar) {
                foreach ($photos as $photo) {
                    $stackPath = $photo->album->id.'/'.$photo->id;
                    if (Storage::disk('stack_backup')->missing($stackPath)) {
                        $media = $photo->getFirstMedia('*');
                        $file = $media->getPathRelativeToRoot();
                        $content = Storage::disk($media->disk)->get($file);
                        Storage::disk('stack_backup')->put($stackPath, $content);
                    }

                    $bar->advance();
                }
            });

        $bar->finish();
    }
}
