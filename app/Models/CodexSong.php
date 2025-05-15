<?php

namespace App\Models;

use Database\Factories\CodexSongFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Override;

/**
 *Codex song model.
 *
 * @property int $id
 * @property string $artist
 * @property string $title
 * @property string $lyrics
 * @property string $youtube
 * @property int $category_id
 * @property CodexSongCategory $category
 * @property Codex[] $codices
 **/
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
    protected static function booted()
    protected static function booted(): void
    {
        static::deleting(function ($song) {
            $song->codices()->detach();
        });
    }
}
