<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use stdClass;

/**
 * Account Model.
 *
 * @property int $id
 * @property int $account_number
 * @property string $name
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, Product> $products
 * @property-read int|null $products_count
 *
 * @method static Builder<static>|Account newModelQuery()
 * @method static Builder<static>|Account newQuery()
 * @method static Builder<static>|Account query()
 * @method static Builder<static>|Account whereAccountNumber($value)
 * @method static Builder<static>|Account whereCreatedAt($value)
 * @method static Builder<static>|Account whereId($value)
 * @method static Builder<static>|Account whereName($value)
 * @method static Builder<static>|Account whereUpdatedAt($value)
 *
 * @mixin \Eloquent
 */
class Account extends Model
{
    use HasFactory;

    protected $table = 'accounts';

    protected $guarded = ['id'];

    /**
     * @return HasMany<Product, $this>
     */
    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }

    /**
     * @return Collection<int, stdClass>
     */
    public function generatePeriodAggregation(int $start, int $end): Collection
    {
        return DB::table('orderlines')
            ->join('products', 'orderlines.product_id', '=', 'products.id')
            ->join('accounts', 'products.account_id', '=', 'accounts.id')
            ->select(
                'orderlines.product_id',
                'products.name',
                DB::raw('SUM(orderlines.units) as number_sold'),
                DB::raw('SUM(orderlines.total_price) as total_turnover')
            )
            ->groupby('orderlines.product_id')
            ->where('accounts.id', '=', $this->id)
            ->where('orderlines.created_at', '>=', Carbon::parse(strval($start))->toDateTimeString())
            ->where('orderlines.created_at', '<', Carbon::parse(strval($end))->toDateTimeString())
            ->get();
    }
}
