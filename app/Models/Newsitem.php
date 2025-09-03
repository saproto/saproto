<?php

namespace App\Models;

use Database\Factories\NewsitemFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cache;
use Override;

/**
 * News Item Model.
 *
 * @property int $id
 * @property int $user_id
 * @property string $title
 * @property string $content
 * @property int|null $featured_image_id
 * @property string|null $published_at
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 * @property bool $is_weekly
 * @property-read Collection<int, Event> $events
 * @property-read int|null $events_count
 * @property-read StorageEntry|null $featuredImage
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
 * @method static Builder<static>|Newsitem whereFeaturedImageId($value)
 * @method static Builder<static>|Newsitem whereId($value)
 * @method static Builder<static>|Newsitem whereIsWeekly($value)
 * @method static Builder<static>|Newsitem wherePublishedAt($value)
 * @method static Builder<static>|Newsitem whereTitle($value)
 * @method static Builder<static>|Newsitem whereUpdatedAt($value)
 * @method static Builder<static>|Newsitem whereUserId($value)
 * @method static Builder<static>|Newsitem withTrashed()
 * @method static Builder<static>|Newsitem withoutTrashed()
 *
 * @mixin \Eloquent
 */
class Newsitem extends Model
{
    /** @use HasFactory<NewsitemFactory>*/
    use HasFactory;

    use SoftDeletes;

    protected $table = 'newsitems';

    protected $guarded = ['id'];

    protected $with = ['featuredImage'];

    /**
     * @return BelongsTo<User, $this>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * @return BelongsToMany<Event, $this>
     */
    public function events(): BelongsToMany
    {
        return $this->belongsToMany(Event::class, 'event_newsitem');
    }

    /**
     * @return BelongsTo<StorageEntry, $this>
     */
    public function featuredImage(): BelongsTo
    {
        return $this->belongsTo(StorageEntry::class, 'featured_image_id');
    }

    public function isPublished(): bool
    {
        return Carbon::parse($this->published_at)->isPast();
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
