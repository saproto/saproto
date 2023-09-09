<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CodexText extends Model
{
    use HasFactory;

    protected $table = 'codex_texts';

    public function type(): BelongsTo
    {
        return $this->belongsTo(CodexTextType::class, 'type_id');
    }
}
