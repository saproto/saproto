<?php

namespace Proto\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderLine extends Model
{
    use HasFactory;

    protected $table = 'orderlines';
    protected $guarded = ['id'];

    public function user()
    {
        return $this->belongsTo('Proto\Models\User')->withTrashed();
    }

    public function product()
    {
        return $this->belongsTo('Proto\Models\Product');
    }

    public function cashier()
    {
        return $this->belongsTo('Proto\Models\User')->withTrashed();
    }

    public function withdrawal()
    {
        return $this->belongsTo('Proto\Models\Withdrawal', 'payed_with_withdrawal');
    }

    public function ticketPurchase()
    {
        return $this->hasOne('Proto\Models\TicketPurchase', 'orderline_id');
    }

    public function isPayed()
    {
        return ($this->total_price == 0 || $this->payed_with_cash !== null || $this->payed_with_mollie !== null || $this->payed_with_withdrawal !== null || $this->payed_with_bank_card !== null);
    }

    public function canBeDeleted() {
        if ($this->total_price == 0) {
            return true;
        } elseif ($this->isPayed()) {
            return false;
        }
        return true;
    }

    public function molliePayment()
    {
        return $this->belongsTo('Proto\Models\MollieTransaction', 'payed_with_mollie');
    }

    public function generateHistoryStatus()
    {

        if ($this->isPayed()) {
            if ($this->payed_with_withdrawal !== null) {
                return "Withdrawal <a href='" . route('omnomcom::mywithdrawal', ['id' => $this->payed_with_withdrawal]) . "'>#" . $this->payed_with_withdrawal . "</a>";
            } elseif ($this->payed_with_cash !== null) {
                return "Cash";
            } elseif ($this->payed_with_bank_card !== null) {
                return "Bank Card";
            } elseif ($this->payed_with_mollie !== null) {
                return "Mollie <a href='" . route('omnomcom::mollie::status', ['id' => $this->payed_with_mollie]) . "'>#" . $this->payed_with_mollie . "</a>";
            } elseif ($this->total_price == 0) {
                return "Free!";
            } else {
                return "Dunnow 🤷🏽";
            }
        } else {
            return "Unpaid";
        }

    }

}
