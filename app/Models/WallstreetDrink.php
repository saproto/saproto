<?php

namespace Proto\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


/**
 * Class WallstreetDrink
 * @property integer end_time
 * @property integer start_time
 * @property string name
 **/

class WallstreetDrink extends Model
{
    use HasFactory;
    protected $table = 'wallstreet_drink';
    protected $fillable = ['end_time', 'start_time', 'name'];

    public function current(): bool
    {
        $now = \Carbon::now()->timestamp;
        return $now >= $this->start_time && $now <= $this->end_time;
    }
}
