<?php

namespace Proto\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Dinnerform extends Model
{

    protected $hidden = ['created_at', 'updated_at'];

    protected $dates = ['start', 'end'];

    protected $guarded = ['id'];

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'dinnerforms';

    /**
     * Generate a timespan string with format 'D H:i'.
     *
     * @return string
     */
    public function generateTimespanText()
    {
        return $this->start->format('D H:i') . " - " . Carbon::parse($this->end)->format('D H:i');
    }

    /**
     * Check if a dinnerform is currently open.
     *
     * @return bool
     */
    public function isCurrent() {
        return $this->start->isPast() && $this->end->isFuture();
    }

    /**
     * Check if dinnerform is more than 1 hour past end time.
     *
     * @return bool
     */
    public function hasExpired() {
        return $this->end->addHours(1)->isPast();
    }

}
