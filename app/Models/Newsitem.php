<?php

namespace Proto\Models;

use Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Eloquent;
use Illuminate\Database\Query\Builder as QueryBuilder;

/**
 * News Item Model
 *
 * @property int $id
 * @property int $user_id
 * @property string $title
 * @property string $content
 * @property int|null $featured_image_id
 * @property string|null $published_at
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property-read StorageEntry|null $featuredImage
 * @property-read User $user
 * @method static bool|null forceDelete()
 * @method static bool|null restore()
 * @method static QueryBuilder|Newsitem onlyTrashed()
 * @method static QueryBuilder|Newsitem withTrashed()
 * @method static QueryBuilder|Newsitem withoutTrashed()
 * @method static Builder|Newsitem whereContent($value)
 * @method static Builder|Newsitem whereCreatedAt($value)
 * @method static Builder|Newsitem whereDeletedAt($value)
 * @method static Builder|Newsitem whereFeaturedImageId($value)
 * @method static Builder|Newsitem whereId($value)
 * @method static Builder|Newsitem wherePublishedAt($value)
 * @method static Builder|Newsitem whereTitle($value)
 * @method static Builder|Newsitem whereUpdatedAt($value)
 * @method static Builder|Newsitem whereUserId($value)
 * @mixin Eloquent
 */
class Newsitem extends Model
{
    use SoftDeletes;

    protected $table = 'newsitems';

    protected $guarded = ['id'];

    /** @return BelongsTo|User */
    public function user()
    {
        return $this->belongsTo('Proto\Models\User', 'user_id');
    }

    /** @return BelongsTo|StorageEntry */
    public function featuredImage()
    {
        return $this->belongsTo('Proto\Models\StorageEntry', 'featured_image_id');
    }

    /** @return bool */
    public function isPublished()
    {
        return Carbon::parse($this->published_at)->isPast();
    }

    /** @return string */
    public function getUrlAttribute()
    {
        return route('news::show', ['id' => $this->id]);
    }
}
