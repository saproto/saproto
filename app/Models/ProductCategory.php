<?php

namespace Proto\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductCategory extends Model
{

    use SoftDeletes;
    protected $dates = ['deleted_at'];

    protected $table = 'product_categories';
    protected $guarded = [/*'id'*/];

    public function products()
    {
        $products = $this->belongsToMany('Proto\Models\Product', 'products_categories', 'category_id', 'product_id')->get();
        $products = $products->sortBy('name');
        return $products;
    }

}