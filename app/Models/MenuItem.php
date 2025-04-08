<?php

namespace App\Models;

use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;

/**
 * Menu Item Model.
 *
 * @property int $id
 * @property int|null $parent
 * @property string $menuname
 * @property string|null $url
 * @property int|null $page_id
 * @property int $order
 * @property bool $is_member_only
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Page|null $page
 * @property-read Collection|MenuItem[] $children
 *
 * @method static Builder|MenuItem whereCreatedAt($value)
 * @method static Builder|MenuItem whereId($value)
 * @method static Builder|MenuItem whereIsMemberOnly($value)
 * @method static Builder|MenuItem whereMenuname($value)
 * @method static Builder|MenuItem whereOrder($value)
 * @method static Builder|MenuItem wherePageId($value)
 * @method static Builder|MenuItem whereParent($value)
 * @method static Builder|MenuItem whereUpdatedAt($value)
 * @method static Builder|MenuItem whereUrl($value)
 * @method static Builder|MenuItem newModelQuery()
 * @method static Builder|MenuItem newQuery()
 * @method static Builder|MenuItem query()
 *
 * @mixin Model
 */
class MenuItem extends Model
{
    protected $table = 'menuitems';

    protected $guarded = ['id'];

    /**
     * @return BelongsTo<Page, $this>
     */
    public function page(): BelongsTo
    {
        return $this->belongsTo(Page::class, 'page_id', 'id');
    }

    /**
     * @return HasMany<\App\Models\MenuItem, $this>
     */
    public function children(): HasMany
    {
        return $this->hasMany(MenuItem::class, 'parent');
    }

    /**
     * @return BelongsTo<\App\Models\MenuItem, $this>
     */
    public function parent(): BelongsTo
    {
        return $this->belongsTo(MenuItem::class, 'id', 'parent');
    }

    public function getUrl(): ?string
    {
        if (str_starts_with($this->url, '(route) ')) {
            try {
                return route(substr($this->url, 8));
            } catch (Exception) {
                return '#';
            }
        } else {
            return $this->url;
        }
    }

    public function isFirst(): bool
    {
        $lowest = self::query()->where('parent', '=', $this->parent)->orderBy('order')->first();

        return $this->id == $lowest->id;
    }

    public function isLast(): bool
    {
        $highest = self::query()->where('parent', '=', $this->parent)->orderBy('order', 'desc')->first();

        return $this->id == $highest->id;
    }
}
