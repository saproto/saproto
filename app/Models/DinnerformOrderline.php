<?php

namespace App\Models;

use Database\Factories\DinnerformOrderlineFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;
use Override;
use RoundingMode;

/**
 * DinnerformOrderline Model.
 *
 * @property int $id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property int $user_id
 * @property int $dinnerform_id
 * @property string $description
 * @property float $price
 * @property bool $helper
 * @property bool $closed
 * @property-read Dinnerform|null $dinnerform
 * @property-read int|float $price_with_discount
 * @property-read User|null $user
 *
 * @method static DinnerformOrderlineFactory factory($count = null, $state = [])
 * @method static Builder<static>|DinnerformOrderline newModelQuery()
 * @method static Builder<static>|DinnerformOrderline newQuery()
 * @method static Builder<static>|DinnerformOrderline query()
 * @method static Builder<static>|DinnerformOrderline whereClosed($value)
 * @method static Builder<static>|DinnerformOrderline whereCreatedAt($value)
 * @method static Builder<static>|DinnerformOrderline whereDescription($value)
 * @method static Builder<static>|DinnerformOrderline whereDinnerformId($value)
 * @method static Builder<static>|DinnerformOrderline whereHelper($value)
 * @method static Builder<static>|DinnerformOrderline whereId($value)
 * @method static Builder<static>|DinnerformOrderline wherePrice($value)
 * @method static Builder<static>|DinnerformOrderline whereUpdatedAt($value)
 * @method static Builder<static>|DinnerformOrderline whereUserId($value)
 *
 * @mixin \Eloquent
 */
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
     * @return Attribute<float|int, never> Price of orderline reduced by possible discounts.
     */
    protected function priceWithDiscount(): Attribute
    {
        return Attribute::make(get: function (): float|int {
            $with_regular_discount = $this->price * $this->dinnerform->regular_discount;
            $price = round($with_regular_discount, 2, RoundingMode::HalfTowardsZero);
            if ($this->helper && $this->dinnerform->helper_discount) {
                $with_helper_discount = $price - $this->dinnerform->helper_discount;

                return max(0, $with_helper_discount);
            }

            return $price;
        });
    }

    #[Override]
    protected function casts(): array
    {
        return [
            'closed' => 'boolean',
            'helper' => 'boolean',
        ];
    }
}
