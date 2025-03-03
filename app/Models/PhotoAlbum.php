<?php

namespace App\Models;

use Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Facades\Auth;
use Override;

/**
 * App\Models\PhotoAlbum.
 *
 * @property int $id
 * @property string $name
 * @property int $date_create
 * @property int $date_taken
 * @property int $thumb_id
 * @property int|null $event_id
 * @property bool $private
 * @property bool $published
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read \Illuminate\Support\Facades\Event|null $event
 * @property-read Photo $thumbPhoto
 * @property-read Collection|Photo[] $items
 *
 * @method static Builder|PhotoAlbum whereCreatedAt($value)
 * @method static Builder|PhotoAlbum whereDateCreate($value)
 * @method static Builder|PhotoAlbum whereDateTaken($value)
 * @method static Builder|PhotoAlbum whereEventId($value)
 * @method static Builder|PhotoAlbum whereId($value)
 * @method static Builder|PhotoAlbum whereName($value)
 * @method static Builder|PhotoAlbum wherePrivate($value)
 * @method static Builder|PhotoAlbum wherePublished($value)
 * @method static Builder|PhotoAlbum whereThumbId($value)
 * @method static Builder|PhotoAlbum whereUpdatedAt($value)
 * @method static Builder|PhotoAlbum newModelQuery()
 * @method static Builder|PhotoAlbum newQuery()
 * @method static Builder|PhotoAlbum query()
 *
 * @mixin Model
 */
class PhotoAlbum extends Model
{
    use HasFactory;

    protected $table = 'photo_albums';

    protected $guarded = ['id'];

    protected $with = ['thumbPhoto'];

    #[Override]
    protected static function booted(): void
    {
        static::addGlobalScope('published', fn (Builder $builder) => $builder->unless(Auth::user()?->can('protography'), fn ($builder) => $builder->where('published', true)));

        static::addGlobalScope('private', fn (Builder $builder) => $builder->unless(Auth::user()?->is_member, fn ($builder) => $builder->where('private', false)));
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
        return $this->hasMany(Photo::class, 'album_id');
    }

    /** @param Builder<PhotoAlbum> $query */
    public function scopeName(Builder $query, string $name): Builder
    {
        return $query->where('name', 'LIKE', '%'.$name.'%');
    }

    public function thumb(): ?string
    {
        if ($this->thumb_id) {
            return $this->thumbPhoto->thumbnail();
        }

        return null;
    }
}
