<?php

namespace Proto\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SoundboardSound extends Model
{
    protected $table = 'soundboard_sounds';

    protected $guarded = ['id'];

    public $timestamps = false;

    public function file()
    {
        return $this->belongsTo('Proto\Models\StorageEntry', 'file_id');
    }
}
