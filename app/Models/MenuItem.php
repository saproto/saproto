<?php

namespace App\Models;

use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;

/**
 * Menu Item Model.
 *
 * @property int $id
 * @property MenuItem|null $parent
 * @property string $menuname
 * @property string|null $url
 * @property int|null $page_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property int $order
 * @property bool $is_member_only
 * @property-read Collection<int, MenuItem> $children
 * @property-read int|null $children_count
 * @property-read Page|null $page
 *
 * @method static Builder<static>|MenuItem newModelQuery()
 * @method static Builder<static>|MenuItem newQuery()
 * @method static Builder<static>|MenuItem query()
 * @method static Builder<static>|MenuItem whereCreatedAt($value)
 * @method static Builder<static>|MenuItem whereId($value)
 * @method static Builder<static>|MenuItem whereIsMemberOnly($value)
 * @method static Builder<static>|MenuItem whereMenuname($value)
 * @method static Builder<static>|MenuItem whereOrder($value)
 * @method static Builder<static>|MenuItem wherePageId($value)
 * @method static Builder<static>|MenuItem whereParent($value)
 * @method static Builder<static>|MenuItem whereUpdatedAt($value)
 * @method static Builder<static>|MenuItem whereUrl($value)
 *
 * @property-read mixed $parsed_url
 *
 * @mixin Model
 */
class MenuItem extends Model
{
    protected $table = 'menuitems';

    protected $guarded = ['id'];

    protected $with = ['page', 'children'];

    protected $appends = ['parsed_url'];

    /**
     * @return BelongsTo<Page, $this>
     */
    public function page(): BelongsTo
    {
        return $this->belongsTo(Page::class, 'page_id', 'id');
    }

    /**
     * @return HasMany<MenuItem, $this>
     */
    public function children(): HasMany
    {
        return $this->hasMany(MenuItem::class, 'parent');
    }

    /**
     * @return BelongsTo<MenuItem, $this>
     */
    public function parent(): BelongsTo
    {
        return $this->belongsTo(MenuItem::class, 'id', 'parent');
    }

    /**
     * @return Attribute<string, never>
     */
    protected function parsedUrl(): Attribute
    {
        return Attribute::make(get: function () {
            if (str_starts_with((string) $this->url, '(route) ')) {
                try {
                    return route(substr((string) $this->url, 8));
                } catch (Exception) {
                    return '#';
                }
            } else {
                return $this->url;
            }
        });
    }

    public function getUrl(): ?string
    {
        if (str_starts_with((string) $this->url, '(route) ')) {
            try {
                return route(substr((string) $this->url, 8));
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

    protected function casts(): array
    {
        return [
            'is_member_only' => 'boolean',
        ];
    }
}
