<?php

namespace Proto\Models;

use Carbon;
use Eloquent;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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
 * @mixin Eloquent
 **/
class DinnerformOrderline extends Model
{
    protected $table = 'dinnerform_orderline';

    protected $guarded = ['id'];

    /** @return BelongsTo */
    public function user()
    {
        return $this->belongsTo('Proto\Models\User')->withTrashed();
    }

    /** @return BelongsTo */
    public function dinnerform()
    {
        return $this->belongsTo('Proto\Models\Dinnerform');
    }

    /** @return float Price of orderline - possible discount */
    public function getPriceAttribute() {
        $price = $this->attributes['price'];
        if($this->helper && $this->dinnerform->discount){
            $discounted = $price - $this->dinnerform->discount;
            if($discounted > 0)return $discounted;
            return 0;
        }

        return $price;
    }
}
