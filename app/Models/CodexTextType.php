<?php

namespace App\Models;

use Database\Factories\CodexTextTypeFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;
use Override;

/**
 * Codex text type model.
 *
 * @property int $id
 * @property string $type
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Collection<int, CodexText> $texts
 * @property-read int|null $texts_count
 *
 * @method static CodexTextTypeFactory factory($count = null, $state = [])
 * @method static Builder<static>|CodexTextType newModelQuery()
 * @method static Builder<static>|CodexTextType newQuery()
 * @method static Builder<static>|CodexTextType query()
 * @method static Builder<static>|CodexTextType whereCreatedAt($value)
 * @method static Builder<static>|CodexTextType whereId($value)
 * @method static Builder<static>|CodexTextType whereType($value)
 * @method static Builder<static>|CodexTextType whereUpdatedAt($value)
 *
 * @mixin \Eloquent
 */
class CodexTextType extends Model
{
    /** @use HasFactory<CodexTextTypeFactory>*/
    use HasFactory;

    protected $table = 'codex_text_types';

    /**
     * @return HasMany<CodexText, $this>
     */
    public function texts(): HasMany
    {
        return $this->hasMany(CodexText::class, 'type_id');
    }

    #[Override]
    protected static function booted()
    {
        static::deleting(static function ($type) {
            $type->texts()->delete();
        });
    }
}
