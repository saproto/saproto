<?php

namespace Proto\Models;

use Carbon;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Proto\Models\MenuItem.
 *
 * @property int $id
 * @property int|null $parent
 * @property string $menuname
 * @property string|null $url
 * @property int|null $page_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property int $order
 * @property int $is_member_only
 * @property-read Collection|MenuItem[] $children
 * @property-read Page|null $page
 * @method static Builder|MenuItem whereCreatedAt($value)
 * @method static Builder|MenuItem whereId($value)
 * @method static Builder|MenuItem whereIsMemberOnly($value)
 * @method static Builder|MenuItem whereMenuname($value)
 * @method static Builder|MenuItem whereOrder($value)
 * @method static Builder|MenuItem wherePageId($value)
 * @method static Builder|MenuItem whereParent($value)
 * @method static Builder|MenuItem whereUpdatedAt($value)
 * @method static Builder|MenuItem whereUrl($value)
 * @mixin \Eloquent
 */
class MenuItem extends Model
{
    protected $table = 'menuitems';

    protected $guarded = ['id'];

    /** @return BelongsTo|Page */
    public function page()
    {
        return $this->belongsTo('Proto\Models\Page', 'page_id', 'id');
    }

    /** @return HasMany|MenuItem */
    public function children()
    {
        return $this->hasMany('Proto\Models\MenuItem', 'parent');
    }

    /** @return string|null */
    public function getUrl()
    {
        if (substr($this->url, 0, 8) == '(route) ') {
            try {
                return route(substr($this->url, 8));
            } catch (Exception $e) {
                return '#';
            }
        } elseif ($this->page_id == null) {
            return $this->url;
        } else {
            $page = Page::find($this->page_id);
            if ($page) {
                return $page->getUrl();
            }
            return '#';
        }
    }

    /** @return bool */
    public function isFirst()
    {
        $lowest = self::where('parent', '=', $this->parent)->orderBy('order')->first();
        return $this->id == $lowest->id;
    }

    /** @return bool */
    public function isLast()
    {
        $highest = self::where('parent', '=', $this->parent)->orderBy('order', 'desc')->first();
        return $this->id == $highest->id;
    }
}
