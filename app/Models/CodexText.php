<?php

namespace App\Models;

use Database\Factories\CodexTextFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Carbon;
use Override;

/**
 * Codex text model.
 *
 * @property int $id
 * @property int $type_id
 * @property string $name
 * @property string $text
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Collection<int, Codex> $codices
 * @property-read int|null $codices_count
 * @property-read CodexTextType|null $type
 *
 * @method static CodexTextFactory factory($count = null, $state = [])
 * @method static Builder<static>|CodexText newModelQuery()
 * @method static Builder<static>|CodexText newQuery()
 * @method static Builder<static>|CodexText query()
 * @method static Builder<static>|CodexText whereCreatedAt($value)
 * @method static Builder<static>|CodexText whereId($value)
 * @method static Builder<static>|CodexText whereName($value)
 * @method static Builder<static>|CodexText whereText($value)
 * @method static Builder<static>|CodexText whereTypeId($value)
 * @method static Builder<static>|CodexText whereUpdatedAt($value)
 *
 * @mixin \Eloquent
 */
class CodexText extends Model
{
    /** @use HasFactory<CodexTextFactory>*/
    use HasFactory;

    protected $table = 'codex_texts';

    /**
     * @return BelongsTo<CodexTextType, $this>
     */
    public function type(): BelongsTo
    {
        return $this->belongsTo(CodexTextType::class, 'type_id');
    }

    /**
     * @return BelongsToMany<Codex, $this>
     */
    public function codices(): BelongsToMany
    {
        return $this->belongsToMany(Codex::class, 'codex_codex_text', 'text_id', 'codex');
    }

    #[Override]
    protected static function booted(): void
    {
        static::deleting(static function ($text) {
            $text->codices()->detach();
            $text->type()->dissociate();
        });
    }
}
