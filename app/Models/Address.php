<?php

namespace Proto\Models;

use Illuminate\Database\Eloquent\Model;


/**
 * Proto\Models\Address
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $street
 * @property string $number
 * @property string $zipcode
 * @property string $city
 * @property string $country
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property boolean $is_primary
 * @property-read \Proto\Models\User $user
 */
class Address extends Model
{
    protected $table  = 'addresses';

    public function user()
    {
        return $this->belongsTo('Proto\Models\User');
    }

    protected $fillable = ['street', 'number', 'zipcode', 'city', 'country'];
}
