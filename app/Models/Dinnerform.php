<?php

namespace Proto\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\URL;
use Vinkla\Hashids\Facades\Hashids;

use Auth;

class Dinnerform extends Model
{

    protected $hidden = ['created_at', 'updated_at'];

    protected $dates = ['start', 'end'];

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'dinnerforms';

    public function getPublicId()
    {
        return Hashids::connection('dinnerform')->encode($this->id);
    }

    public static function fromPublicId($public_id)
    {
        $id = Hashids::connection('dinnerform')->decode($public_id);
        return Dinnerform::findOrFail(count($id) > 0 ? $id[0] : 0);
    }

    public function generateTimespanText()
    {
        return $this->start->format('D H:i') . " - " . Carbon::parse($this->end)->format('D H:i');
    }

    protected $guarded = ['id'];

    public function isCurrent() {
        return $this->start->isPast() && $this->end->isFuture();
    }

    public function hasExpired() {
        return $this->end->addHours(1)->isPast();
    }

}
