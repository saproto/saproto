<?php

namespace Proto\Models;

use Illuminate\Database\Eloquent\Model;

class HeaderImage extends Model
{
    protected $guarded = ['id'];
    protected $table = 'headerimages';

    public function user()
    {
        return $this->belongsTo('Proto\Models\User', 'credit_id');
    }

    public function image()
    {
        return $this->belongsTo('Proto\Models\StorageEntry', 'image_id', 'id');
    }
}
