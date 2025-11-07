<?php

namespace App\Console\Commands;

use App\Models\Photo;
use Illuminate\Console\Command;
use Illuminate\Contracts\Database\Query\Builder;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\Mime\MimeTypes;

class AddPhotoExtensions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'proto:addPhotoExtensions';

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
                $this->info("{$photos->first()->id}");
                foreach ($photos as $photo) {
                    foreach ($photo->media as $media) {
                        $disk = $media->disk;
                        $path = $media->getPathRelativeToRoot();

                        $mimeType = Storage::disk($disk)->mimeType($path);
                        $extension = MimeTypes::getDefault()->getExtensions($mimeType)[0] ?? null;

                        if (! $extension) {
                            $bar->advance();

                            continue;
                        }

                        if (pathinfo($media->file_name, PATHINFO_EXTENSION)) {
                            $bar->advance();

                            continue;
                        }

                        $media->file_name = $media->file_name.'.'.$extension;
                        $media->save();

                        $bar->advance();
                    }
                }
            });

        $bar->finish();
    }
}
