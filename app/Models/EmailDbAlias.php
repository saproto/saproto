<?php

namespace Proto\Models;

use Illuminate\Database\Eloquent\Model;

class EmailDbAlias extends Model
{

    protected $connection = 'mysql-mail';

    public $timestamps = false;

    protected $table = 'virtual_aliases';

    protected $guarded = ['id'];

}
