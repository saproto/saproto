<?php

namespace App\Console\Commands;

use App\Jobs\MoveMedia;
use App\Models\Event;
use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

#[Signature('proto:move-media-to-garage')]
#[Description('Command description')]
class MoveMediaToGarage extends Command
{
    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $disk = 'stack';
        $model = Event::class;
        $collection = 'header';

        $query = Media::query()->where('disk', $disk)->where('model_type', $model)->with('model', function ($q) {
            $q->withoutGlobalScopes();
        });
        $query->chunkById(100, function ($medias) use ($collection) {
            foreach ($medias as $media) {
                /** @phpstan-ignore-next-line  */
                dispatch(new MoveMedia($media->model, $media, $collection))->onQueue('low');
            }
        });
    }
}
