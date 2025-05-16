<?php

namespace App\Models;

use Database\Factories\CodexFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Carbon;

/**
 * Codex model.
 *
 * @property int $id
 * @property string $name
 * @property string $export
 * @property string $description
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 */
class Codex extends Model
{
    /** @use HasFactory<CodexFactory>*/
    use HasFactory;

    protected $table = 'codex_codices';

    /**
     * @return BelongsToMany<CodexSong, $this>
     */
    public function songs(): BelongsToMany
    {
        return $this->belongsToMany(CodexSong::class, 'codex_codex_song', 'codex', 'song');
    }

    /**
     * @return BelongsToMany<CodexText, $this>
     */
    public function texts(): BelongsToMany
    {
        return $this->belongsToMany(CodexText::class, 'codex_codex_text', 'codex', 'text_id');
    }
}
