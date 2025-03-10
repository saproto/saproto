<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class WallstreetPrice.
 *
 * @property int wallstreet_drink_id
 * @property int product_id
 * @property float price
 * @property float diff
 * @property WallstreetDrink drink
 * @property Product product
 * @property int id
 * @property string created_at
 * @property string updated_at
 **/
class WallstreetPrice extends Model
{
    protected $table = 'wallstreet_drink_prices';

    protected $fillable = ['wallstreet_drink_id', 'product_id', 'price', 'diff'];

    protected $with = ['drink', 'product'];

    /**
     * @return BelongsTo<WallstreetDrink, $this>
     */
    public function drink(): BelongsTo
    {
        return $this->belongsTo(WallstreetDrink::class, 'wallstreet_drink_id');
    }

    /**
     * @return BelongsTo<Product, $this>
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}
