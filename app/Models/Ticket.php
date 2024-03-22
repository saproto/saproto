<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
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
 * @property string $redirect_url
 * @property-read Event $event
 * @property-read Product $product
 * @property-read Collection|TicketPurchase[] $purchases
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
 * @mixin Eloquent
 */
class Ticket extends Model
{
    protected $table = 'tickets';

    protected $guarded = ['id'];

    public $timestamps = false;

    /** @return BelongsTo */
    public function product()
    {
        return $this->belongsTo(\App\Models\Product::class);
    }

    /** @return BelongsTo */
    public function event()
    {
        return $this->belongsTo(\App\Models\Event::class);
    }

    /** @return HasMany */
    public function purchases()
    {
        return $this->hasMany(\App\Models\TicketPurchase::class);
    }

    /** @return Collection */
    public function getUsers()
    {
        return User::whereHas('tickets', function ($query) {
            $query->where('ticket_id', $this->id);
        })->get();
    }

    /** @return int */
    public function totalAvailable()
    {
        return $this->sold() + $this->product->stock;
    }

    /** @return int */
    public function sold()
    {
        return $this->purchases->count();
    }

    /**
     * @return bool
     */
    public function canBeSoldTo(User $user)
    {
        return ($user->is_member || ! $this->members_only) && ! $this->buyLimitReached($user);
    }

    /**
     * @return bool
     */
    public function buyLimitReached(User $user)
    {
        return $this->has_buy_limit && $this->buyLimitForUser($user) <= 0;
    }

    /**
     * @return int
     */
    public function buyLimitForUser(User $user)
    {
        return $this->buy_limit - $this->purchases->where('user_id', $user->id)->count();
    }

    /** @return bool */
    public function isOnSale()
    {
        return date('U') > $this->available_from && date('U') < $this->available_to;
    }

    public function isAvailable(User $user): bool
    {
        return $this->isOnSale() && $this->canBeSoldTo($user) && $this->product->stock > 0;
    }

    /** @return float|int */
    public function turnover()
    {
        $total = 0;
        foreach ($this->purchases as $purchase) {
            $total += $purchase->orderline->total_price;
        }

        return $total;
    }
}
