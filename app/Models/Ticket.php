<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Date;
use Override;

/**
 * Ticket Model.
 *
 * @property int $id
 * @property int $event_id
 * @property int $product_id
 * @property bool $members_only
 * @property int $available_from
 * @property int $available_to
 * @property bool $is_prepaid
 * @property bool $show_participants
 * @property bool $has_buy_limit
 * @property int $buy_limit
 * @property-read Event|null $event
 * @property-read Product|null $product
 * @property-read \Illuminate\Database\Eloquent\Collection<int, TicketPurchase> $purchases
 * @property-read int|null $purchases_count
 *
 * @method static Builder<static>|Ticket newModelQuery()
 * @method static Builder<static>|Ticket newQuery()
 * @method static Builder<static>|Ticket query()
 * @method static Builder<static>|Ticket whereAvailableFrom($value)
 * @method static Builder<static>|Ticket whereAvailableTo($value)
 * @method static Builder<static>|Ticket whereBuyLimit($value)
 * @method static Builder<static>|Ticket whereEventId($value)
 * @method static Builder<static>|Ticket whereHasBuyLimit($value)
 * @method static Builder<static>|Ticket whereId($value)
 * @method static Builder<static>|Ticket whereIsPrepaid($value)
 * @method static Builder<static>|Ticket whereMembersOnly($value)
 * @method static Builder<static>|Ticket whereProductId($value)
 * @method static Builder<static>|Ticket whereShowParticipants($value)
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
        return $this->hasMany(TicketPurchase::class)->chaperone('ticket');
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
        return Date::now()->timestamp > $this->available_from && Date::now()->timestamp < $this->available_to;
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

    #[Override]
    protected function casts(): array
    {
        return [
            'members_only' => 'boolean',
            'is_prepaid' => 'boolean',
            'show_participants' => 'boolean',
            'has_buy_limit' => 'boolean',
        ];
    }

    #[Override]
    protected static function boot(): void
    {
        parent::boot();

        static::saved(function (Ticket $ticket) {
            Cache::forget('home.events');
        });
    }
}
