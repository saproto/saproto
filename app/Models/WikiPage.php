<?php

namespace App\Models;

use Database\Factories\WikiPageFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property string $title
 * @property string $slug
 * @property int|null $parent_id
 * @property string $full_path
 * @property string $content
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @method static WikiPageFactory factory($count = null, $state = [])
 * @method static Builder<static>|WikiPage newModelQuery()
 * @method static Builder<static>|WikiPage newQuery()
 * @method static Builder<static>|WikiPage query()
 * @method static Builder<static>|WikiPage whereContent($value)
 * @method static Builder<static>|WikiPage whereCreatedAt($value)
 * @method static Builder<static>|WikiPage whereFullPath($value)
 * @method static Builder<static>|WikiPage whereId($value)
 * @method static Builder<static>|WikiPage whereParentId($value)
 * @method static Builder<static>|WikiPage whereSlug($value)
 * @method static Builder<static>|WikiPage whereTitle($value)
 * @method static Builder<static>|WikiPage whereUpdatedAt($value)
 *
 * @mixin \Eloquent
 */
class WikiPage extends Model
{
    use HasFactory;

    /**
     * @return BelongsTo<WikiPage, $this>
     */
    public function parent(): BelongsTo
    {
        return $this->belongsTo(WikiPage::class, 'parent_id');
    }

    /**
     * @return HasMany<WikiPage, $this>
     */
    public function children(): HasMany
    {
        return $this->hasMany(WikiPage::class, 'parent_id');
    }
    public static function boot(): void
    {
        parent::boot();

        static::saving(function () {
            if ($this->parent) {
                $this->full_path = trim($this->parent->full_path . '/' . $this->slug, '/');
            } else {
                $this->full_path = $this->slug;
            }
        });
    }
}
