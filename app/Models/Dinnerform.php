<?php

namespace Proto\Models;

use Carbon;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Dinnerform Model.
 *
 * @property int $id
 * @property string $restaurant
 * @property string $description
 * @property string $url
 * @property boolean $closed
 * @property Carbon $start
 * @property Carbon $end
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Event $event
 * @method static Builder|Dinnerform whereCreatedAt($value)
 * @method static Builder|Dinnerform whereDescription($value)
 * @method static Builder|Dinnerform whereEnd($value)
 * @method static Builder|Dinnerform whereId($value)
 * @method static Builder|Dinnerform whereRestaurant($value)
 * @method static Builder|Dinnerform whereStart($value)
 * @method static Builder|Dinnerform whereUpdatedAt($value)
 * @method static Builder|Dinnerform whereUrl($value)
 * @mixin Eloquent
 */
class Dinnerform extends Model
{
    protected $table = 'dinnerforms';

    protected $guarded = ['id'];

    protected $hidden = ['created_at', 'updated_at'];

    protected $dates = ['start', 'end'];

    /**
     * @return string A timespan string with format 'D H:i'.
     */
    public function generateTimespanText()
    {
        return $this->start->format('D H:i').' - '.Carbon::parse($this->end)->format('D H:i');
    }

    /** @return bool Whether the dinnerform is currently open */
    public function isCurrent()
    {
        return $this->start->isPast() && $this->end->isFuture();
    }

    /** @return bool Whether the dinnerform is more than 1 hour past it's end time. */
    public function hasExpired()
    {
        return $this->end->addHours(1)->isPast();
    }

    /** @return HasMany|DinnerformOrderline[] */
    public function orderLines()
    {
        return $this->hasMany('Proto\Models\DinnerformOrderline');
    }

    /** @return BelongsTo */
    public function event()
    {
        return $this->belongsTo('Proto\Models\Event', 'event_id');
    }

    public function totalAmount() {
        return $this->orderlines()->sum('price');
    }

    public function totalAmountwithHelperDiscount() {
        if($this->discount) {
            $total = 0;
            foreach($this->orderlines()->get() as $dinnerOrderline){
                $total += $dinnerOrderline->price();
            }
            return $total;
        }else{
         return $this->totalAmount();
        }
    }

    public function amountOfOrders() {
        return $this->orderlines()->count();
    }

    public function amountOfHelpers() {
        return $this->orderlines()->where('helper', true)->distinct('user_id')->count();
    }

    public static function boot()
    {
        parent::boot();
        static::deleting(function ($dinnerform) {
          foreach($dinnerform->orderLines()->get() as $dinnerOrderline){
             $dinnerOrderline->delete();
          }
        });
        }
}
