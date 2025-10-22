<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Date;

/**
 * Class WallstreetDrink.
 *
 * @property int $id
 * @property int $end_time
 * @property int $start_time
 * @property float $price_increase
 * @property float $price_decrease
 * @property float $minimum_price
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property int $random_events_chance
 * @property-read Collection<int, WallstreetEvent> $events
 * @property-read int|null $events_count
 * @property-read Collection<int, Product> $products
 * @property-read int|null $products_count
 *
 * @method static Builder<static>|WallstreetDrink newModelQuery()
 * @method static Builder<static>|WallstreetDrink newQuery()
 * @method static Builder<static>|WallstreetDrink query()
 * @method static Builder<static>|WallstreetDrink whereCreatedAt($value)
 * @method static Builder<static>|WallstreetDrink whereEndTime($value)
 * @method static Builder<static>|WallstreetDrink whereId($value)
 * @method static Builder<static>|WallstreetDrink whereMinimumPrice($value)
 * @method static Builder<static>|WallstreetDrink wherePriceDecrease($value)
 * @method static Builder<static>|WallstreetDrink wherePriceIncrease($value)
 * @method static Builder<static>|WallstreetDrink whereRandomEventsChance($value)
 * @method static Builder<static>|WallstreetDrink whereStartTime($value)
 * @method static Builder<static>|WallstreetDrink whereUpdatedAt($value)
 *
 * @mixin \Eloquent
 */
class WallstreetDrink extends Model
{
    protected $table = 'wallstreet_drink';

    protected $fillable = ['end_time', 'start_time', 'name', 'minimum_price', 'price_increase', 'price_decrease'];

    public function isCurrent(): bool
    {
        return $this->start_time <= Date::now()->timestamp && $this->end_time >= Date::now()->timestamp;
    }

    /**
     * @return BelongsToMany<Product, $this>
     */
    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'product_wallstreet_drink');
    }

    /**
     * @return Builder<OrderLine>
     */
    public function orders(): Builder
    {
        $productIDs = $this->products()->pluck('id');

        return OrderLine::query()
            ->where('created_at', '>=', Date::createFromTimestamp($this->start_time, date_default_timezone_get()))
            ->where('created_at', '<=', Date::createFromTimestamp($this->end_time, date_default_timezone_get()))
            ->whereHas('product', function (\Illuminate\Contracts\Database\Query\Builder $q) use ($productIDs) {
                $q->whereIn('id', $productIDs);
            });
    }

    /**
     * @return BelongsToMany<WallstreetEvent, $this>
     */
    public function events(): BelongsToMany
    {
        return $this->belongsToMany(WallstreetEvent::class, 'wallstreet_drink_event', 'wallstreet_drink_id', 'wallstreet_drink_events_id')->withPivot('id')->withTimestamps();
    }

    public function loss(): mixed
    {
        return $this->orders()
            ->selectRaw('(original_unit_price*units)-total_price AS loss')
            ->get()
            ->sum('loss');
    }
}
