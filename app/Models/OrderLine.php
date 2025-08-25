<?php

namespace App\Models;

use Database\Factories\OrderLineFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Config;
use Override;

/**
 * App\Models\OrderLine.
 *
 * @property int $id
 * @property int|null $user_id
 * @property int|null $cashier_id
 * @property int $product_id
 * @property float $original_unit_price
 * @property int $units
 * @property float $total_price
 * @property string $authenticated_by
 * @property string|null $payed_with_cash
 * @property string|null $payed_with_bank_card
 * @property int|null $payed_with_mollie
 * @property int|null $payed_with_withdrawal
 * @property bool $payed_with_loss
 * @property string|null $description
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read User|null $cashier
 * @property-read MollieTransaction|null $molliePayment
 * @property-read Product|null $product
 * @property-read TicketPurchase|null $ticketPurchase
 * @property-read User|null $user
 * @property-read Withdrawal|null $withdrawal
 *
 * @method static OrderLineFactory factory($count = null, $state = [])
 * @method static Builder<static>|OrderLine newModelQuery()
 * @method static Builder<static>|OrderLine newQuery()
 * @method static Builder<static>|OrderLine query()
 * @method static Builder<static>|OrderLine unpayed()
 * @method static Builder<static>|OrderLine whereAuthenticatedBy($value)
 * @method static Builder<static>|OrderLine whereCashierId($value)
 * @method static Builder<static>|OrderLine whereCreatedAt($value)
 * @method static Builder<static>|OrderLine whereDescription($value)
 * @method static Builder<static>|OrderLine whereId($value)
 * @method static Builder<static>|OrderLine whereOriginalUnitPrice($value)
 * @method static Builder<static>|OrderLine wherePayedWithBankCard($value)
 * @method static Builder<static>|OrderLine wherePayedWithCash($value)
 * @method static Builder<static>|OrderLine wherePayedWithLoss($value)
 * @method static Builder<static>|OrderLine wherePayedWithMollie($value)
 * @method static Builder<static>|OrderLine wherePayedWithWithdrawal($value)
 * @method static Builder<static>|OrderLine whereProductId($value)
 * @method static Builder<static>|OrderLine whereTotalPrice($value)
 * @method static Builder<static>|OrderLine whereUnits($value)
 * @method static Builder<static>|OrderLine whereUpdatedAt($value)
 * @method static Builder<static>|OrderLine whereUserId($value)
 *
 * @mixin \Eloquent
 */
class OrderLine extends Model
{
    /** @use HasFactory<OrderLineFactory>*/
    use HasFactory;

    protected $table = 'orderlines';

    protected $guarded = ['id'];

    #[Override]
    protected function casts(): array
    {
        return [
            'payed_with_loss' => 'boolean',
        ];
    }

    /**
     * @return BelongsTo<User, $this>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class)->withTrashed();
    }

    /**
     * @return BelongsTo<Product, $this>
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * @return BelongsTo<User, $this>
     */
    public function cashier(): BelongsTo
    {
        return $this->belongsTo(User::class)->withTrashed();
    }

    /**
     * @return BelongsTo<Withdrawal, $this>
     */
    public function withdrawal(): BelongsTo
    {
        return $this->belongsTo(Withdrawal::class, 'payed_with_withdrawal');
    }

    /**
     * @return BelongsTo<MollieTransaction, $this>
     */
    public function molliePayment(): BelongsTo
    {
        return $this->belongsTo(MollieTransaction::class, 'payed_with_mollie');
    }

    /**
     * @return HasOne<TicketPurchase, $this>
     */
    public function ticketPurchase(): HasOne
    {
        return $this->hasOne(TicketPurchase::class, 'orderline_id');
    }

    /** @param Builder<OrderLine> $query
     * @return Builder<OrderLine>
     */
    protected function scopeUnpayed(Builder $query): Builder
    {
        return $query->whereNull('payed_with_cash')
            ->whereNull('payed_with_bank_card')
            ->whereNull('payed_with_withdrawal')
            ->where('payed_with_loss', false)
            ->where(function ($query) {
                $query->whereDoesntHave('molliePayment')
                    ->orWhereHas('molliePayment', static function ($query) {
                        $query->whereNotIn('status', Config::array('omnomcom.mollie.paid_statuses'));
                    });
            })
            ->where('total_price', '!=', 0);
    }

    public function isPayed(): bool
    {
        $mollie_payment = false;
        if ($this->payed_with_mollie !== null) {
            $mollie_payment = $this->molliePayment->translatedStatus();
        }

        return
            $this->total_price == 0 ||
            $this->payed_with_loss ||
            $this->payed_with_cash !== null ||
            $this->payed_with_withdrawal !== null ||
            $mollie_payment == 'paid' ||
            $this->payed_with_bank_card !== null;
    }

    public function canBeDeleted(): bool
    {
        return $this->total_price == 0 || ! $this->isPayed();
    }

    public function generateHistoryStatus(): string
    {
        if ($this->payed_with_loss) {
            return 'Loss';
        }

        if ($this->payed_with_withdrawal !== null) {
            return "Withdrawal <a href='".
                route('omnomcom::mywithdrawal', ['id' => $this->payed_with_withdrawal]).
                "'>#".
                $this->payed_with_withdrawal.
                '</a>';
        }

        if ($this->payed_with_cash !== null) {
            return 'Cash';
        }

        if ($this->payed_with_bank_card !== null) {
            return 'Bank Card';
        }

        if ($this->total_price == 0) {
            return 'Free!';
        }

        if ($this->payed_with_mollie !== null) {
            return match ($this->molliePayment->translatedStatus()) {
                'paid' => '<i class="fas fa-check ml-2 text-success"></i> - <a href=\''.
                    route('omnomcom::mollie::status', ['id' => $this->payed_with_mollie]).
                    "'>#".
                    $this->payed_with_mollie.
                    '</a>',
                'failed' => '<i class="fas fa-times ml-2 text-danger"></i> - <a href=\''.
                    route('omnomcom::mollie::status', ['id' => $this->payed_with_mollie]).
                    "'>#".
                    $this->payed_with_mollie.
                    '</a>',
                'open' => '<i class="fas fa-spinner ml-2 text-normal"></i> - <a href=\''.
                    route('omnomcom::mollie::status', ['id' => $this->payed_with_mollie]).
                    "'>#".
                    $this->payed_with_mollie.
                    '</a>',
                default => '<i class="fas fa-question ml-2 text-normal"></i> - <a href=\''.
                    route('omnomcom::mollie::status', ['id' => $this->payed_with_mollie]).
                    "'>#".
                    $this->payed_with_mollie.
                    '</a>',
            };
        }

        return 'Unpaid';
    }
}
