<?php

namespace Proto\Models;

use Illuminate\Database\Eloquent\Model;

class DmxFixture extends Model
{
    protected $table = 'dmx_fixtures';
    protected $guarded = ['id'];
    public $timestamps = false;

    public function getChannels($special_func = null)
    {
        $query = DmxChannel::where('id', '>=', $this->channel_start)
            ->where('id', '<=', $this->channel_end);

        if ($special_func) {
            $query = $query->where('special_function', $special_func);
        }

        return $query->orderBy('id', 'asc')->get();
    }

    public function getChannelNumbers()
    {
        return range($this->channel_start, $this->channel_end);
    }
}
