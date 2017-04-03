<?php

namespace Proto\Models;

use Illuminate\Database\Eloquent\Model;

class HashMapItem extends Model
{
    protected $table = 'hashmap';
    public $timestamps = false;
    protected $guarded = [];
}
