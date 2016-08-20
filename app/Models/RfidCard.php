<?php

namespace Proto\Models;

use Illuminate\Database\Eloquent\Model;

class RfidCard extends Model
{
    protected $table = 'rfid';

    protected $guarded = ['id'];

    public function user()
    {
        return $this->belongsTo('Proto\Models\User');
    }
}
