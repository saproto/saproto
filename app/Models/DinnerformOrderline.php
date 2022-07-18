<?php

namespace Proto\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * DinnerformOrderline Model.
 * @property int $id
 * @property int|null $user_id
 *  * @property int $dinnerform_id
 * @property string $description
 * @property float $price
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property boolean|null $helper
 * @mixin Eloquent
 **/
class DinnerformOrderline extends Model
{
    protected $table = 'dinnerform_orderline';

    protected $guarded = ['id'];
    /**
     * @var mixed
     */

    /** @return BelongsTo|User */
    public function user()
    {
        return $this->belongsTo('Proto\Models\User')->withTrashed()->first();
    }

    /** @return BelongsTo|Model|object */
    public function dinnerform()
    {
        return $this->belongsTo('Proto\Models\Dinnerform')->first();
    }

    public function price(){
        if($this->helper && $this->dinnerform()->discount){
            return $this->price/100*(100-$this->dinnerform()->discount);
        }
        return $this->price;
    }
}
