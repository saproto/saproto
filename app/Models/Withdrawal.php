<?php

namespace Proto\Models;

use Illuminate\Database\Eloquent\Model;

class Withdrawal extends Model
{

    protected $table = 'withdrawals';
    protected $guarded = ['id'];

    public function orderlines()
    {
        return $this->hasMany('Proto\Models\OrderLine', 'payed_with_withdrawal');
    }

    public function orderlinesForUser(User $user)
    {
        return OrderLine::where('user_id', $user->id)->where('payed_with_withdrawal', $this->id)->get();
    }

    public function totalForUser(User $user)
    {
        return OrderLine::where('user_id', $user->id)->where('payed_with_withdrawal', $this->id)->sum('total_price');
    }

    public function users()
    {
        $ids = [];
        foreach ($this->orderlines as $orderline) {
            if (!in_array($orderline->user->id, $ids)) {
                $ids[] = $orderline->user->id;
            }
        }
        return User::withTrashed()->whereIn('id', $ids)->orderBy('id', 'asc')->get();
    }

    public function total()
    {
        return OrderLine::where('payed_with_withdrawal', $this->id)->sum('total_price');
    }

    public function withdrawalId()
    {
        return 'PROTO-' . $this->id . '-' . date('dmY', strtotime($this->date));
    }

}
