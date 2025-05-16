<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * Product Category Entry Model.
 *
 * @property int $id
 * @property int $product_id
 * @property int $category_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read ProductCategory|null $ProductCategory
 * @property-read Product|null $product
 *
 * @method static Builder<static>|ProductCategoryEntry newModelQuery()
 * @method static Builder<static>|ProductCategoryEntry newQuery()
 * @method static Builder<static>|ProductCategoryEntry query()
 * @method static Builder<static>|ProductCategoryEntry whereCategoryId($value)
 * @method static Builder<static>|ProductCategoryEntry whereCreatedAt($value)
 * @method static Builder<static>|ProductCategoryEntry whereId($value)
 * @method static Builder<static>|ProductCategoryEntry whereProductId($value)
 * @method static Builder<static>|ProductCategoryEntry whereUpdatedAt($value)
 *
 * @mixin \Eloquent
 */
class ProductCategoryEntry extends Model
{
    protected $table = 'products_categories';

    protected $guarded = ['id'];

    /** @var array|string[] */
    protected array $rules = [
        'user_id' => 'required|integer',
        'achievement_id' => 'required|integer',
        'rank' => 'required|integer',
    ];

    /**
     * @return BelongsTo<Product, $this> */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * @return BelongsTo<ProductCategory, $this> */
    public function ProductCategory(): BelongsTo
    {
        return $this->belongsTo(ProductCategory::class);
    }
}
