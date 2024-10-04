<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class CodexSong extends Model
{
    use HasFactory;

    protected $table = 'codex_songs';

    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(SongCategory::class, 'codex_category_song', 'song', 'category');
    }

    public function codices(): BelongsToMany
    {
        return $this->belongsToMany(Codex::class, 'codex_codex_song', 'song', 'codex');
    }

    protected static function booted()
    {
        static::deleting(static function ($song) {
            $song->categories()->detach();
            $song->codices()->detach();
        });
    }
}
