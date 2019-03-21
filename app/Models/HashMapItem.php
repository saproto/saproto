<?php

namespace Proto\Models;

use Illuminate\Database\Eloquent\Model;

class HashMapItem extends Model
{
    protected $table = 'hashmap';
    public $timestamps = false;
    protected $guarded = [];

    public function scopeKey($query, $key) {
        return $query->where('key', '=', $key);
    }

    public function scopeSubkey($query, $subkey) {
        return $query->where('subkey', '=', $subkey);
    }

    public function setItem($key, $subkey) {

    }

}
