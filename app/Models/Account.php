<?php

namespace App\Models;

use Carbon;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
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
 * @property-read Collection|Product[] $products
 *
 * @method static Builder|Account whereAccountNumber($value)
 * @method static Builder|Account whereCreatedAt($value)
 * @method static Builder|Account whereId($value)
 * @method static Builder|Account whereName($value)
 * @method static Builder|Account whereUpdatedAt($value)
 * @method static Builder|Account newModelQuery()
 * @method static Builder|Account newQuery()
 * @method static Builder|Account query()
 *
 * @mixin Eloquent
 */
class Account extends Model
{
    protected $table = 'accounts';

    protected $guarded = ['id'];

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }

    /**
     * @return array<int, stdClass>
     */
    public static function generateAccountOverviewFromOrderlines(Collection $orderlines): array
    {
        $accounts = [];

        foreach ($orderlines as $orderline) {
            // We sort by date, where a date goes from 6am - 6am.
            $sortDate = Carbon::createFromFormat('Y-m-d H:i:s', $orderline->created_at)->subHours(6)->toDateString();

            // Abbreviate variable names.
            $account_nr = $orderline->account_number;

            // Add account to dataset if not existing yet.
            if (! isset($accounts[$account_nr])) {
                $accounts[$account_nr] = (object) [
                    'byDate' => [],
                    'name' => $orderline->name,
                    'total' => 0,
                ];
            }

            // Add orderline to total account price.
            $accounts[$account_nr]->total += $orderline->total_price;

            // Add date to account data if not existing yet.
            if (! isset($accounts[$account_nr]->byDate[$sortDate])) {
                $accounts[$account_nr]->byDate[$sortDate] = 0;
            }

            // Add orderline to account-on-date total.
            $accounts[$account_nr]->byDate[$sortDate] += $orderline->total_price;
        }

        ksort($accounts);

        return $accounts;
    }

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
            ->where('orderlines.created_at', '>=', Carbon::parse(strval($start))->format('Y-m-d H:i:s'))
            ->where('orderlines.created_at', '<', Carbon::parse(strval($end))->format('Y-m-d H:i:s'))
            ->get();
    }
}
