<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;

/**
 * Ticket Model.
 *
 * @property int $id
 * @property int $event_id
 * @property int $product_id
 * @property int $available_from
 * @property int $available_to
 * @property int $buy_limit
 * @property bool $members_only
 * @property bool $is_prepaid
 * @property bool $show_participants
 * @property bool $has_buy_limit
 * @property-read Event $event
 * @property-read Product $product
 * @property-read Collection<int, TicketPurchase> $purchases
 *
 * @method static Builder|Ticket whereAvailableFrom($value)
 * @method static Builder|Ticket whereAvailableTo($value)
 * @method static Builder|Ticket whereEventId($value)
 * @method static Builder|Ticket whereId($value)
 * @method static Builder|Ticket whereIsPrepaid($value)
 * @method static Builder|Ticket whereMembersOnly($value)
 * @method static Builder|Ticket whereProductId($value)
 * @method static Builder|Ticket newModelQuery()
 * @method static Builder|Ticket newQuery()
 * @method static Builder|Ticket query()
 *
 * @mixin Model
 */
class Ticket extends Model
{
    protected $table = 'tickets';

    protected $guarded = ['id'];

    public $timestamps = false;

    /**
     * @return BelongsTo<Product, $this>
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * @return BelongsTo<Event, $this>
     */
    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class);
    }

    /**
     * @return HasMany<TicketPurchase, $this>
     */
    public function purchases(): HasMany
    {
        return $this->hasMany(TicketPurchase::class);
    }

    /** @return Collection<int, User> */
    public function getUsers(): Collection
    {
        return User::query()->whereHas('tickets', function ($query) {
            $query->where('ticket_id', $this->id);
        })->get();
    }

    public function totalAvailable(): int
    {
        return $this->sold() + $this->product->stock;
    }

    public function sold(): int
    {
        return $this->purchases->count();
    }

    public function canBeSoldTo(User $user): bool
    {
        return ($user->is_member || ! $this->members_only) && ! $this->buyLimitReached($user);
    }

    public function buyLimitReached(User $user): bool
    {
        return $this->has_buy_limit && $this->buyLimitForUser($user) <= 0;
    }

    public function buyLimitForUser(User $user): int|float
    {
        return $this->buy_limit - $this->purchases->where('user_id', $user->id)->count();
    }

    public function isOnSale(): bool
    {
        return Carbon::now()->format('U') > $this->available_from && Carbon::now()->format('U') < $this->available_to;
    }

    public function isAvailable(User $user): bool
    {
        return $this->isOnSale() && $this->canBeSoldTo($user) && $this->product->stock > 0;
    }

    public function turnover(): int|float
    {
        return OrderLine::query()->whereHas('ticketPurchase', function ($query) {
            $query->where('ticket_id', $this->id);
        })->sum('total_price');
    }
}
