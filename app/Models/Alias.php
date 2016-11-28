<?php

namespace Proto\Models;

use Illuminate\Database\Eloquent\Model;

class Alias extends Model
{

    protected $table = 'alias';

    protected $guarded = ['id'];

    public function user()
    {
        return $this->belongsTo('Proto\Models\User')->withTrashed();
    }

}
