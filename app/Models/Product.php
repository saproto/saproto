<?php

namespace Proto\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{

    protected $table = 'products';
    protected $guarded = [/*'id'*/];

    public function categories()
    {
        return $this->belongsToMany('Proto\Models\ProductCategory', 'products_categories', 'product_id', 'category_id');
    }

    public function account()
    {
        return $this->belongsTo('Proto\Models\FinancialAccount');
    }

    public function orderlines()
    {
        return $this->hasMany('Proto\Models\OrderLine');
    }

    public function image()
    {
        return $this->belongsTo('Proto\Models\StorageEntry', 'image_id');
    }

    public function isVisible()
    {
        if (!$this->is_visible) return false;
        if ($this->stock <= 0 && !$this->is_visible_when_no_stock) return false;
        
        return true;
    }

}
