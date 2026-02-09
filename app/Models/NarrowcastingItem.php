<?php

namespace App\Models;

use App\Enums\NarrowcastingEnum;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\App;
use Spatie\Image\Enums\Fit;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

/**
 * Narrowcasting Item Model.
 *
 * @property int $id
 * @property string $name
 * @property int $campaign_start
 * @property int $campaign_end
 * @property int $slide_duration
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $youtube_id
 *
 * @method static Builder<static>|NarrowcastingItem newModelQuery()
 * @method static Builder<static>|NarrowcastingItem newQuery()
 * @method static Builder<static>|NarrowcastingItem query()
 * @method static Builder<static>|NarrowcastingItem whereCampaignEnd($value)
 * @method static Builder<static>|NarrowcastingItem whereCampaignStart($value)
 * @method static Builder<static>|NarrowcastingItem whereCreatedAt($value)
 * @method static Builder<static>|NarrowcastingItem whereId($value)
 * @method static Builder<static>|NarrowcastingItem whereName($value)
 * @method static Builder<static>|NarrowcastingItem whereSlideDuration($value)
 * @method static Builder<static>|NarrowcastingItem whereUpdatedAt($value)
 * @method static Builder<static>|NarrowcastingItem whereYoutubeId($value)
 *
 * @property-read MediaCollection<int, Media> $media
 * @property-read int|null $media_count
 *
 * @mixin Model
 */
class NarrowcastingItem extends Model implements HasMedia
{
    protected $table = 'narrowcasting';

    protected $guarded = ['id'];

    protected $with = ['media'];

    use InteractsWithMedia;

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('default')
            ->useDisk(App::environment('local') ? 'local' : 'stack')
            ->storeConversionsOnDisk('garage-public')
            ->singleFile();
    }

    public function registerMediaConversions(?Media $media = null): void
    {
        $this->addMediaConversion(NarrowcastingEnum::LARGE->value)
            ->nonQueued()
            ->fit(Fit::FillMax, 1366, 768)
            ->format('webp');

        $this->addMediaConversion(NarrowcastingEnum::SMALL->value)
            ->nonQueued()
            ->fit(Fit::Max, 500)
            ->format('webp');
    }

    public function getImageUrl(NarrowcastingEnum $narrowcastingEnum = NarrowcastingEnum::LARGE): string
    {
        return $this->getFirstMediaUrl('default', $narrowcastingEnum->value);
    }
}
