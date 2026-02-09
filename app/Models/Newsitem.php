<?php

namespace App\Models;

use App\Enums\NewsEnum;
use Database\Factories\NewsitemFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Date;
use Override;
use Spatie\Image\Enums\Fit;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

/**
 * News Item Model.
 *
 * @property int $id
 * @property int $user_id
 * @property string $title
 * @property string $content
 * @property string|null $published_at
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 * @property bool $is_weekly
 * @property-read Collection<int, Event> $events
 * @property-read int|null $events_count
 * @property-read mixed $url
 * @property-read User|null $user
 *
 * @method static NewsitemFactory factory($count = null, $state = [])
 * @method static Builder<static>|Newsitem newModelQuery()
 * @method static Builder<static>|Newsitem newQuery()
 * @method static Builder<static>|Newsitem onlyTrashed()
 * @method static Builder<static>|Newsitem query()
 * @method static Builder<static>|Newsitem whereContent($value)
 * @method static Builder<static>|Newsitem whereCreatedAt($value)
 * @method static Builder<static>|Newsitem whereDeletedAt($value)
 * @method static Builder<static>|Newsitem whereId($value)
 * @method static Builder<static>|Newsitem whereIsWeekly($value)
 * @method static Builder<static>|Newsitem wherePublishedAt($value)
 * @method static Builder<static>|Newsitem whereTitle($value)
 * @method static Builder<static>|Newsitem whereUpdatedAt($value)
 * @method static Builder<static>|Newsitem whereUserId($value)
 * @method static Builder<static>|Newsitem withTrashed()
 * @method static Builder<static>|Newsitem withoutTrashed()
 *
 * @property-read MediaCollection<int, Media> $media
 * @property-read int|null $media_count
 *
 * @mixin Model
 */
class Newsitem extends Model implements HasMedia
{
    /** @use HasFactory<NewsitemFactory>*/
    use HasFactory;

    use InteractsWithMedia;
    use SoftDeletes;

    protected $table = 'newsitems';

    protected $guarded = ['id'];

    protected $with = ['media'];

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('default')
            ->useDisk(App::environment('local') ? 'public' : 'stack')
            ->storeConversionsOnDisk('garage-public')
            ->singleFile();
    }

    public function registerMediaConversions(?Media $media = null): void
    {
        $this->addMediaConversion(NewsEnum::LARGE->value)
            ->nonQueued()
            ->fit(Fit::Crop, 1500, 350)
            ->format('webp');

        $this->addMediaConversion(NewsEnum::CARD->value)
            ->nonQueued()
            ->fit(Fit::Max, 600, 300)
            ->format('webp');
    }

    public function getImageUrl(NewsEnum $stickerEnum = NewsEnum::CARD): string
    {
        return $this->getFirstMediaUrl('default', $stickerEnum->value);
    }

    /**
     * @return BelongsTo<User, $this>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * @return BelongsToMany<Event, $this, Pivot>
     */
    public function events(): BelongsToMany
    {
        return $this->belongsToMany(Event::class, 'event_newsitem');
    }

    public function isPublished(): bool
    {
        return Date::parse($this->published_at)->isPast();
    }

    /**
     * @return Attribute<string, never>
     */
    protected function url(): Attribute
    {
        return Attribute::make(get: function (): string {
            if ($this->is_weekly) {
                return route('news::showWeeklyPreview', ['id' => $this->id]);
            }

            return route('news::show', ['id' => $this->id]);
        });
    }

    protected function casts(): array
    {
        return [
            'is_weekly' => 'boolean',
        ];
    }

    #[Override]
    protected static function boot(): void
    {
        parent::boot();

        static::saved(function (Newsitem $newsitem) {
            Cache::forget('home.newsitems');
        });
    }
}
