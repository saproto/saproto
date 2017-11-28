<?php

namespace Proto\Models;

use Illuminate\Database\Eloquent\Model;

class DmxChannel extends Model
{
    protected $table = 'dmx_channel_names';
    protected $fillable = ['id', 'name'];
    public $timestamps = false;
}
