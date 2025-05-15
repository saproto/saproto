<?php

namespace App\Models;

use Database\Factories\DinnerformOrderlineFactory;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * DinnerformOrderline Model.
 *
 * @property int $id
 * @property int|null $user_id
 * @property int $dinnerform_id
 * @property string $description
 * @property float $price
 * @property bool $closed
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property bool|null $helper
 * @property-read User $user
 * @property-read Dinnerform $dinnerform
 * @property-read float|int $price_with_discount
 *
 * @mixin Model
 **/
class DinnerformOrderline extends Model
{
    /** @use HasFactory<DinnerformOrderlineFactory>*/
    use HasFactory;

    protected $table = 'dinnerform_orderline';

    protected $guarded = ['id'];

    /**
     * @return BelongsTo<User, $this>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class)->withTrashed();
    }

    /**
     * @return BelongsTo<Dinnerform, $this>
     */
    public function dinnerform(): BelongsTo
    {
        return $this->belongsTo(Dinnerform::class);
    }

    /**
     * @return Attribute Price of orderline reduced by possible discounts.
     * @return Attribute<float|int, never> Price of orderline reduced by possible discounts.
     */
    protected function priceWithDiscount(): Attribute
    {
        return Attribute::make(get: function (): float|int {
            $with_regular_discount = $this->price * $this->dinnerform->regular_discount;
            $price = round($with_regular_discount, 2, PHP_ROUND_HALF_DOWN);
            if ($this->helper && $this->dinnerform->helper_discount) {
                $with_helper_discount = $price - $this->dinnerform->helper_discount;

                return max(0, $with_helper_discount);
            }

            return $price;
        });
    }
}
