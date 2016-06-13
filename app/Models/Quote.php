<?php

namespace Proto\Models;

use Illuminate\Database\Eloquent\Model;

class Quote extends Validatable
{
    protected $table = 'quotes';
    
    protected $guarded = ['id'];

    public function user()
    {
        return $this->belongsTo('Proto\Models\User');
    }
}