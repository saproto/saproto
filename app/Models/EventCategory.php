<?php

namespace App\Models;

use Database\Factories\EventCategoryFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;

/**
 * \App\Models\EventCategory.
 *
 * @property int $id
 * @property string $name
 * @property string $icon
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Collection<int, Event> $events
 * @property-read int|null $events_count
 *
 * @method static EventCategoryFactory factory($count = null, $state = [])
 * @method static Builder<static>|EventCategory newModelQuery()
 * @method static Builder<static>|EventCategory newQuery()
 * @method static Builder<static>|EventCategory query()
 * @method static Builder<static>|EventCategory whereCreatedAt($value)
 * @method static Builder<static>|EventCategory whereIcon($value)
 * @method static Builder<static>|EventCategory whereId($value)
 * @method static Builder<static>|EventCategory whereName($value)
 * @method static Builder<static>|EventCategory whereUpdatedAt($value)
 *
 * @mixin Model
 */
class EventCategory extends Model
{
    /** @use HasFactory<EventCategoryFactory>*/
    use HasFactory;

    protected $table = 'event_categories';

    protected $fillable = ['name', 'icon'];

    /**
     * @return HasMany<Event, $this>
     */
    public function events(): HasMany
    {
        return $this->hasMany(Event::class, 'category_id');
    }

    public function average_cost(): float
    {
        return Activity::query()->whereHas('event', function ($q) {
            $q->where('category_id', $this->id);
        })->average('price') ?? 0;
    }
}
