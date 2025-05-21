<?php

namespace App\Models;

use Database\Factories\DinnerformFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Override;

/**
 * Dinnerform Model.
 *
 * @property int $id
 * @property string $restaurant
 * @property string $description
 * @property string $url
 * @property Carbon $start
 * @property Carbon $end
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property int|null $event_id
 * @property float $helper_discount
 * @property float $regular_discount
 * @property bool $closed
 * @property bool $visible_home_page
 * @property int $ordered_by_user_id
 * @property-read Event|null $event
 * @property-read User|null $orderedBy
 * @property-read Collection<int, DinnerformOrderline> $orderlines
 * @property-read int|null $orderlines_count
 * @property-read float $regular_discount_percentage
 *
 * @method static DinnerformFactory factory($count = null, $state = [])
 * @method static Builder<static>|Dinnerform newModelQuery()
 * @method static Builder<static>|Dinnerform newQuery()
 * @method static Builder<static>|Dinnerform query()
 * @method static Builder<static>|Dinnerform whereClosed($value)
 * @method static Builder<static>|Dinnerform whereCreatedAt($value)
 * @method static Builder<static>|Dinnerform whereDescription($value)
 * @method static Builder<static>|Dinnerform whereEnd($value)
 * @method static Builder<static>|Dinnerform whereEventId($value)
 * @method static Builder<static>|Dinnerform whereHelperDiscount($value)
 * @method static Builder<static>|Dinnerform whereId($value)
 * @method static Builder<static>|Dinnerform whereOrderedByUserId($value)
 * @method static Builder<static>|Dinnerform whereRegularDiscount($value)
 * @method static Builder<static>|Dinnerform whereRestaurant($value)
 * @method static Builder<static>|Dinnerform whereStart($value)
 * @method static Builder<static>|Dinnerform whereUpdatedAt($value)
 * @method static Builder<static>|Dinnerform whereUrl($value)
 * @method static Builder<static>|Dinnerform whereVisibleHomePage($value)
 *
 * @mixin \Eloquent
 */
class Dinnerform extends Model
{
    /** @use HasFactory<DinnerformFactory>*/
    use HasFactory;

    protected $table = 'dinnerforms';

    protected $guarded = ['id'];

    protected $hidden = ['created_at', 'updated_at'];

    protected $casts = [
        'closed' => 'boolean',
        'visible_home_page' => 'boolean',
    ];

    /**
     * @return BelongsTo<Event, $this> */
    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class);
    }

    /**
     * @return BelongsTo<User, $this>
     */
    public function orderedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'ordered_by_user_id');
    }

    /**
     * @return HasMany<DinnerformOrderline, $this> */
    public function orderlines(): HasMany
    {
        return $this->hasMany(DinnerformOrderline::class);
    }

    /**
     * @return Attribute<float, never> The regular discount as a percentage out of 100.
     */
    protected function regularDiscountPercentage(): Attribute
    {
        return Attribute::make(get: fn (): float => 100 - ($this->regular_discount * 100));
    }

    /** @return string A timespan string with format 'D H:i'. */
    public function generateTimespanText(): string
    {
        return $this->start->format('D H:i').' - '.Carbon::parse($this->end)->format('D H:i');
    }

    /** @return bool Whether the dinnerform is currently open. */
    public function isCurrent(): bool
    {
        return $this->start->isPast() && $this->end->isFuture();
    }

    /** @return bool Whether the dinnerform is more than 1 hour past it's end time. */
    public function hasExpired(): bool
    {
        return $this->end->addHour()->isPast();
    }

    /** @return float Total amount of dinnerform orders without discounts. */
    public function totalAmount(): mixed
    {
        return $this->orderlines()->sum('price');
    }

    /** @return float Total amount of orderlines reduced by discounts. */
    public function totalAmountWithDiscount(): float
    {
        return $this->orderlines()->with('dinnerform')->get()
            ->sum(static fn (DinnerformOrderline $orderline) => $orderline->price_with_discount);
    }

    /** @return int Number of orders. */
    public function orderCount(): int
    {
        return $this->orderlines()->count();
    }

    /** @return int Number of helpers. */
    public function helperCount(): int
    {
        return $this->orderlines()->where('helper', true)->distinct('user_id')->count();
    }

    /** @return bool Whether the current user is a helper for the event related to the dinnerform or has marked themselves as a helper. */
    public function isHelping(): bool
    {
        if ($this->orderlines()->where('user_id', Auth::id())->where('helper', true)->exists()) {
            return true;
        }

        return $this->event?->activity && $this->event->activity->isHelping(Auth::user());
    }

    /** @return bool Whether the current user has any discounts. */
    public function hasDiscount(): bool
    {
        return $this->regular_discount_percentage || ($this->helper_discount && $this->isHelping());
    }

    /** @return bool Whether the current user has made an order yet. */
    public function hasOrdered(): bool
    {
        return $this->orderlines()->where('user_id', Auth::id())->exists();
    }

    /** Delete related orders with dinnerform. */
    #[Override]
    protected static function boot(): void
    {
        parent::boot();
        static::deleting(static function ($dinnerform) {
            foreach ($dinnerform->orderlines()->get() as $orderline) {
                $orderline->delete();
            }
        });
    }

    #[Override]
    protected function casts(): array
    {
        return [
            'start' => 'datetime',
            'end' => 'datetime',
        ];
    }
}
