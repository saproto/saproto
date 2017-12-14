<?php

namespace Proto\Models;

use Illuminate\Database\Eloquent\Model;

class PlayedVideo extends Model
{
    protected $table = 'playedvideos';

    public function user()
    {
        return $this->belongsTo('Proto\Models\User');
    }

    static public function generateYoutubeThumbnail($youtube_id)
    {
        return "https://img.youtube.com/vi/$youtube_id/mqdefault.jpg";
    }

    static public function generateSpotifyUri($spotify_id)
    {
        $spotify_id = str_replace("spotify:track:", "", $spotify_id);
        return "https://open.spotify.com/track/$spotify_id";
    }

    static public function generateYoutubeUrl($youtube_id)
    {
        return "https://www.youtube.com/watch?v=$youtube_id";
    }
}
