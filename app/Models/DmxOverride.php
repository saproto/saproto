<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Date;

/**
 * DmxOverride Model.
 *
 * @property int $id
 * @property string $fixtures
 * @property string $color
 * @property string $start
 * @property string $end
 * @property-read bool $is_active
 * @property-read int $window_size
 *
 * @method static Builder<static>|DmxOverride newModelQuery()
 * @method static Builder<static>|DmxOverride newQuery()
 * @method static Builder<static>|DmxOverride query()
 * @method static Builder<static>|DmxOverride whereColor($value)
 * @method static Builder<static>|DmxOverride whereEnd($value)
 * @method static Builder<static>|DmxOverride whereFixtures($value)
 * @method static Builder<static>|DmxOverride whereId($value)
 * @method static Builder<static>|DmxOverride whereStart($value)
 *
 * @mixin \Eloquent
 */
class DmxOverride extends Model
{
    protected $table = 'dmx_overrides';

    protected $guarded = ['id'];

    public $timestamps = false;

    /** @return Collection<int, DmxOverride> */
    public static function getActiveSorted(): Collection
    {
        return self::query()->where('start', '<', Date::now()->timestamp)->where('end', '>', Date::now()->timestamp)->get()->sortBy('window_size');
    }

    /** @return Collection<int, DmxOverride> */
    public static function getUpcomingSorted(): Collection
    {
        return self::query()->where('start', '>', Date::now()->timestamp)->get()->sortByDesc('start');
    }

    /** @return Collection<int, DmxOverride> */
    public static function getPastSorted(): Collection
    {
        return self::query()->where('end', '<', Date::now()->timestamp)->get()->sortByDesc('start');
    }

    /** @return array<int, int> */
    public function colorArray(): array
    {
        return array_map(intval(...), explode(',', $this->color));
    }

    public function red(): int
    {
        return $this->colorArray()[0];
    }

    public function green(): int
    {
        return $this->colorArray()[1];
    }

    public function blue(): int
    {
        return $this->colorArray()[2];
    }

    public function brightness(): int
    {
        return $this->colorArray()[3];
    }

    public function active(): bool
    {
        return $this->start < Date::now()->timestamp && Date::now()->timestamp < $this->end;
    }

    public function justOver(): bool
    {
        return Date::now()->timestamp > $this->end && Date::now()->timestamp < $this->end. 600;
    }

    /** @return string[] */
    public function getFixtureIds(): array
    {
        return explode(',', $this->fixtures);
    }

    /** @return Collection<int, DmxFixture> */
    public function getFixtures(): Collection
    {
        return DmxFixture::query()->whereIn('id', $this->getFixtureIds())->get();
    }

    /**
     * @return Attribute<bool, never>
     */
    protected function isActive(): Attribute
    {
        return Attribute::make(get: fn (): bool => $this->active());
    }

    /**
     * @return Attribute<int, never>
     */
    protected function windowSize(): Attribute
    {
        return Attribute::make(get: fn (): int => (int) $this->end - (int) $this->start);
    }
}
