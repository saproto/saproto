<?php

namespace Proto\Models;

use Illuminate\Database\Eloquent\Model;

class DinnerOrderLine extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'dinnerOrders';

    public function user()
    {
        return $this->belongsTo('Proto\Models\User','user_id');
    }
    //order ophalen -> find or fail (parent class)

}
