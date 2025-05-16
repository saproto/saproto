<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * App\Models\StockMutation.
 *
 * @property int $id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property int $user_id
 * @property int $product_id
 * @property int $before
 * @property int $after
 * @property int $is_bulk
 * @property-read Product|null $product
 * @property-read User|null $user
 *
 * @method static Builder|StockMutation newModelQuery()
 * @method static Builder|StockMutation newQuery()
 * @method static Builder|StockMutation query()
 * @method static Builder|StockMutation whereAfter($value)
 * @method static Builder|StockMutation whereBefore($value)
 * @method static Builder|StockMutation whereCreatedAt($value)
 * @method static Builder|StockMutation whereId($value)
 * @method static Builder|StockMutation whereIsBulk($value)
 * @method static Builder|StockMutation whereProductId($value)
 * @method static Builder|StockMutation whereUpdatedAt($value)
 * @method static Builder|StockMutation whereUserId($value)
 *
 * @mixin \Eloquent
 */
class StockMutation extends Model
{
    protected $table = 'stock_mutations';

    protected $fillable = ['before', 'after', 'is_bulk'];

    /**
     * @return BelongsTo<Product, $this>
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * @return BelongsTo<User, $this>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function date(): string
    {
        return $this->created_at->toDateString();
    }

    public function delta(): int
    {
        return $this->after - $this->before;
    }
}
