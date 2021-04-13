<?php

namespace Proto\Models;

use Illuminate\Database\Eloquent\Model;

class ProductCategoryEntry extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'products_categories';

    /**
     * @return mixed Product in the catogory
     */
    public function product()
    {
        return $this->belongsTo('Proto\Models\Product');
    }

    /**
     * @return mixed The achievement this association is for.
     */
    public function ProductCategory()
    {
        return $this->belongsTo('Proto\Models\ProductCategory');
    }

    protected $fillable = ['product_id', 'category_id', 'rank'];

    protected $rules = [
        'user_id'        => 'required|integer',
        'achievement_id' => 'required|integer',
        'rank'           => 'required|integer',
    ];
}
