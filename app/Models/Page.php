<?php

namespace App\Models;

use Database\Factories\PageFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Carbon;

/**
 * App\Models\Page.
 *
 * @property int $id
 * @property string $title
 * @property string $slug
 * @property string $content
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property bool $is_member_only
 * @property Carbon|null $deleted_at
 * @property int|null $featured_image_id
 * @property bool $show_attachments
 * @property-read StorageEntry|null $featuredImage
 * @property-read Collection<int, StorageEntry> $files
 * @property-read int|null $files_count
 *
 * @method static PageFactory factory($count = null, $state = [])
 * @method static Builder<static>|Page newModelQuery()
 * @method static Builder<static>|Page newQuery()
 * @method static Builder<static>|Page onlyTrashed()
 * @method static Builder<static>|Page query()
 * @method static Builder<static>|Page whereContent($value)
 * @method static Builder<static>|Page whereCreatedAt($value)
 * @method static Builder<static>|Page whereDeletedAt($value)
 * @method static Builder<static>|Page whereFeaturedImageId($value)
 * @method static Builder<static>|Page whereId($value)
 * @method static Builder<static>|Page whereIsMemberOnly($value)
 * @method static Builder<static>|Page whereShowAttachments($value)
 * @method static Builder<static>|Page whereSlug($value)
 * @method static Builder<static>|Page whereTitle($value)
 * @method static Builder<static>|Page whereUpdatedAt($value)
 * @method static Builder<static>|Page withTrashed()
 * @method static Builder<static>|Page withoutTrashed()
 *
 * @mixin \Eloquent
 */
class Page extends Model
{
    /** @use HasFactory<PageFactory>*/
    use HasFactory;

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

    protected function casts(): array
    {
        return [
            'is_member_only' => 'boolean',
            'show_attachments' => 'boolean',
        ];
    }
}
