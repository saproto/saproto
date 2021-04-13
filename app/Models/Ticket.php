<?php

namespace Proto\Models;

use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    protected $table = 'tickets';
    public $timestamps = false;

    protected $guarded = [];

    public function purchases()
    {
        return $this->hasMany('Proto\Models\TicketPurchase', 'ticket_id');
    }

    public function product()
    {
        return $this->belongsTo('Proto\Models\Product', 'product_id');
    }

    public function event()
    {
        return $this->belongsTo('Proto\Models\Event', 'event_id');
    }

    public function getUsers()
    {
        $uids = TicketPurchase::where('ticket_id', $this->id)->get()->pluck('user_id')->toArray();

        return User::whereIn('id', array_unique($uids))->get();
    }

    public function totalAvailable()
    {
        return $this->sold() + $this->product->stock;
    }

    public function sold()
    {
        return $this->purchases->count();
    }

    public function canBeSoldTo(User $user)
    {
        return $user->is_member || !$this->members_only;
    }

    public function isOnSale()
    {
        return date('U') > $this->available_from && date('U') < $this->available_to;
    }

    public function isAvailable(User $user)
    {
        return $this->isOnSale() && $this->canBeSoldTo($user) && $this->product->stock > 0;
    }

    public function turnover()
    {
        $total = 0;
        foreach ($this->purchases as $purchase) {
            $total += $purchase->orderline->total_price;
        }

        return $total;
    }
}
