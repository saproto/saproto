<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Support\Carbon;
use Override;

/**
 * Withdrawal Model.
 *
 * @property int $id
 * @property string $date
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property bool $closed
 * @property int $total_users_associated
 * @property int $total_orderlines_associated
 * @property string $sum_associated_orderlines
 * @property-read Collection<int, FailedWithdrawal> $failedWithdrawals
 * @property-read int|null $failed_withdrawals_count
 * @property-read Collection<int, OrderLine> $orderlines
 * @property-read int|null $orderlines_count
 * @property-read Collection<int, User> $users
 * @property-read int|null $users_count
 * @property-read string $withdrawal_id
 *
 * @method static Builder<static>|Withdrawal newModelQuery()
 * @method static Builder<static>|Withdrawal newQuery()
 * @method static Builder<static>|Withdrawal query()
 * @method static Builder<static>|Withdrawal whereClosed($value)
 * @method static Builder<static>|Withdrawal whereCreatedAt($value)
 * @method static Builder<static>|Withdrawal whereDate($value)
 * @method static Builder<static>|Withdrawal whereId($value)
 * @method static Builder<static>|Withdrawal whereSumAssociatedOrderlines($value)
 * @method static Builder<static>|Withdrawal whereTotalOrderlinesAssociated($value)
 * @method static Builder<static>|Withdrawal whereTotalUsersAssociated($value)
 * @method static Builder<static>|Withdrawal whereUpdatedAt($value)
 *
 * @mixin \Eloquent
 */
class Withdrawal extends Model
{
    protected $table = 'withdrawals';

    protected $guarded = ['id'];

    protected $appends = ['withdrawal_id'];

    #[Override]
    protected function casts(): array
    {
        return [
            'closed' => 'boolean',
        ];
    }

    /**
     * @return HasMany<OrderLine, $this>
     */
    public function orderlines(): HasMany
    {
        return $this->hasMany(OrderLine::class, 'payed_with_withdrawal');
    }

    /**
     * @return Collection<int, OrderLine>
     */
    public function orderlinesForUser(User $user): Collection
    {
        return $this->orderlines->where('user_id', $user->id);
    }

    public function totalForUser(User $user): int
    {
        return OrderLine::query()->where('user_id', $user->id)->where('payed_with_withdrawal', $this->id)->sum('total_price');
    }

    public function getFailedWithdrawal(User $user): ?FailedWithdrawal
    {
        return FailedWithdrawal::query()->where('user_id', $user->id)->where('withdrawal_id', $this->id)->first();
    }

    /**
     * @return HasMany<FailedWithdrawal, $this>
     */
    public function failedWithdrawals(): HasMany
    {
        return $this->hasMany(FailedWithdrawal::class, 'withdrawal_id');
    }

    /**
     * @return HasManyThrough<User, OrderLine, $this>
     */
    public function users(): HasManyThrough
    {
        return $this->hasManyThrough(User::class, OrderLine::class, 'payed_with_withdrawal', 'id', 'id', 'user_id')->distinct();
    }

    public function total(): mixed
    {
        return OrderLine::query()->where('payed_with_withdrawal', $this->id)->sum('total_price');
    }

    /**
     * @return Attribute<string, never>
     */
    protected function withdrawalId(): Attribute
    {
        return Attribute::make(get: fn (): string => 'PROTO-'.$this->id.'-'.date('dmY', strtotime($this->date)));
    }

    public function recalculateTotals(): void
    {
        $this->update([
            'total_users_associated' => $this->users()->count(),
            'total_orderlines_associated' => $this->orderlines()->count(),
            'sum_associated_orderlines' => $this->orderlines()->sum('total_price'),
        ]);
    }
}
