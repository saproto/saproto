<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class SongCategory extends Model
{
    use HasFactory;

    protected $table = 'codex_category';

    public function songs(): BelongsToMany
    {
        return $this->belongsToMany(CodexSong::class, 'codex_category_song', 'category', 'song');
    }

    protected static function booted()
    {
        static::deleting(static function ($category) {
            $category->songs()->delete();
        });
    }
}
