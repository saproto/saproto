<?php

namespace App\Models;

use Database\Factories\CodexSongFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Carbon;
use Override;

/**
 * Codex song model.
 *
 * @property int $id
 * @property int $category_id
 * @property string $title
 * @property string|null $artist
 * @property string $lyrics
 * @property string|null $youtube
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read CodexSongCategory|null $category
 * @property-read Collection<int, Codex> $codices
 * @property-read int|null $codices_count
 *
 * @method static CodexSongFactory factory($count = null, $state = [])
 * @method static Builder<static>|CodexSong newModelQuery()
 * @method static Builder<static>|CodexSong newQuery()
 * @method static Builder<static>|CodexSong query()
 * @method static Builder<static>|CodexSong whereArtist($value)
 * @method static Builder<static>|CodexSong whereCategoryId($value)
 * @method static Builder<static>|CodexSong whereCreatedAt($value)
 * @method static Builder<static>|CodexSong whereId($value)
 * @method static Builder<static>|CodexSong whereLyrics($value)
 * @method static Builder<static>|CodexSong whereTitle($value)
 * @method static Builder<static>|CodexSong whereUpdatedAt($value)
 * @method static Builder<static>|CodexSong whereYoutube($value)
 *
 * @mixin \Eloquent
 */
class CodexSong extends Model
{
    /** @use HasFactory<CodexSongFactory>*/
    use HasFactory;

    protected $table = 'codex_songs';

    // belongs to one category on category_id in codex_songs
    /**
     * @return BelongsTo<CodexSongCategory, $this>
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(CodexSongCategory::class, 'category_id');
    }

    /**
     * @return BelongsToMany<Codex, $this>
     */
    public function codices(): BelongsToMany
    {
        return $this->belongsToMany(Codex::class, 'codex_codex_song', 'song', 'codex');
    }

    #[Override]
    protected static function booted(): void
    {
        static::deleting(function ($song) {
            $song->codices()->detach();
        });
    }
}
