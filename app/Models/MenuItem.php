<?php

namespace Proto\Models;

use Exception;

use Illuminate\Database\Eloquent\Model;
use Proto\Models\Page;

class MenuItem extends Model
{
    protected $table = 'menuitems';

    protected $guarded = ['id'];

    public function children()
    {
        return $this->hasMany('Proto\Models\MenuItem', 'parent');
    }

    public function page()
    {
        return $this->belongsTo('Proto\Models\Page', 'page_id', 'id');
    }

    public function getUrl()
    {
        if (substr($this->url, 0, 8) == "(route) ") {
            try {
                return route(substr($this->url, 8));
            } catch (Exception $e) {
                return "#";
            }
        } elseif ($this->page_id == null) {
            return $this->url;
        } else {
            $page = Page::find($this->page_id);
            if ($page) return $page->getUrl();
            return "#";
        }
    }

    public function isFirst()
    {
        $lowest = MenuItem::where('parent', '=', $this->parent)->orderBy('order')->first();
        if ($this->id == $lowest->id) {
            return true;
        } else {
            return false;
        }
    }

    public function isLast()
    {
        $highest = MenuItem::where('parent', '=', $this->parent)->orderBy('order', 'desc')->first();
        if ($this->id == $highest->id) {
            return true;
        } else {
            return false;
        }
    }
}
