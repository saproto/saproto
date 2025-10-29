<?php

namespace App\Models;

use App\Enums\StickerEnum;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\App;
use Spatie\Image\Enums\Fit;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

/**
 * @property int $id
 * @property float $lat
 * @property float $lng
 * @property string|null $city
 * @property string|null $country
 * @property string|null $country_code
 * @property int $user_id
 * @property int $file_id
 * @property int|null $reporter_id
 * @property int $sticker_type_id
 * @property string|null $report_reason
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read User|null $reporter
 * @property-read User $user
 *
 * @method static Builder<static>|Sticker newModelQuery()
 * @method static Builder<static>|Sticker newQuery()
 * @method static Builder<static>|Sticker query()
 * @method static Builder<static>|Sticker whereCity($value)
 * @method static Builder<static>|Sticker whereCountry($value)
 * @method static Builder<static>|Sticker whereCountryCode($value)
 * @method static Builder<static>|Sticker whereCreatedAt($value)
 * @method static Builder<static>|Sticker whereFileId($value)
 * @method static Builder<static>|Sticker whereId($value)
 * @method static Builder<static>|Sticker whereLat($value)
 * @method static Builder<static>|Sticker whereLng($value)
 * @method static Builder<static>|Sticker whereReportReason($value)
 * @method static Builder<static>|Sticker whereReporterId($value)
 * @method static Builder<static>|Sticker whereUpdatedAt($value)
 * @method static Builder<static>|Sticker whereUserId($value)
 *
 * @property-read MediaCollection<int, Media> $media
 * @property-read int|null $media_count
 *
 * @mixin Model
 */
class Sticker extends Model implements HasMedia
{
    use InteractsWithMedia;

    protected $fillable = ['lat', 'lng', 'city', 'country', 'country_code', 'reporter_id', 'report_reason', 'user_id', 'created_at'];

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('default')
            ->useDisk(App::environment('local') ? 'public' : 'stack')
            ->storeConversionsOnDisk('public')
            ->singleFile();
    }

    public function registerMediaConversions(?Media $media = null): void
    {
        $this->addMediaConversion(StickerEnum::LARGE->value)
            ->nonQueued()
            ->fit(Fit::Max, 1920, 1920)
            ->format('webp');
    }

    public function getImageUrl(StickerEnum $stickerEnum = StickerEnum::LARGE): string
    {
        return $this->getFirstMediaUrl('default', $stickerEnum->value);
    }

    /**
     * @return BelongsTo<User, $this>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return BelongsTo<StickerType, $this>
     */
    public function stickerType(): BelongsTo
    {
        return $this->belongsTo(StickerType::class);
    }

    /**
     * @return BelongsTo<User, $this>
     */
    public function reporter(): BelongsTo
    {
        return $this->belongsTo(User::class, 'reporter_id');
    }
}
