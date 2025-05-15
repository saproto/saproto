<?php

namespace App\Models;

use Carbon\CarbonTimeZone;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Carbon;

/**
 * Class WallstreetDrink.
 *
 * @property int $end_time
 * @property int $start_time
 * @property string $name
 * @property int $id
 * @property float $minimum_price
 * @property float $price_decrease
 * @property float $price_increase
 * @property int $random_events_chance
 **/
class WallstreetDrink extends Model
{
    protected $table = 'wallstreet_drink';

    protected $fillable = ['end_time', 'start_time', 'name', 'minimum_price', 'price_increase', 'price_decrease'];

    public function isCurrent(): bool
    {
        return $this->start_time <= Carbon::now()->getTimestamp() && $this->end_time >= Carbon::now()->getTimestamp();
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
            ->where('created_at', '>=', Carbon::createFromTimestamp($this->start_time, CarbonTimeZone::create(config('app.timezone'))))
            ->where('created_at', '<=', Carbon::createFromTimestamp($this->end_time), CarbonTimeZone::create(config('app.timezone')))
            ->whereHas('product', function ($q) use ($productIDs) {
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

    public function loss()
    public function loss(): mixed
    {
        return $this->orders()
            ->selectRaw('(original_unit_price*units)-total_price AS loss')
            ->get()
            ->sum('loss');
    }
}
