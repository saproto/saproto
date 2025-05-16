<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * Ticket Purchase Model.
 *
 * @property int $id
 * @property int $ticket_id
 * @property int $orderline_id
 * @property int $user_id
 * @property string $barcode
 * @property bool $payment_complete
 * @property string|null $scanned
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read mixed $api_attributes
 * @property-read OrderLine $orderline
 * @property-read Ticket $ticket
 * @property-read User $user
 *
 * @method static Builder|TicketPurchase whereBarcode($value)
 * @method static Builder|TicketPurchase whereCreatedAt($value)
 * @method static Builder|TicketPurchase whereId($value)
 * @method static Builder|TicketPurchase whereOrderlineId($value)
 * @method static Builder|TicketPurchase wherePaymentComplete($value)
 * @method static Builder|TicketPurchase whereScanned($value)
 * @method static Builder|TicketPurchase whereTicketId($value)
 * @method static Builder|TicketPurchase whereUpdatedAt($value)
 * @method static Builder|TicketPurchase whereUserId($value)
 * @method static Builder|TicketPurchase newModelQuery()
 * @method static Builder|TicketPurchase newQuery()
 * @method static Builder|TicketPurchase query()
 *
 * @mixin Model
 * @mixin \Eloquent
 */
class TicketPurchase extends Model
{
    protected $table = 'ticket_purchases';

    protected $guarded = ['id'];

    /**
     * @return BelongsTo<Ticket, $this>
     */
    public function ticket(): BelongsTo
    {
        return $this->belongsTo(Ticket::class, 'ticket_id');
    }

    /**
     * @return BelongsTo<OrderLine, $this>
     */
    public function orderline(): BelongsTo
    {
        return $this->belongsTo(OrderLine::class, 'orderline_id');
    }

    /**
     * @return BelongsTo<User, $this>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id')->withTrashed();
    }

    public function canBeDownloaded(): bool
    {
        return
            (! $this->ticket->is_prepaid) ||
            ($this->orderline->isPayed() && $this->orderline->payed_with_mollie === null) ||
            ($this->orderline->molliePayment?->translatedStatus() == 'paid');
    }
}
