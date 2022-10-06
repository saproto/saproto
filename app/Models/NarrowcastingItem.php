<?php

namespace Proto\Models;

use Carbon;
use DateInterval;
use Eloquent;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use stdClass;
use Youtube;

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
 * @method static Builder|NarrowcastingItem whereCampaignEnd($value)
 * @method static Builder|NarrowcastingItem whereCampaignStart($value)
 * @method static Builder|NarrowcastingItem whereCreatedAt($value)
 * @method static Builder|NarrowcastingItem whereId($value)
 * @method static Builder|NarrowcastingItem whereImageId($value)
 * @method static Builder|NarrowcastingItem whereName($value)
 * @method static Builder|NarrowcastingItem whereSlideDuration($value)
 * @method static Builder|NarrowcastingItem whereUpdatedAt($value)
 * @method static Builder|NarrowcastingItem whereYoutubeId($value)
 * @mixin Eloquent
 */
class NarrowcastingItem extends Model
{
    protected $table = 'narrowcasting';

    protected $guarded = ['id'];

    /** @return BelongsTo|StorageEntry */
    public function image()
    {
        return $this->belongsTo('Proto\Models\StorageEntry');
    }

    /** @return StdClass|null */
    public function video()
    {
        if ($this->youtube_id !== null) {
            try {
                return Youtube::getVideoInfo($this->youtube_id);
            } catch (Exception $e) {
                return null;
            }
        }
        return null;
    }

    /**
     * @return int
     * @throws Exception
     */
    public function videoDuration()
    {
        if ($this->youtube_id) {
            return date_create('@0')->add(new DateInterval($this->video()->contentDetails->duration))->getTimestamp();
        } else {
            return 0;
        }
    }
}
