<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;

/**
 * DmxOverride Model.
 *
 * @property int $id
 * @property string $fixtures
 * @property string $color
 * @property string $start
 * @property string $end
 * @property-read bool $is_active
 * @property-read string $window_size
 *
 * @method static Builder|DmxOverride whereColor($value)
 * @method static Builder|DmxOverride whereEnd($value)
 * @method static Builder|DmxOverride whereFixtures($value)
 * @method static Builder|DmxOverride whereId($value)
 * @method static Builder|DmxOverride whereStart($value)
 * @method static Builder|DmxOverride newModelQuery()
 * @method static Builder|DmxOverride newQuery()
 * @method static Builder|DmxOverride query()
 *
 * @mixin Model
 */
class DmxOverride extends Model
{
    protected $table = 'dmx_overrides';

    protected $guarded = ['id'];

    public $timestamps = false;

    /** @return Collection|DmxOverride[] */
    public static function getActiveSorted()
    {
        return self::query()->where('start', '<', Carbon::now()->format('U'))->where('end', '>', Carbon::now()->format('U'))->get()->sortBy('window_size');
    }

    /** @return Collection|DmxOverride[] */
    public static function getUpcomingSorted()
    {
        return self::query()->where('start', '>', Carbon::now()->format('U'))->get()->sortByDesc('start');
    }

    /** @return Collection|DmxOverride[] */
    public static function getPastSorted()
    {
        return self::query()->where('end', '<', Carbon::now()->format('U'))->get()->sortByDesc('start');
    }

    /** @return array<int, int> */
    public function colorArray(): array
    {
        return array_map(intval(...), explode(',', $this->color));
    }

    /** @return int */
    public function red()
    {
        return $this->colorArray()[0];
    }

    /** @return int */
    public function green()
    {
        return $this->colorArray()[1];
    }

    /** @return int */
    public function blue()
    {
        return $this->colorArray()[2];
    }

    /** @return int */
    public function brightness()
    {
        return $this->colorArray()[3];
    }

    public function active(): bool
    {
        return $this->start < Carbon::now()->format('U') && Carbon::now()->format('U') < $this->end;
    }

    public function justOver(): bool
    {
        return Carbon::now()->format('U') > $this->end && Carbon::now()->format('U') < $this->end. 600;
    }

    public function getFixtureIds(): array
    {
        return explode(',', $this->fixtures);
    }

    /** @return Collection */
    public function getFixtures()
    {
        return DmxFixture::query()->whereIn('id', $this->getFixtureIds())->get();
    }

    protected function isActive(): Attribute
    {
        return Attribute::make(get: fn (): bool => $this->active());
    }

    protected function windowSize(): Attribute
    {
        return Attribute::make(get: fn (): int => (int) $this->end - (int) $this->start);
    }
}
