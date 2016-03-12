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
class Address extends Validatable
{
    protected $table  = 'addresses';

    protected $rules = array(
        'user_id' => 'required|integer',
        'street' => 'required|string',
        'number' => 'required|string',
        'zipcode' => 'required|string',
        'city' => 'required|string',
        'country'=> 'required|string'
    );

    public function user()
    {
        return $this->belongsTo('Proto\Models\User');
    }

    protected $fillable = ['user_id', 'street', 'number', 'zipcode', 'city', 'country'];
}
