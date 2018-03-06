<?php

namespace Proto\Models;

use Illuminate\Database\Eloquent\Model;

class Address extends Validatable
{
    protected $table = 'addresses';

    protected $hidden = ['id'];

    protected $rules = array(
        'user_id' => 'required|integer',
        'street' => 'required|string',
        'number' => 'required|string',
        'zipcode' => 'required|string',
        'city' => 'required|string',
        'country' => 'required|string'
    );

    public function user()
    {
        return $this->belongsTo('Proto\Models\User');
    }

    protected $guarded = ['id'];
}
