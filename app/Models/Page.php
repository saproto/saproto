<?php

namespace App\Models;

use App\Enums\PageEnum;
use Database\Factories\PageFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\App;
use Spatie\Image\Enums\Fit;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

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
 * @property bool $show_attachments
 *
 * @method static PageFactory factory($count = null, $state = [])
 * @method static Builder<static>|Page newModelQuery()
 * @method static Builder<static>|Page newQuery()
 * @method static Builder<static>|Page onlyTrashed()
 * @method static Builder<static>|Page query()
 * @method static Builder<static>|Page whereContent($value)
 * @method static Builder<static>|Page whereCreatedAt($value)
 * @method static Builder<static>|Page whereDeletedAt($value)
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
class Page extends Model implements HasMedia
{
    /** @use HasFactory<PageFactory>*/
    use HasFactory;

    use InteractsWithMedia;

    protected $table = 'pages';

    protected $guarded = ['id'];

    protected $with = ['media'];

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('files')
            ->acceptsMimeTypes(['application/pdf'])
            ->useDisk(App::environment('local') ? 'local' : 'stack');

        $this->addMediaCollection('images')
            ->acceptsMimeTypes(['image/jpeg', 'image/png', 'image/jpg', 'image/webp'])
            ->useDisk(App::environment('local') ? 'local' : 'stack')
            ->storeConversionsOnDisk('public');
    }

    public function registerMediaConversions(?Media $media = null): void
    {
        $this->addMediaConversion(PageEnum::LARGE->value)
            ->performOnCollections('images')
            ->nonQueued()
            ->fit(Fit::Max, 1920, 1920)
            ->format('webp');
    }

    public function getImageUrl(PageEnum $pageEnum = PageEnum::LARGE): string
    {
        return $this->getFirstMediaUrl('images', $pageEnum->value);
    }

    /**
     * @return BelongsTo<StorageEntry, $this>
     */
    public function featuredImage(): BelongsTo
    {
        return $this->belongsTo(StorageEntry::class, 'featured_image_id');
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
