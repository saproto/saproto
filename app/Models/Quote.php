<?php

namespace Proto\Models;

use Illuminate\Database\Eloquent\Model;

class Quote extends Validatable
{
    protected $table = 'quotes';

    protected $fillable = ['user_id', 'quote'];

    public function user()
    {
        return $this->belongsTo('Proto\Models\User');
    }
}