<?php

namespace Proto\Models;

use Illuminate\Database\Eloquent\Model;
use DateInterval;

use Youtube;
use Exception;

class NarrowcastingItem extends Model
{
    protected $table = 'narrowcasting';

    /**
     * @return mixed The image associated with this item..
     */
    public function image()
    {
        return $this->belongsTo('Proto\Models\StorageEntry');
    }

    public function video()
    {
        if ($this->youtube_id !== null) {
            try {
                return Youtube::getVideoInfo($this->youtube_id);
            } catch (Exception $e) {
                return null;
            }
        }
        return null;
    }

    public function videoDuration()
    {
        if ($this->youtube_id) {
            return date_create('@0')->add(new DateInterval($this->video()->contentDetails->duration))->getTimestamp();
        } else {
            return 0;
        }
    }

    protected $guarded = ['id'];
}
