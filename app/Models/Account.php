<?php

namespace Proto\Models;

use Illuminate\Database\Eloquent\Model;

use Carbon;

class Account extends Model
{

    protected $table = 'accounts';
    protected $guarded = [/*'id'*/];

    public function products()
    {
        return $this->hasMany('Proto\Models\Product');
    }

    public static function generateAccountOverviewFromOrderliens($orderlines)
    {

        $accounts = [];

        foreach ($orderlines as $orderline) {
            // We sort by date, where a date goes from 6am - 6am.
            $sortDate = Carbon::parse($orderline->created_at)->subHours(6)->toDateString();

            // Shorthand variable names.
            $accnr = $orderline->account_number;

            // Add account to dataset if not existing yet.
            if (!isset($accounts[$accnr])) {
                $accounts[$accnr] = (object)[
                    'byDate' => [],
                    'name' => $orderline->name,
                    'total' => 0
                ];
            }

            // Add orderline to total account price.
            $accounts[$accnr]->total += $orderline->total_price;

            // Add date to account data if not existing yet.
            if (!isset($accounts[$accnr]->byDate[$sortDate])) {
                $accounts[$accnr]->byDate[$sortDate] = 0;
            }

            // Add orderline to account-on-date total.
            $accounts[$accnr]->byDate[$sortDate] += $orderline->total_price;
        }

        ksort($accounts);

        return $accounts;

    }

}
