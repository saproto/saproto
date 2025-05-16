<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * DmxFixture Model.
 *
 * @property int $id
 * @property string $name
 * @property int $channel_start
 * @property int $channel_end
 * @property int $follow_timetable
 *
 * @method static Builder<static>|DmxFixture newModelQuery()
 * @method static Builder<static>|DmxFixture newQuery()
 * @method static Builder<static>|DmxFixture query()
 * @method static Builder<static>|DmxFixture whereChannelEnd($value)
 * @method static Builder<static>|DmxFixture whereChannelStart($value)
 * @method static Builder<static>|DmxFixture whereFollowTimetable($value)
 * @method static Builder<static>|DmxFixture whereId($value)
 * @method static Builder<static>|DmxFixture whereName($value)
 *
 * @mixin \Eloquent
 */
class DmxFixture extends Model
{
    protected $table = 'dmx_fixtures';

    protected $guarded = ['id'];

    public $timestamps = false;

    /**
     * @return Collection<int, DmxChannel>|DmxChannel[]
     */
    public function getChannels(?string $special_func = null): Collection|array
    {
        $channels = DmxChannel::query()->where('id', '>=', $this->channel_start)
            ->where('id', '<=', $this->channel_end);

        if ($special_func !== null && $special_func !== '' && $special_func !== '0') {
            $channels = $channels->where('special_function', $special_func);
        }

        return $channels->orderBy('id', 'asc')->get();
    }

    /** @return int[] */
    public function getChannelNumbers(): array
    {
        return range($this->channel_start, $this->channel_end);
    }
}
