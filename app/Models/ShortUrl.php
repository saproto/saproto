<?php

namespace Proto\Models;

use Illuminate\Database\Eloquent\Model;

class ShortUrl extends Model
{
    protected $guarded = ['id'];
    protected $table = 'short_url';
}
