<?php

namespace Proto\Models;

use Carbon;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * Proto\Models\OrderLine
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
 * @property string|null $description
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read User|null $cashier
 * @property-read MollieTransaction|null $molliePayment
 * @property-read Product $product
 * @property-read TicketPurchase $ticketPurchase
 * @property-read User|null $user
 * @property-read Withdrawal|null $withdrawal
 * @method static Builder|OrderLine whereAuthenticatedBy($value)
 * @method static Builder|OrderLine whereCashierId($value)
 * @method static Builder|OrderLine whereCreatedAt($value)
 * @method static Builder|OrderLine whereDescription($value)
 * @method static Builder|OrderLine whereId($value)
 * @method static Builder|OrderLine whereOriginalUnitPrice($value)
 * @method static Builder|OrderLine wherePayedWithBankCard($value)
 * @method static Builder|OrderLine wherePayedWithCash($value)
 * @method static Builder|OrderLine wherePayedWithMollie($value)
 * @method static Builder|OrderLine wherePayedWithWithdrawal($value)
 * @method static Builder|OrderLine whereProductId($value)
 * @method static Builder|OrderLine whereTotalPrice($value)
 * @method static Builder|OrderLine whereUnits($value)
 * @method static Builder|OrderLine whereUpdatedAt($value)
 * @method static Builder|OrderLine whereUserId($value)
 * @mixin Eloquent
 */
class OrderLine extends Model
{
    protected $table = 'orderlines';

    protected $guarded = ['id'];

    /** @return BelongsTo|User */
    public function user()
    {
        return $this->belongsTo('Proto\Models\User')->withTrashed();
    }

    /** @return BelongsTo|Product */
    public function product()
    {
        return $this->belongsTo('Proto\Models\Product');
    }

    /** @return BelongsTo|User */
    public function cashier()
    {
        return $this->belongsTo('Proto\Models\User')->withTrashed();
    }

    /** @return BelongsTo|Withdrawal */
    public function withdrawal()
    {
        return $this->belongsTo('Proto\Models\Withdrawal', 'payed_with_withdrawal');
    }

    /** @return BelongsTo|MollieTransaction */
    public function molliePayment()
    {
        return $this->belongsTo('Proto\Models\MollieTransaction', 'payed_with_mollie');
    }

    /** @return HasOne|TicketPurchase */
    public function ticketPurchase()
    {
        return $this->hasOne('Proto\Models\TicketPurchase', 'orderline_id');
    }

    /** @return bool */
    public function isPayed()
    {
        return (
            $this->total_price == 0 ||
            $this->payed_with_cash !== null ||
            $this->payed_with_mollie !== null ||
            $this->payed_with_withdrawal !== null ||
            $this->payed_with_bank_card !== null
        );
    }

    /** @return bool */
    public function canBeDeleted()
    {
        return $this->total_price == 0 || !$this->isPayed();
    }

    /** @return string */
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
