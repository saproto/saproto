<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * Narrowcasting Item Model.
 *
 * @property int $id
 * @property string $name
 * @property int|null $image_id
 * @property int $campaign_start
 * @property int $campaign_end
 * @property int $slide_duration
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $youtube_id
 * @property-read StorageEntry|null $image
 *
 * @method static Builder<static>|NarrowcastingItem newModelQuery()
 * @method static Builder<static>|NarrowcastingItem newQuery()
 * @method static Builder<static>|NarrowcastingItem query()
 * @method static Builder<static>|NarrowcastingItem whereCampaignEnd($value)
 * @method static Builder<static>|NarrowcastingItem whereCampaignStart($value)
 * @method static Builder<static>|NarrowcastingItem whereCreatedAt($value)
 * @method static Builder<static>|NarrowcastingItem whereId($value)
 * @method static Builder<static>|NarrowcastingItem whereImageId($value)
 * @method static Builder<static>|NarrowcastingItem whereName($value)
 * @method static Builder<static>|NarrowcastingItem whereSlideDuration($value)
 * @method static Builder<static>|NarrowcastingItem whereUpdatedAt($value)
 * @method static Builder<static>|NarrowcastingItem whereYoutubeId($value)
 *
 * @mixin \Eloquent
 */
class NarrowcastingItem extends Model
{
    protected $table = 'narrowcasting';

    protected $guarded = ['id'];

    /**
     * @return BelongsTo<StorageEntry, $this> */
    public function image(): BelongsTo
    {
        return $this->belongsTo(StorageEntry::class);
    }
}
