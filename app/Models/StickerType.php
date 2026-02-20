<?php

namespace App\Models;

use App\Enums\StickerTypeEnum;
use Database\Factories\StickerTypeFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\App;
use Spatie\Image\Enums\Fit;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class StickerType extends Model implements HasMedia
{
    /** @use HasFactory<StickerTypeFactory>*/
    use HasFactory;

    use InteractsWithMedia;

    protected $with = ['media'];

    protected $fillable = [
        'title',
    ];

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('default')
            ->useDisk(App::environment('local') ? 'local' : 'stack')
            ->storeConversionsOnDisk('garage-public')
            ->singleFile();
    }

    public function registerMediaConversions(?Media $media = null): void
    {
        $this->addMediaConversion(StickerTypeEnum::LARGE->value)
            ->nonQueued()
            ->fit(Fit::Crop, 1920, 1920)
            ->format('webp');

        $this->addMediaConversion(StickerTypeEnum::TINY->value)
            ->nonQueued()
            ->fit(Fit::Crop, 40, 40)
            ->format('webp');
    }

    /**
     * @return HasMany<Sticker, $this>
     */
    public function stickers(): HasMany
    {
        return $this->hasMany(Sticker::class);
    }

    public function getImageUrl(StickerTypeEnum $headerImageEnum = StickerTypeEnum::LARGE): string
    {
        return $this->getFirstMediaUrl('default', $headerImageEnum->value);
    }
}
