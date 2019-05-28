<?php

namespace Proto\Models;

use Illuminate\Database\Eloquent\Model;

class DmxOverride extends Model
{
    protected $table = 'dmx_overrides';
    protected $fillable = ['fixtures', 'color', 'start', 'end'];
    public $timestamps = false;

    public static function getActiveSorted()
    {
        return DmxOverride::where('start', '<', date('U'))->where('end', '>', date('U'))->get()->sortBy('window_size');

    }

    public static function getUpcomingSorted()
    {
        return DmxOverride::where('start', '>', date('U'))->get()->sortByDesc('start');

    }

    public static function getPastSorted()
    {
        return DmxOverride::where('end', '<', date('U'))->get()->sortByDesc('start');

    }

    public function colorArray()
    {
        return array_map('intval', explode(',', $this->color));
    }

    public function red()
    {
        return $this->colorArray()[0];
    }

    public function green()
    {
        return $this->colorArray()[1];
    }

    public function blue()
    {
        return $this->colorArray()[2];
    }

    public function brightness()
    {
        return $this->colorArray()[3];
    }

    public function active()
    {
        return $this->start < date('U') && date('U') < $this->end;
    }

    public function justOver()
    {
        return date('U') > $this->end && date('U') < $this->end + 600;
    }

    public function getFixtureIds()
    {
        return explode(',', $this->fixtures);
    }

    public function getFixtures()
    {
        return DmxFixture::whereIn('id', $this->getFixtureIds())->get();
    }

    public function getIsActiveAttribute()
    {
        return $this->active();
    }

    public function getWindowSizeAttribute()
    {
        return $this->end - $this->start;
    }
}