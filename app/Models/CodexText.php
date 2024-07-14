<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class CodexText extends Model
{
    use HasFactory;

    protected $table = 'codex_texts';

    public function type(): BelongsTo
    {
        return $this->belongsTo(CodexTextType::class, 'type_id');
    }

    public function codices(): BelongsToMany
    {
        return $this->belongsToMany(Codex::class, 'codex_codex_text', 'text_id', 'codex');
    }

    protected static function booted()
    {
        static::deleting(static function ($text) {
            $text->codices()->detach();
            $text->type()->dissociate();
        });
    }
}
