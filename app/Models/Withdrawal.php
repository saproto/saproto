<?php

namespace Proto\Models;

use Illuminate\Database\Eloquent\Model;

use DB;

class Withdrawal extends Model
{

    protected $table = 'withdrawals';
    protected $guarded = ['id'];

    public function orderlines()
    {
        return $this->hasMany('Proto\Models\OrderLine', 'payed_with_withdrawal');
    }

    public function totalsPerUser()
    {
        $data = DB::table('orderlines')
            ->select(DB::raw('user_id, count(id) as orderline_count, sum(total_price) as total_price'))
            ->where('payed_with_withdrawal', $this->id)
            ->groupBy('user_id')
            ->get();

        $response = [];

        foreach ($data as $entry) {
            $response[$entry->user_id] = (object)[
                'user' => User::withTrashed()->findOrFail($entry->user_id),
                'count' => $entry->orderline_count,
                'sum' => $entry->total_price
            ];
        }

        return $response;
    }

    public function orderlinesForUser(User $user)
    {
        return OrderLine::where('user_id', $user->id)->where('payed_with_withdrawal', $this->id)->get();
    }

    public function totalForUser(User $user)
    {
        return OrderLine::where('user_id', $user->id)->where('payed_with_withdrawal', $this->id)->sum('total_price');
    }

    public function getFailedWithdrawal(User $user)
    {
        return FailedWithdrawal::where('user_id', $user->id)->where('withdrawal_id', $this->id)->first();
    }

    public function userCount()
    {
        $data = DB::table('orderlines')
            ->select('user_id')
            ->where('payed_with_withdrawal', $this->id)
            ->groupBy('user_id')
            ->get();
        return count($data);
    }

    public function users()
    {
        $users = array_unique(OrderLine::where('payed_with_withdrawal', $this->id)->get()->pluck('user_id')->toArray());
        return User::withTrashed()->whereIn('id', $users)->orderBy('id', 'asc')->get();
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
