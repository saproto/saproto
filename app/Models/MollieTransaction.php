<?php

namespace Proto\Models;

use Illuminate\Database\Eloquent\Model;

use Mollie;
use Proto\Http\Controllers\MollieController;

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

    public function translatedStatus()
    {
        return MollieTransaction::translateStatus($this->status);
    }

    public function updateFromWebhook()
    {

        $mollie = Mollie::api()->payments()->get($this->mollie_id);

        $oldstatus = $this->status;
        $newstatus = MollieTransaction::translateStatus($mollie->status);

        $this->status = $mollie->status;
        $this->payment_url = $mollie->getPaymentUrl();

        $this->save();

        if ($newstatus == "failed") {
            foreach ($this->orderlines as $orderline) {

                if ($orderline->product_id == config('omnomcom.mollie')['fee_id']) {
                    $orderline->delete();
                    continue;
                }

                /**
                 * Handles the case where an orderline was an unpaid event ticket for which prepayment is required.
                 * If statement components:
                 * - The orderline should refer to a product which is a ticket.
                 * - The ticket should be a pre-paid ticket.
                 * - The ticket should not already been paid for. This would indicate someone charging back their payment. If this is the case someone should still pay.
                 */
                if ($orderline->product->ticket && $orderline->product->ticket->is_prepaid && $orderline->ticketPurchase->payment_complete == false) {
                    if ($orderline->ticketPurchase) {
                        $orderline->ticketPurchase->delete();
                    }
                    $orderline->product->stock += 1;
                    $orderline->product->save();
                    $orderline->delete();
                    continue;
                }

                $orderline->payed_with_mollie = null;
                $orderline->save();

            }
        }

        if ($newstatus == "paid") {
            foreach ($this->orderlines as $orderline) {
                if ($orderline->ticketPurchase && $orderline->ticketPurchase->payment_complete == false) {
                    $orderline->ticketPurchase->payment_complete = true;
                    $orderline->ticketPurchase->save();
                }
            }
        }

        return $this;

    }
}
