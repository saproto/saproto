<?php

namespace Proto\Models;

use Illuminate\Database\Eloquent\Model;
use Proto\Models\Page;

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

    public function getUrl() {
        if($this->page_id == null) {
            return $this->url;
        }else{
            return Page::find($this->page_id)->getUrl();
        }
    }
}
