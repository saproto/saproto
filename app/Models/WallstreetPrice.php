<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * Class WallstreetPrice.
 *
 * @property int $id
 * @property int $wallstreet_drink_id
 * @property int $product_id
 * @property float $price
 * @property float $diff
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read WallstreetDrink|null $drink
 * @property-read Product|null $product
 *
 * @method static Builder<static>|WallstreetPrice newModelQuery()
 * @method static Builder<static>|WallstreetPrice newQuery()
 * @method static Builder<static>|WallstreetPrice query()
 * @method static Builder<static>|WallstreetPrice whereCreatedAt($value)
 * @method static Builder<static>|WallstreetPrice whereDiff($value)
 * @method static Builder<static>|WallstreetPrice whereId($value)
 * @method static Builder<static>|WallstreetPrice wherePrice($value)
 * @method static Builder<static>|WallstreetPrice whereProductId($value)
 * @method static Builder<static>|WallstreetPrice whereUpdatedAt($value)
 * @method static Builder<static>|WallstreetPrice whereWallstreetDrinkId($value)
 *
 * @mixin \Eloquent
 */
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
