<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;

/**
 * Financial Account Model.
 *
 * @property int $id
 * @property int $account_number
 * @property string $name
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Collection<int, Product> $products
 * @property-read int|null $products_count
 *
 * @method static Builder<static>|FinancialAccount newModelQuery()
 * @method static Builder<static>|FinancialAccount newQuery()
 * @method static Builder<static>|FinancialAccount query()
 * @method static Builder<static>|FinancialAccount whereAccountNumber($value)
 * @method static Builder<static>|FinancialAccount whereCreatedAt($value)
 * @method static Builder<static>|FinancialAccount whereId($value)
 * @method static Builder<static>|FinancialAccount whereName($value)
 * @method static Builder<static>|FinancialAccount whereUpdatedAt($value)
 *
 * @mixin Model
 */
class FinancialAccount extends Model
{
    protected $table = 'accounts';

    protected $guarded = ['id'];

    /**
     * @return HasMany<Product, $this> */
    public function products(): HasMany
    {
        return $this->hasMany(Product::class, 'account_id');
    }
}
