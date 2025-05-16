<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * UNUSED, when implemented in the new protube we want to preserve this data so for now left unused*/
/**
 * Soundboard Sound Model.
 *
 * @property int $id
 * @property int $file_id
 * @property bool $hidden
 * @property string $name
 * @property-read StorageEntry|null $file
 *
 * @method static Builder<static>|SoundboardSound newModelQuery()
 * @method static Builder<static>|SoundboardSound newQuery()
 * @method static Builder<static>|SoundboardSound query()
 * @method static Builder<static>|SoundboardSound whereFileId($value)
 * @method static Builder<static>|SoundboardSound whereHidden($value)
 * @method static Builder<static>|SoundboardSound whereId($value)
 * @method static Builder<static>|SoundboardSound whereName($value)
 *
 * @mixin \Eloquent
 */
class SoundboardSound extends Model
{
    protected $table = 'soundboard_sounds';

    protected $guarded = ['id'];

    public $timestamps = false;

    /**
     * @return BelongsTo<StorageEntry, $this> */
    public function file(): BelongsTo
    {
        return $this->belongsTo(StorageEntry::class, 'file_id');
    }

    protected function casts(): array
    {
        return [
            'hidden' => 'boolean',
        ];
    }
}
