<?php

namespace Proto\Models;

use Illuminate\Database\Eloquent\Model;

use DateInterval;

class Video extends Model
{
    protected $table = 'videos';
    public $timestamps = false;
    protected $guarded = ['id'];

    public function getYouTubeUrl()
    {
        return sprintf("https://www.youtube.com/watch?v=%s", $this->youtube_id);
    }

    public function getYouTubeChannelUrl()
    {
        return sprintf("https://www.youtube.com/channel/%s", $this->youtube_user_id);
    }

    public function getYouTubeEmbedUrl()
    {
        return sprintf("https://www.youtube.com/embed/%s?rel=0", $this->youtube_id);
    }

    public function getHumanDuration()
    {
        $interval = new DateInterval($this->youtube_length);
        if ($interval->y > 0) {
            return sprintf("%s years", $interval->y);
        } elseif ($interval->m > 0) {
            return sprintf("%s months", $interval->m);
        } elseif ($interval->d > 0) {
            return sprintf("%s days", $interval->d);
        } elseif ($interval->h > 0) {
            return sprintf("%s:%s:%s ", $interval->h, str_pad($interval->i, 2, "0", STR_PAD_LEFT), str_pad($interval->s, 2, "0", STR_PAD_LEFT));
        } elseif ($interval->i > 0) {
            return sprintf("%s:%s ", $interval->i, str_pad($interval->s, 2, "0", STR_PAD_LEFT));
        } else {
            return sprintf("%s seconds", $interval->s);
        }
    }

    public function getUnixTimeStamp()
    {
        return date('U', strtotime($this->video_date));
    }

    public function getFormDate()
    {
        return date('d-m-Y', strtotime($this->video_date));
    }

    public function event()
    {
        return $this->belongsTo('Proto\Models\Event', 'event_id');
    }
}
