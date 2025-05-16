<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Override;

/**
 * Withdrawal Model.
 *
 * @property int $id
 * @property string $date
 * @property bool $closed
 * @property int $total_users_associated
 * @property int $total_orderlines_associated
 * @property float $sum_associated_orderlines
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Collection<int, OrderLine> $orderlines
 * @property-read Collection<int, FailedWithdrawal> $failedWithdrawals
 * @property-read Collection<int, User> $users
 * @property-read string $withdrawalId
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
 * @mixin Model
 *
 * @property-read int|null $failed_withdrawals_count
 * @property-read int|null $orderlines_count
 * @property-read int|null $users_count
 * @property-read string $withdrawal_id
 *
 * @method static Builder<static>|Withdrawal whereSumAssociatedOrderlines($value)
 * @method static Builder<static>|Withdrawal whereTotalOrderlinesAssociated($value)
 * @method static Builder<static>|Withdrawal whereTotalUsersAssociated($value)
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
     * @return HasMany<OrderLine, $this>
     */
    public function orderlinesForUser(User $user): HasMany
    {
        return $this->orderlines()->where('user_id', $user->id);
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
