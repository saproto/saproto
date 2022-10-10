<?php

namespace Proto\Models;

use Carbon;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Proto\Models\EventCategory.
 *
 * @property int $id
 * @property string $name
 * @property string $icon
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Collection|Event[]|null $events
 * @method static Builder|EventCategory whereCreatedAt($value)
 * @method static Builder|EventCategory whereIcon($value)
 * @method static Builder|EventCategory whereId($value)
 * @method static Builder|EventCategory whereName($value)
 * @method static Builder|EventCategory whereUpdatedAt($value)
 * @method static Builder|EventCategory newModelQuery()
 * @method static Builder|EventCategory newQuery()
 * @method static Builder|EventCategory query()
 * @mixin Eloquent
 */
class EventCategory extends Model
{
    protected $table = 'event_categories';

    /** @return HasMany */
    public function events()
    {
        return $this->hasMany('Proto\Models\Event', 'category_id');
    }
}
