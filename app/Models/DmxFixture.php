<?php

namespace Proto\Models;

use Illuminate\Database\Eloquent\Model;

class DmxFixture extends Model
{
    protected $table = 'dmx_fixtures';
    protected $guarded = ['id'];
    public $timestamps = false;

    public function getChannelNames()
    {
        $channels = [];
        foreach ($this->getChannelNumbers() as $channel) {
            $channels[$channel] = 'Unnamed Channel';
        }

        $channel_names = DmxChannel::whereIn('id', array_keys($channels))->get();

        foreach ($channel_names as $channel) {
            $channels[$channel->id] = $channel->name;
        }

        return $channels;
    }

    public function getChannelNumbers()
    {
        return range($this->channel_start, $this->channel_end);
    }
}
