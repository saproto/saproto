<?php

namespace Proto\Models;

use Illuminate\Database\Eloquent\Model;

class TicketPurchase extends Model
{

    protected $table = 'ticket_purchases';

    protected $guarded = ['id'];

    public function ticket()
    {
        return $this->belongsTo('Proto\Models\Ticket', 'ticket_id');
    }

    public function orderline()
    {
        return $this->belongsTo('Proto\Models\OrderLine', 'orderline_id');
    }

    public function user()
    {
        return $this->belongsTo('Proto\Models\User', 'user_id')->withTrashed();
    }

    public function canBeDownloaded()
    {
        if (!$this->ticket->is_prepaid) {
            return true;
        } elseif ($this->orderline->isPayed() && $this->orderline->payed_with_mollie === null) {
            return true;
        } elseif ($this->orderline->molliePayment && $this->orderline->molliePayment->translatedStatus() == 'paid') {
            return true;
        }
        return false;
    }

}
