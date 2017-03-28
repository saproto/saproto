<?php

namespace Proto\Models;

use Illuminate\Database\Eloquent\Model;

class Tempadmin extends Model
{
    protected $table = 'tempadmins';

    protected $guarded = ['id'];

    public function user()
    {
        return $this->belongsTo('Proto\Models\User');
    }

    public function creator()
    {
        return $this->belongsTo('Proto\Models\User', 'created_by');
    }
}
