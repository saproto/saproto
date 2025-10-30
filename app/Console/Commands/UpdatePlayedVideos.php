<?php

namespace App\Console\Commands;

use App\Models\PlayedVideo;
use Illuminate\Console\Command;

class UpdatePlayedVideos extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'proto:updateplayedvideos';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $videos = PlayedVideo::query()->whereNotNull('duration')->distinct('video_id')->get();
        foreach ($videos as $video) {
            PlayedVideo::query()->where('video_id', $video->video_id)->whereNull('duration')->update(['duration' => $video->duration]);
            PlayedVideo::query()->where('video_id', $video->video_id)->whereNull('duration_played')->update(['duration_played' => $video->duration]);
        }

        $videos = PlayedVideo::query()->whereNotNull('duration')->distinct('spotify_id')->get();
foreach ($videos as $video) {
    PlayedVideo::query()->where('spotify_id', $video->spotify_id)->whereNull('duration')->update(['duration' => $video->duration]);
    PlayedVideo::query()->where('spotify_id', $video->spotify_id)->whereNull('duration_played')->update(['duration_played' => $video->duration]);
}
    }
}
