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
 * @property-read StorageEntry|null $image
 * @property-read Ticket|null $ticket
 * @property-read Collection|ProductCategory[] $categories
 * @property-read Collection|OrderLine[] $orderlines
 *
 * @method static Builder|Product whereAccountId($value)
 * @method static Builder|Product whereCalories($value)
 * @method static Builder|Product whereCreatedAt($value)
 * @method static Builder|Product whereId($value)
 * @method static Builder|Product whereImageId($value)
 * @method static Builder|Product whereIsAlcoholic($value)
 * @method static Builder|Product whereIsVisible($value)
 * @method static Builder|Product whereIsVisibleWhenNoStock($value)
 * @method static Builder|Product whereMaxStock($value)
 * @method static Builder|Product whereName($value)
 * @method static Builder|Product wherePreferredStock($value)
 * @method static Builder|Product wherePrice($value)
 * @method static Builder|Product whereStock($value)
 * @method static Builder|Product whereSupplierCollo($value)
 * @method static Builder|Product whereSupplierId($value)
 * @method static Builder|Product whereUpdatedAt($value)
 * @method static Builder|Product newModelQuery()
 * @method static Builder|Product newQuery()
 * @method static Builder|Product query()
 *
 * @mixin Model
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
        if (! $active) {
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
}
