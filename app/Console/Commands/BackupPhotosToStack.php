<?php

namespace App\Console\Commands;

use App\Models\Photo;
use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;
use Illuminate\Contracts\Database\Query\Builder;
use Illuminate\Support\Facades\Storage;

#[Description('Backup the photos to the stack drive')]
#[Signature('proto:backup-photos-to-stack')]
class BackupPhotosToStack extends Command
{
    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $photos = Photo::query()->withoutGlobalScopes()->whereHas('media')->whereHas('album', function (Builder $q) {
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
