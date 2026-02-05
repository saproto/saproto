<?php

namespace App\Models;

use App\Enums\PhotoEnum;
use Database\Factories\PhotoAlbumFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Override;

/**
 * App\Models\PhotoAlbum.
 *
 * @property int $id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string $name
 * @property int $date_create
 * @property int $date_taken
 * @property int|null $thumb_id
 * @property int|null $event_id
 * @property bool $private
 * @property bool $published
 * @property-read Event|null $event
 * @property-read Collection<int, Photo> $items
 * @property-read int|null $items_count
 * @property-read Photo|null $thumbPhoto
 *
 * @method static PhotoAlbumFactory factory($count = null, $state = [])
 * @method static Builder<static>|PhotoAlbum name(string $name)
 * @method static Builder<static>|PhotoAlbum newModelQuery()
 * @method static Builder<static>|PhotoAlbum newQuery()
 * @method static Builder<static>|PhotoAlbum query()
 * @method static Builder<static>|PhotoAlbum whereCreatedAt($value)
 * @method static Builder<static>|PhotoAlbum whereDateCreate($value)
 * @method static Builder<static>|PhotoAlbum whereDateTaken($value)
 * @method static Builder<static>|PhotoAlbum whereEventId($value)
 * @method static Builder<static>|PhotoAlbum whereId($value)
 * @method static Builder<static>|PhotoAlbum whereName($value)
 * @method static Builder<static>|PhotoAlbum wherePrivate($value)
 * @method static Builder<static>|PhotoAlbum wherePublished($value)
 * @method static Builder<static>|PhotoAlbum whereThumbId($value)
 * @method static Builder<static>|PhotoAlbum whereUpdatedAt($value)
 *
 * @mixin Model
 */
class PhotoAlbum extends Model
{
    /** @use HasFactory<PhotoAlbumFactory>*/
    use HasFactory;

    protected $table = 'photo_albums';

    protected $guarded = ['id'];

    protected $with = ['thumbPhoto'];

    #[Override]
    protected static function booted(): void
    {
        /** @param Builder<$this> $query */
        static::addGlobalScope('published', fn (Builder $query) => $query->unless(Auth::user()?->can('protography'), fn ($query) => $query->where('published', true)));
        /** @param Builder<$this> $query */
        static::addGlobalScope('private', fn (Builder $query) => $query->unless(Auth::user()?->is_member, fn ($query) => $query->where('private', false)));
    }

    /**
     * @return BelongsTo<Event, $this>
     */
    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class, 'event_id');
    }

    /**
     * @return HasOne<Photo, $this>
     */
    public function thumbPhoto(): HasOne
    {
        return $this->hasOne(Photo::class, 'id', 'thumb_id');
    }

    /**
     * @return HasMany<Photo, $this>
     */
    public function items(): HasMany
    {
        return $this->hasMany(Photo::class, 'album_id')->orderBy('date_taken');
    }

    /** @param Builder<$this> $query
     * @return Builder<$this>
     * */
    protected function scopeName(Builder $query, string $name): Builder
    {
        return $query->whereLike('name', '%'.$name.'%');
    }

    public function thumb(): ?string
    {
        return $this->thumbPhoto?->getUrl(PhotoEnum::SMALL);
    }

    protected function casts(): array
    {
        return [
            'published' => 'boolean',
            'private' => 'boolean',
        ];
    }
}
