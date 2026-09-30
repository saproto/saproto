<?php

namespace App\Console\Commands;

use App\Jobs\MoveMedia;
use App\Models\Committee;
use App\Models\Company;
use App\Models\Email;
use App\Models\Event;
use App\Models\HeaderImage;
use App\Models\Newsitem;
use App\Models\Page;
use App\Models\Product;
use App\Models\StickerType;
use App\Models\User;
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
        $toMove = collect([
            // 'current_disk model_type to_collection',
            ['stack', Event::class, 'default'],
            ['stack', Committee::class, 'default'],
            ['stack', Company::class, 'default'],
            ['stack', Email::class, 'default'],
            ['stack', HeaderImage::class, 'default'],
            ['stack', User::class, 'profile_picture'],
            ['stack', StickerType::class, 'default'],
            ['stack', Product::class, 'default'],
            ['stack', Newsitem::class, 'default'],
            ['stack', Page::class, 'files'],
            ['stack', Page::class, 'images'],
        ]);

        foreach ($toMove as $model) {
            $this->info('Moving media to garage for model: '.$model[1].' and collection: '.$model[2]);
            $disk = $model[0];
            $model = $model[1];
            $collection = $model[2];

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
}
