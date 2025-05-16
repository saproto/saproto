<?php

namespace App\Models;

use Database\Factories\PageFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Query\Builder as QueryBuilder;
use Illuminate\Support\Carbon;

/**
 * App\Models\Page.
 *
 * @property int $id
 * @property string $title
 * @property string $slug
 * @property string $content
 * @property int|null $featured_image_id
 * @property bool $is_member_only
 * @property bool $show_attachments
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property-read StorageEntry|null $featuredImage
 * @property-read Collection|StorageEntry[] $files
 *
 * @method static bool|null forceDelete()
 * @method static bool|null restore()
 * @method static QueryBuilder|Page onlyTrashed()
 * @method static QueryBuilder|Page withTrashed()
 * @method static QueryBuilder|Page withoutTrashed()
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
 * @method static Builder|Page newModelQuery()
 * @method static Builder|Page newQuery()
 * @method static Builder|Page query()
 *
 * @mixin Model
 */
class Page extends Model
{
    /** @use HasFactory<PageFactory>*/
    use HasFactory;
    use SoftDeletes;

    protected $table = 'pages';

    protected $guarded = ['id'];

    protected $with = ['featuredImage'];

    /**
     * @return BelongsTo<StorageEntry, $this>
     */
    public function featuredImage(): BelongsTo
    {
        return $this->belongsTo(StorageEntry::class, 'featured_image_id');
    }

    /**
     * @return BelongsToMany<StorageEntry, $this>
     */
    public function files(): BelongsToMany
    {
        return $this->belongsToMany(StorageEntry::class, 'pages_files', 'page_id', 'file_id');
    }

    public function getUrl(): string
    {
        return route('page::show', $this->slug);
    }
}
