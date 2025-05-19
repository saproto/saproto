<?php

namespace App\Models;

use App\Http\Controllers\WallstreetController;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Carbon;

/**
 * Product Model.
 *
 * @property int $id
 * @property int $account_id
 * @property int|null $image_id
 * @property string $name
 * @property float $price
 * @property int $calories
 * @property string|null $supplier_id
 * @property int $stock
 * @property int $preferred_stock
 * @property int $max_stock
 * @property int $supplier_collo
 * @property bool $is_visible
 * @property bool $is_alcoholic
 * @property bool $is_visible_when_no_stock
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read FinancialAccount|null $account
 * @property-read Collection<int, ProductCategory> $categories
 * @property-read int|null $categories_count
 * @property-read StorageEntry|null $image
 * @property-read mixed $image_url
 * @property-read Collection<int, OrderLine> $orderlines
 * @property-read int|null $orderlines_count
 * @property-read Ticket|null $ticket
 * @property-read Collection<int, WallstreetPrice> $wallstreetPrices
 * @property-read int|null $wallstreet_prices_count
 *
 * @method static Builder<static>|Product newModelQuery()
 * @method static Builder<static>|Product newQuery()
 * @method static Builder<static>|Product query()
 * @method static Builder<static>|Product whereAccountId($value)
 * @method static Builder<static>|Product whereCalories($value)
 * @method static Builder<static>|Product whereCreatedAt($value)
 * @method static Builder<static>|Product whereId($value)
 * @method static Builder<static>|Product whereImageId($value)
 * @method static Builder<static>|Product whereIsAlcoholic($value)
 * @method static Builder<static>|Product whereIsVisible($value)
 * @method static Builder<static>|Product whereIsVisibleWhenNoStock($value)
 * @method static Builder<static>|Product whereMaxStock($value)
 * @method static Builder<static>|Product whereName($value)
 * @method static Builder<static>|Product wherePreferredStock($value)
 * @method static Builder<static>|Product wherePrice($value)
 * @method static Builder<static>|Product whereStock($value)
 * @method static Builder<static>|Product whereSupplierCollo($value)
 * @method static Builder<static>|Product whereSupplierId($value)
 * @method static Builder<static>|Product whereUpdatedAt($value)
 *
 * @mixin \Eloquent
 */
class Product extends Model
{
    protected $table = 'products';

    protected $guarded = ['id'];

    protected $hidden = ['created_at', 'updated_at'];

    protected $appends = ['image_url'];

    /**
     * @return BelongsTo<FinancialAccount, $this>
     */
    public function account(): BelongsTo
    {
        return $this->belongsTo(FinancialAccount::class);
    }

    /**
     * @return BelongsTo<StorageEntry, $this>
     */
    public function image(): BelongsTo
    {
        return $this->belongsTo(StorageEntry::class, 'image_id');
    }

    /**
     * @return Attribute<string, never>
     */
    protected function imageUrl(): Attribute
    {
        return Attribute::make(get: fn () => $this->image?->generateImagePath(null, null));
    }

    /**
     * @return BelongsToMany<ProductCategory, $this>
     */
    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(ProductCategory::class, 'products_categories', 'product_id', 'category_id');
    }

    /**
     * @return HasOne<Ticket, $this>
     */
    public function ticket(): HasOne
    {
        return $this->hasOne(Ticket::class, 'product_id');
    }

    /**
     * @return HasMany<OrderLine, $this>
     */
    public function orderlines(): HasMany
    {
        return $this->hasMany(OrderLine::class);
    }

    public function isVisible(): bool
    {
        return $this->is_visible && ! ($this->stock <= 0 && ! $this->is_visible_when_no_stock);
    }

    public function omnomcomPrice(): float
    {
        $active = WallstreetController::active();
        if (! $active instanceof WallstreetDrink) {
            return $this->price;
        }

        return WallstreetPrice::query()->where('product_id', $this->id)->where('wallstreet_drink_id', $active->id)->orderby('created_at', 'desc')->first()->price ?? $this->price;
    }

    /**
     * @return HasMany<WallstreetPrice, $this>
     */
    public function wallstreetPrices(): HasMany
    {
        return $this->hasMany(WallstreetPrice::class);
    }

    /**
     * @return int OrderLine id
     */
    public function buyForUser(User $user, int $amount, ?float $total_price = null, ?bool $withCash = false, ?bool $withBankCard = false, ?string $description = null, string $auth_method = 'none'): int
    {
        $this->stock -= $amount;
        $this->save();

        $total_price ??= $this->price * $amount;

        $has_cashier = $withCash || $withBankCard;
        /** @var OrderLine $orderline */
        $orderline = OrderLine::query()->create([
            'user_id' => ($has_cashier ? null : $user->id),
            'cashier_id' => ($has_cashier || $total_price == 0 ? $user->id : null),
            'product_id' => $this->id,
            'original_unit_price' => $this->price,
            'units' => $amount,
            'total_price' => $total_price,
            'payed_with_cash' => ($withCash === true ? Carbon::now()->format('Y-m-d H:i:s') : null),
            'payed_with_bank_card' => ($withBankCard === true ? Carbon::now()->format('Y-m-d H:i:s') : null),
            'description' => $description == '' ? null : $description,
            'authenticated_by' => $auth_method,
        ]);

        $orderline->save();

        return $orderline->id;
    }

    protected function casts(): array
    {
        return [
            'is_alcoholic' => 'boolean',
            'is_visible' => 'boolean',
            'is_visible_when_no_stock' => 'boolean',
        ];
    }
}
