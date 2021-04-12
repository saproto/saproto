<?php

namespace Proto\Models;

use Carbon;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Ticket Purchase Model
 *
 * @property int $id
 * @property int $ticket_id
 * @property int $orderline_id
 * @property int $user_id
 * @property string $barcode
 * @property string|null $scanned
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property int $payment_complete
 * @property-read mixed $api_attributes
 * @property-read OrderLine $orderline
 * @property-read Ticket $ticket
 * @property-read User $user
 * @method static Builder|TicketPurchase whereBarcode($value)
 * @method static Builder|TicketPurchase whereCreatedAt($value)
 * @method static Builder|TicketPurchase whereId($value)
 * @method static Builder|TicketPurchase whereOrderlineId($value)
 * @method static Builder|TicketPurchase wherePaymentComplete($value)
 * @method static Builder|TicketPurchase whereScanned($value)
 * @method static Builder|TicketPurchase whereTicketId($value)
 * @method static Builder|TicketPurchase whereUpdatedAt($value)
 * @method static Builder|TicketPurchase whereUserId($value)
 * @mixin Eloquent
 */
class TicketPurchase extends Model
{

    protected $table = 'ticket_purchases';

    protected $guarded = ['id'];

    /** @return BelongsTo|Ticket */
    public function ticket()
    {
        return $this->belongsTo('Proto\Models\Ticket', 'ticket_id');
    }

    /** @return BelongsTo|OrderLine */
    public function orderline()
    {
        return $this->belongsTo('Proto\Models\OrderLine', 'orderline_id');
    }

    /** @return BelongsTo|User */
    public function user()
    {
        return $this->belongsTo('Proto\Models\User', 'user_id')->withTrashed();
    }

    /** @return bool*/
    public function canBeDownloaded()
    {
        return
            (!$this->ticket->is_prepaid) ||
            ($this->orderline->isPayed() && $this->orderline->payed_with_mollie === null) ||
            ($this->orderline->molliePayment && $this->orderline->molliePayment->translatedStatus() == 'paid');
    }

    /** @return array */
    public function getApiAttributesAttribute()
    {
        return [
            'id' => $this->id,
            'barcode' => $this->canBeDownloaded() ? $this->barcode : null,
            'scanned' => $this->scanned
        ];
    }

}
