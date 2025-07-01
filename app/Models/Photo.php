<?php

namespace App\Models;

use App\Enums\PhotoEnum;
use Database\Factories\PhotoFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Override;
use Spatie\Image\Enums\Fit;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

/**
 * Photo model.
 *
 * @property int $id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property int $file_id
 * @property int $album_id
 * @property int $date_taken
 * @property bool $private
 * @property-read PhotoAlbum|null $album
 * @property-read StorageEntry|null $file
 * @property-read Collection<int, PhotoLikes> $likes
 * @property-read int|null $likes_count
 * @property-read mixed $url
 *
 * @method static PhotoFactory factory($count = null, $state = [])
 * @method static Builder<static>|Photo newModelQuery()
 * @method static Builder<static>|Photo newQuery()
 * @method static Builder<static>|Photo query()
 * @method static Builder<static>|Photo whereAlbumId($value)
 * @method static Builder<static>|Photo whereCreatedAt($value)
 * @method static Builder<static>|Photo whereDateTaken($value)
 * @method static Builder<static>|Photo whereFileId($value)
 * @method static Builder<static>|Photo whereId($value)
 * @method static Builder<static>|Photo wherePrivate($value)
 * @method static Builder<static>|Photo whereUpdatedAt($value)
 *
 * @mixin \Eloquent
 */
class Photo extends Model implements HasMedia
{
    /** @use HasFactory<PhotoFactory>*/
    use HasFactory;

    use InteractsWithMedia;

    protected $table = 'photos';

    protected $guarded = ['id'];

    protected $with = ['file'];

    #[Override]
    protected static function booted(): void
    {
        /** @param Builder<$this> $query */
        static::addGlobalScope('private', function (Builder $query) {
            $query->unless(Auth::user()?->is_member, fn ($query) => $query->where('private', false)
                ->whereHas('album', function ($query) {
                    $query->where('private', false);
                }));
        });
        /** @param Builder<$this> $query */
        static::addGlobalScope('published', function (Builder $query) {
            $query->unless(Auth::user()?->can('protography'), fn ($query) => $query->whereHas('album', function ($query) {
                $query->where('published', true);
            }));
        });
    }

    public function registerMediaConversions(?Media $media = null): void
    {
        $this->addMediaConversion(PhotoEnum::LARGE->value)
            ->fit(Fit::Max, 1920, 1920)
            ->format('webp');

        $this->addMediaConversion(PhotoEnum::MEDIUM->value)
            ->fit(Fit::Max, 750, 750)
            ->format('webp');

        $this->addMediaConversion(PhotoEnum::SMALL->value)
            ->nonQueued()
            ->fit(Fit::Max, 420, 420)
            ->format('webp');

        $this->addMediaConversion(PhotoEnum::TINY->value)
            ->fit(Fit::Max, 50, 50)
            ->format('webp');
    }

    /**
     * @return BelongsTo<PhotoAlbum, $this>
     */
    public function album(): BelongsTo
    {
        return $this->belongsTo(PhotoAlbum::class, 'album_id');
    }

    /**
     * @return HasMany<PhotoLikes, $this>
     */
    public function likes(): HasMany
    {
        return $this->hasMany(PhotoLikes::class);
    }

    /**
     * @return HasOne<StorageEntry, $this>
     */
    public function file(): HasOne
    {
        return $this->hasOne(StorageEntry::class, 'id', 'file_id');
    }

    private function getAdjacentPhoto(bool $next = true): ?Photo
    {
        if ($next) {
            $ord = 'DESC';
            $comp = '<';
        } else {
            $ord = 'ASC';
            $comp = '>';
        }

        return self::query()->where(function ($query) use ($comp) {
            $query->where('date_taken', $comp, $this->date_taken)
                ->orWhere(function ($query) use ($comp) {
                    $query->where('date_taken', '=', $this->date_taken)
                        ->where('id', $comp, $this->id);
                });
        })
            ->where('album_id', $this->album_id)
            ->orderBy('date_taken', $ord)
            ->orderBy('id', $ord)
            ->first();
    }

    public function getNextPhoto(): ?Photo
    {
        return $this->getAdjacentPhoto();
    }

    public function getPreviousPhoto(): ?Photo
    {
        return $this->getAdjacentPhoto(false);
    }

    public function getAlbumPageNumber(int $paginateLimit): float|int
    {
        $photoIndex = 1;
        $photos = self::query()->where('album_id', $this->album_id)
            ->orderBy('date_taken', 'desc')->orderBy('id', 'desc')
            ->get();
        foreach ($photos as $photoItem) {
            if ($this->id == $photoItem->id) {
                return ceil($photoIndex / $paginateLimit);
            }

            $photoIndex++;
        }

        return 1;
    }

    public function thumbnail(): string
    {
        return $this->getFirstMediaUrl(conversionName: PhotoEnum::MEDIUM->value);
    }

    /**
     * @return Attribute<string, never>
     */
    protected function url(): Attribute
    {
        return Attribute::make(get: fn (): string => $this->getFirstMediaUrl(conversionName: PhotoEnum::LARGE->value));
    }

    #[Override]
    protected static function boot(): void
    {
        parent::boot();

        static::deleting(static function ($photo) {
            /* @var Photo $photo */
            $photo->file?->delete();
            if ($photo->id == $photo->album->thumb_id) {
                $album = $photo->album;
                $album->thumb_id = null;
                $album->save();
            }
        });
    }

    protected function casts(): array
    {
        return [
            'private' => 'boolean',
        ];
    }
}
