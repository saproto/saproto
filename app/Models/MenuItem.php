<?php

namespace Proto\Models;

use Illuminate\Database\Eloquent\Model;

class MenuItem extends Model
{
    protected $table = 'menuitems';

    protected $guarded = ['id'];

    public function children() {
        return $this->hasMany('Proto\Models\MenuItem', 'parent');
    }

    public function page()
    {
        return $this->belongsTo('Proto\Models\Page', 'page_id', 'id');
    }
}
