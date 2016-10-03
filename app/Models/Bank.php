<?php

namespace Proto\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Bank extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];

    protected $table = 'bankaccounts';

    protected $guarded = ['id'];

    public function user()
    {
        return $this->belongsTo('Proto\Models\User')->withTrashed();
    }

}
