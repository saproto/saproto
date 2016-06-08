<?php

namespace Proto\Models;

use Illuminate\Database\Eloquent\Model;

class Achievement extends Model
{
    protected $table = 'achievements';

    protected $fillable = ['name', 'desc', 'img_file_id', 'tier'];

    public function user()
    {
        return $this->hasMany('Proto\Models\User');
    }
}