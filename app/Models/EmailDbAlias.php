<?php

namespace Proto\Models;

use Illuminate\Database\Eloquent\Model;

class EmailDbAlias extends Model
{
    public $connection = 'mysql-mail';

    protected $table = 'virtual_aliases';

    protected $guarded = ['id'];

    public $timestamps = false;
}
