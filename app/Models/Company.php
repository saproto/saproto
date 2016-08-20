<?php

namespace Proto\Models;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    protected $table = 'companies';

    protected $guarded = ['id'];

    public function image()
    {
        return $this->belongsTo('Proto\Models\StorageEntry', 'image_id');
    }
}
