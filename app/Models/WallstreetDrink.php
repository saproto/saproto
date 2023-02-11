<?php

namespace Proto\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Collection;


/**
 * Class WallstreetDrink
 * @property integer end_time
 * @property integer start_time
 * @property string name
 * @property integer id
 * @property float minimum_price
 * @property float price_decrease
 * @property float price_increase
 **/

class WallstreetDrink extends Model
{
    use HasFactory;
    protected $table = 'wallstreet_drink';
    protected $fillable = ['end_time', 'start_time', 'name', 'minimum_price', 'price_increase', 'price_decrease'];

    public function isCurrent(): bool
    {
        return $this->start_time <= time() && $this->end_time >= time();
    }

    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'product_wallstreet_drink');
    }

    public function latestPrices()
    {
        return WallstreetPrice::query()->whereIn('product_id', $this->products()->pluck('id'))->orderBy('created_at', 'desc')->get();
    }

    public function orders(){
        return OrderLine::query()->where('created_at', '>=', Carbon::createFromTimestamp($this->start_time))->where('created_at', '<=', Carbon::createFromTimestamp($this->end_time))->get();
    }
}
