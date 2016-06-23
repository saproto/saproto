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
        return $this->hasMany('Proto\Models\Product', 'products_categories', 'product_id', 'category_id');
    }

}
