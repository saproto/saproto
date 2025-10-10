<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

/**
 * UNUSED, when implemented in the new protube we want to preserve this data so for now left unused*/
/**
 * Soundboard Sound Model.
 *
 * @property int $id
 * @property int $file_id
 * @property bool $hidden
 * @property string $name
 *
 * @method static Builder<static>|SoundboardSound newModelQuery()
 * @method static Builder<static>|SoundboardSound newQuery()
 * @method static Builder<static>|SoundboardSound query()
 * @method static Builder<static>|SoundboardSound whereHidden($value)
 * @method static Builder<static>|SoundboardSound whereId($value)
 * @method static Builder<static>|SoundboardSound whereName($value)
 *
 * @property-read MediaCollection<int, Media> $media
 * @property-read int|null $media_count
 *
 * @mixin \Eloquent
 */
class SoundboardSound extends Model implements HasMedia
{
    protected $table = 'soundboard_sounds';

    protected $guarded = ['id'];

    public $timestamps = false;

    use InteractsWithMedia;

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('sound')
            ->useDisk('local')
            ->acceptsMimeTypes(['audio/mpeg'])
            ->singleFile();
    }

    protected function casts(): array
    {
        return [
            'hidden' => 'boolean',
        ];
    }
}
