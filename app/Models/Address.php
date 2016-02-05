<?php

namespace Proto\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Proto\Address
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $type
 * @property string $street
 * @property string $number
 * @property string $zipcode
 * @property string $city
 * @property string $country
 * @property-read \Proto\User $user
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 */
class Address extends Model
{
    protected $table  = 'addresses';

    public function user()
    {
        return $this->belongsTo('Proto\Models\User');
    }
}
