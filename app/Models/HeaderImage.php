<?php

namespace App\Models;

use App;
use App\Enums\HeaderImageEnum;
use Database\Factories\HeaderImageFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cache;
use Override;
use Spatie\Image\Enums\Fit;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

/**
 * Header Image Model.
 *
 * @property int $id
 * @property string $title
 * @property int|null $credit_id
 * @property int $image_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read StorageEntry|null $StorageEntry
 * @property-read StorageEntry|null $image
 * @property-read User|null $user
 *
 * @method static HeaderImageFactory factory($count = null, $state = [])
 * @method static Builder<static>|HeaderImage newModelQuery()
 * @method static Builder<static>|HeaderImage newQuery()
 * @method static Builder<static>|HeaderImage query()
 * @method static Builder<static>|HeaderImage whereCreatedAt($value)
 * @method static Builder<static>|HeaderImage whereCreditId($value)
 * @method static Builder<static>|HeaderImage whereId($value)
 * @method static Builder<static>|HeaderImage whereImageId($value)
 * @method static Builder<static>|HeaderImage whereTitle($value)
 * @method static Builder<static>|HeaderImage whereUpdatedAt($value)
 *
 * @mixin \Eloquent
 */
class HeaderImage extends Model implements HasMedia
{
    /** @use HasFactory<HeaderImageFactory>*/
    use HasFactory;

    use InteractsWithMedia;

    protected $table = 'headerimages';

    protected $guarded = ['id'];

    protected $with = ['media'];

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('default')
            ->useDisk(App::environment('local') ? 'local' : 'stack')
            ->storeConversionsOnDisk('public')
            ->singleFile();
    }

    public function registerMediaConversions(?Media $media = null): void
    {
        $this->addMediaConversion(HeaderImageEnum::LARGE->value)
            ->nonQueued()
            ->fit(Fit::Crop, 1500, 400)
            ->format('webp');
    }

    public function getImageUrl(HeaderImageEnum $headerImageEnum = HeaderImageEnum::LARGE): string
    {
        return $this->getFirstMediaUrl('default', $headerImageEnum->value);
    }

    /**
     * @return BelongsTo<User, $this>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'credit_id');
    }

    #[Override]
    protected static function boot(): void
    {
        parent::boot();

        static::saved(function (HeaderImage $headerImage) {
            Cache::forget('home.headerimages');
        });
    }
}
