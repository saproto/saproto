<?php

namespace App\Models;

use Carbon;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

/**
 * Withdrawal Model.
 *
 * @property int $id
 * @property string $date
 * @property bool $closed
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Collection|Orderline[] $orderlines
 *
 * @method static Builder|Withdrawal whereClosed($value)
 * @method static Builder|Withdrawal whereCreatedAt($value)
 * @method static Builder|Withdrawal whereDate($value)
 * @method static Builder|Withdrawal whereId($value)
 * @method static Builder|Withdrawal whereUpdatedAt($value)
 * @method static Builder|Withdrawal newModelQuery()
 * @method static Builder|Withdrawal newQuery()
 * @method static Builder|Withdrawal query()
 *
 * @mixin Eloquent
 */
class Withdrawal extends Model
{
    protected $table = 'withdrawals';

    protected $guarded = ['id'];

    /** @return HasMany */
    public function orderlines()
    {
        return $this->hasMany(OrderLine::class, 'payed_with_withdrawal');
    }

    public function totalsPerUser(): array
    {
        $data = DB::table('orderlines')
            ->select(DB::raw('user_id, count(id) as orderline_count, sum(total_price) as total_price'))
            ->where('payed_with_withdrawal', $this->id)
            ->groupBy('user_id')
            ->get();

        $response = [];

        foreach ($data as $entry) {
            $response[$entry->user_id] = (object) [
                'user' => User::withTrashed()->findOrFail($entry->user_id),
                'count' => $entry->orderline_count,
                'sum' => $entry->total_price,
            ];
        }

        return $response;
    }

    /**
     * @param  User  $user
     * @return Collection|OrderLine[]
     */
    public function orderlinesForUser($user)
    {
        return OrderLine::query()->where('user_id', $user->id)->where('payed_with_withdrawal', $this->id)->get();
    }

    /**
     * @param  User  $user
     * @return int
     */
    public function totalForUser($user): mixed
    {
        return OrderLine::query()->where('user_id', $user->id)->where('payed_with_withdrawal', $this->id)->sum('total_price');
    }

    /**
     * @param  User  $user
     * @return FailedWithdrawal
     */
    public function getFailedWithdrawal($user)
    {
        return FailedWithdrawal::query()->where('user_id', $user->id)->where('withdrawal_id', $this->id)->first();
    }

    public function userCount(): int
    {
        $data = DB::table('orderlines')
            ->select('user_id')
            ->where('payed_with_withdrawal', $this->id)
            ->groupBy('user_id')
            ->get();

        return count($data);
    }

    /** @return Collection|User[] */
    public function users()
    {
        $users = array_unique(OrderLine::query()->where('payed_with_withdrawal', $this->id)->get()->pluck('user_id')->toArray());

        return User::withTrashed()->whereIn('id', $users)->orderBy('id', 'asc')->get();
    }

    /** @return int */
    public function total(): mixed
    {
        return OrderLine::query()->where('payed_with_withdrawal', $this->id)->sum('total_price');
    }

    public function withdrawalId(): string
    {
        return 'PROTO-'.$this->id.'-'.date('dmY', strtotime($this->date));
    }
}
