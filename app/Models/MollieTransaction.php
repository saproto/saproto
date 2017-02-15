<?php

namespace Proto\Models;

use Illuminate\Database\Eloquent\Model;

use Mollie;

class MollieTransaction extends Model
{
    protected $table = 'mollie_transactions';
    protected $guarded = ['id'];

    public function orderlines()
    {
        return $this->hasMany('Proto\Models\OrderLine', 'payed_with_mollie');
    }

    public function user()
    {
        return $this->belongsTo('Proto\Models\User')->withTrashed();
    }

    public function transaction()
    {
        return Mollie::api()->payments()->get($this->mollie_id);
    }

    public static function translateStatus($status)
    {
        if ($status == 'open' || $status == 'pending' || $status == 'draft') {
            return "open";
        } elseif ($status == 'expired' || $status == 'cancelled' || $status == 'failed' || $status == 'charged_back' || $status == 'refunded') {
            return "failed";
        } elseif ($status == "paid" || $status == "paidout") {
            return "paid";
        } else {
            return "unknown";
        }
    }

    public function updateFromWebhook()
    {

        $mollie = Mollie::api()->payments()->get($this->mollie_id);

        $newstatus = MollieTransaction::translateStatus($mollie->status);

        $this->status = $mollie->status;
        $this->save();

        if ($newstatus == "failed") {
            foreach ($this->orderlines as $orderline) {

                if ($orderline->product_id == config('omnomcom.mollie')['fee_id']) {
                    $orderline->delete();
                    continue;
                }

                $orderline->payed_with_mollie = null;
                $orderline->save();

            }
        }

        return $this;

    }
}
