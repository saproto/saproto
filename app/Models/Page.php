<?php

namespace Proto\Models;

use Carbon;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Proto\Models\Page.
 *
 * @property int $id
 * @property string $title
 * @property string $slug
 * @property string $content
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property int $is_member_only
 * @property string|null $deleted_at
 * @property int|null $featured_image_id
 * @property int $show_attachments
 * @property-read StorageEntry|null $featuredImage
 * @property-read Collection|StorageEntry[] $files
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|Page onlyTrashed()
 * @method static \Illuminate\Database\Query\Builder|Page withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Page withoutTrashed()
 * @method static bool|null restore()
 * @method static Builder|Page whereContent($value)
 * @method static Builder|Page whereCreatedAt($value)
 * @method static Builder|Page whereDeletedAt($value)
 * @method static Builder|Page whereFeaturedImageId($value)
 * @method static Builder|Page whereId($value)
 * @method static Builder|Page whereIsMemberOnly($value)
 * @method static Builder|Page whereShowAttachments($value)
 * @method static Builder|Page whereSlug($value)
 * @method static Builder|Page whereTitle($value)
 * @method static Builder|Page whereUpdatedAt($value)
 * @mixin Eloquent
 */
class Page extends Model
{
    use SoftDeletes;

    protected $table = 'pages';

    protected $guarded = ['id'];

    /** @return BelongsTo|StorageEntry */
    public function featuredImage()
    {
        return $this->belongsTo('Proto\Models\StorageEntry', 'featured_image_id');
    }

    /** @return BelongsToMany|StorageEntry[] */
    public function files()
    {
        return $this->belongsToMany('Proto\Models\StorageEntry', 'pages_files', 'page_id', 'file_id');
    }

    /** @return string */
    public function getUrl()
    {
        return route('page::show', $this->slug);
    }
}
