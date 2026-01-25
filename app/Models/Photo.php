<?php

namespace App\Models;

use App\Enums\PhotoEnum;
use Database\Factories\PhotoFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Override;
use Spatie\Image\Enums\Fit;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

/**
 * Photo model.
 *
 * @property int $id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property int $album_id
 * @property int $date_taken
 * @property bool $private
 * @property-read PhotoAlbum|null $album
 * @property-read Collection<int, PhotoLikes> $likes
 * @property-read int|null $likes_count
 * @property-read bool|null $liked_by_me
 *
 * @method static PhotoFactory factory($count = null, $state = [])
 * @method static Builder<static>|Photo newModelQuery()
 * @method static Builder<static>|Photo newQuery()
 * @method static Builder<static>|Photo query()
 * @method static Builder<static>|Photo whereAlbumId($value)
 * @method static Builder<static>|Photo whereCreatedAt($value)
 * @method static Builder<static>|Photo whereDateTaken($value)
 * @method static Builder<static>|Photo whereId($value)
 * @method static Builder<static>|Photo wherePrivate($value)
 * @method static Builder<static>|Photo whereUpdatedAt($value)
 *
 * @property-read MediaCollection<int, Media> $media
 * @property-read int|null $media_count
 *
 * @mixin Model
 */
class Photo extends Model implements HasMedia
{
    /** @use HasFactory<PhotoFactory>*/
    use HasFactory;

    use InteractsWithMedia;

    protected $table = 'photos';

    protected $guarded = ['id'];

    protected $with = ['media'];

    #[Override]
    protected static function booted(): void
    {
        /** @param Builder<$this> $query */
        static::addGlobalScope('private', function (Builder $query) {
            $query->unless(Auth::user()?->is_member, fn ($query) => $query->where('private', false)
                ->whereHas('album', function (\Illuminate\Contracts\Database\Query\Builder $query) {
                    $query->where('private', false);
                }));
        });
        /** @param Builder<$this> $query */
        static::addGlobalScope('published', function (Builder $query) {
            $query->unless(Auth::user()?->can('protography'), fn ($query) => $query->whereHas('album', function (\Illuminate\Contracts\Database\Query\Builder $query) {
                $query->where('published', true);
            }));
        });
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('private')
            ->useDisk(App::environment('local') ? 'garage' : 'stack')
            ->storeConversionsOnDisk('garage')
            ->singleFile();

        $this->addMediaCollection('public')
            ->useDisk(App::environment('local') ? 'garage-public' : 'stack')
            ->storeConversionsOnDisk('garage-public')
            ->singleFile();
    }

    public function registerMediaConversions(?Media $media = null): void
    {
        $this->addMediaConversion(PhotoEnum::LARGE->value)
            ->fit(Fit::Max, 1920, 1920)
            ->format('webp');

        $this->addMediaConversion(PhotoEnum::SMALL->value)
            ->nonQueued()
            ->fit(Fit::Max, 420, 420)
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

    public function getUrl(PhotoEnum $photoEnum = PhotoEnum::ORIGINAL): string
    {
        return $this->getFirstMediaUrl($this->private ? 'private' : 'public', $photoEnum->value);
    }

    protected function casts(): array
    {
        return [
            'private' => 'boolean',
        ];
    }
}
