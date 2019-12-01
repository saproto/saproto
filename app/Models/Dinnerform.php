<?php

namespace Proto\Models;

use DateTime;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use Vinkla\Hashids\Facades\Hashids;

use Auth;

class Dinnerform extends Model
{
    protected $hidden = ['created_at', 'updated_at'];

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'dinnerforms';

    protected $appends = ['is_future', 'formatted_date'];

    public function getPublicId()
    {
        return Hashids::connection('dinnerform')->encode($this->id);
    }

    public static function fromPublicId($public_id)
    {
        $id = Hashids::connection('dinnerform')->decode($public_id);
        return Dinnerform::findOrFail(count($id) > 0 ? $id[0] : 0);
    }

    public function generateTimespanText($long_format, $short_format, $combiner)
    {
        return date($long_format, $this->start) . " " . $combiner . " " . (
            (($this->end - $this->start) < 3600 * 24)
                ?
                date($short_format, $this->end)
                :
                date($long_format, $this->end)
            );
    }

    protected $guarded = ['id'];

    public function hasEnded()
    {
        return date('U') - $this->end > 3600;
    }

    public function getIsFutureAttribute()
    {
        return date('U') < $this->start;
    }

    public function getFormattedDateAttribute()
    {
        return (object)[
            'simple' => date('M d, Y', $this->start),
            'year' => date('Y', $this->start),
            'month' => date('M Y', $this->start),
            'time' => date('H:i', $this->start)
        ];
    }

}
