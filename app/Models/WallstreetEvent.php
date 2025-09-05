<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Carbon;

/**
 * Class WallstreetEvent.
 *
 * @property int $id
 * @property string $name
 * @property int $percentage
 * @property string|null $description
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property bool $active
 * @property-read Collection<int, Product> $products
 * @property-read int|null $products_count
 *
 * @method static Builder<static>|WallstreetEvent newModelQuery()
 * @method static Builder<static>|WallstreetEvent newQuery()
 * @method static Builder<static>|WallstreetEvent query()
 * @method static Builder<static>|WallstreetEvent whereActive($value)
 * @method static Builder<static>|WallstreetEvent whereCreatedAt($value)
 * @method static Builder<static>|WallstreetEvent whereDescription($value)
 * @method static Builder<static>|WallstreetEvent whereId($value)
 * @method static Builder<static>|WallstreetEvent whereImageId($value)
 * @method static Builder<static>|WallstreetEvent whereName($value)
 * @method static Builder<static>|WallstreetEvent wherePercentage($value)
 * @method static Builder<static>|WallstreetEvent whereUpdatedAt($value)
 *
 * @mixin \Eloquent
 */
class WallstreetEvent extends Model
{
    protected $table = 'wallstreet_drink_events';

    /**
     * @return BelongsToMany<Product, $this>
     */
    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'wallstreet_drink_event_product', 'wallstreet_drink_event_id');
    }

    protected function casts(): array
    {
        return [
            'active' => 'boolean',
        ];
    }
}
