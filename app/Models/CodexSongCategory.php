<?php

namespace App\Models;

use Database\Factories\CodexSongCategoryFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;
use Override;

/**
 * Codex song category model.
 *
 * @property int $id
 * @property string $name
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Collection<int, CodexSong> $songs
 * @property-read int|null $songs_count
 *
 * @method static CodexSongCategoryFactory factory($count = null, $state = [])
 * @method static Builder<static>|CodexSongCategory newModelQuery()
 * @method static Builder<static>|CodexSongCategory newQuery()
 * @method static Builder<static>|CodexSongCategory query()
 * @method static Builder<static>|CodexSongCategory whereCreatedAt($value)
 * @method static Builder<static>|CodexSongCategory whereId($value)
 * @method static Builder<static>|CodexSongCategory whereName($value)
 * @method static Builder<static>|CodexSongCategory whereUpdatedAt($value)
 *
 * @mixin \Eloquent
 */
class CodexSongCategory extends Model
{
    /** @use HasFactory<CodexSongCategoryFactory>*/
    use HasFactory;

    protected $table = 'codex_category';

    /**
     * @return HasMany<CodexSong, $this>
     */
    public function songs(): HasMany
    {
        return $this->hasMany(CodexSong::class, 'category_id');
    }

    #[Override]
    protected static function booted()
    {
        static::deleting(static function ($category) {
            $category->songs()->delete();
        });
    }
}
