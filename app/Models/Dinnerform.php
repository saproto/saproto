<?php

namespace Proto\Models;

use Carbon;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

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
 * @method static Builder|Dinnerform whereCreatedAt($value)
 * @method static Builder|Dinnerform whereDescription($value)
 * @method static Builder|Dinnerform whereEnd($value)
 * @method static Builder|Dinnerform whereId($value)
 * @method static Builder|Dinnerform whereRestaurant($value)
 * @method static Builder|Dinnerform whereStart($value)
 * @method static Builder|Dinnerform whereUpdatedAt($value)
 * @method static Builder|Dinnerform whereUrl($value)
 * @method static Builder|Dinnerform newModelQuery()
 * @method static Builder|Dinnerform newQuery()
 * @method static Builder|Dinnerform query()
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
}
