<?php

namespace Proto\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{

    protected $table = 'products';
    protected $guarded = [/*'id'*/];

    public function categories()
    {
        return $this->belongsToMany('Proto\Models\ProductCategory', 'products_categories', 'category_id', 'product_id');
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

}
