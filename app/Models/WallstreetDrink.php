<?php

namespace Proto\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


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

    //todo update to a many to many relationship
    public function products(){
        return Product::where('does_wallstreet', true)->get();
    }

    public function latestPrices(){
        $latestPrices = WallstreetPrice::query()->whereIn('product_id', $this->products()->pluck('id'))->orderBy('created_at', 'desc')->get();
        return $latestPrices;
    }

    public function orders(){
        return OrderLine::query()->where('created_at', '>=', Carbon::createFromTimestamp($this->start_time))->where('created_at', '<=', Carbon::createFromTimestamp($this->end_time))->get();
    }
}
