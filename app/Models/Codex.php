<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Codex extends Model
{
    use HasFactory;

    protected $table = 'codex_codices';

    public function songs(): BelongsToMany
    {
        return $this->belongsToMany(CodexSong::class, 'codex_codex_song', 'codex', 'song');
    }

    public function texts(): BelongsToMany
    {
        return $this->belongsToMany(CodexText::class, 'codex_codex_text', 'codex', 'text_id');
    }

    public function shuffles(): BelongsToMany
    {
        return $this->belongsToMany(SongCategory::class, 'codex_codexshuffle', 'codex', 'category');
    }
}
