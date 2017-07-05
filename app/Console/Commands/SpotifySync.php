<?php

namespace Proto\Console\Commands;

use Illuminate\Console\Command;

use Proto\Http\Controllers\SpotifyController;
use Proto\Http\Controllers\SlackController;

use DB;

class SpotifySync extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'proto:spotifysync';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sync Spotify playlist etc.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {

        $spotify = SpotifyController::getApi();
        $session = SpotifyController::getSession();


        $this->info('Testing if API key still works.');

        try {
            if ($spotify->me()->id != getenv('SPOTIFY_USER')) {
                $this->error('API key is for the wrong user!');
                SlackController::sendNotification('[console *proto:spotify*] API key is for the wrong user.');
                return;
            }
        } catch (\SpotifyWebAPI\SpotifyWebAPIException $e) {
            if ($e->getMessage() == "The access token expired") {

                $this->info('Access token expired. Trying to renew.');

                $refreshToken = $session->getRefreshToken();
                $session->refreshAccessToken($refreshToken);
                $accessToken = $session->getAccessToken();
                $spotify->setAccessToken($accessToken);

                SpotifyController::setSession($session);
                SpotifyController::setApi($spotify);

            } else {
                $this->error('Error using API key.');
                SlackController::sendNotification('[console *proto:spotify*] Error using API key, please investigate.');
                return;
            }
        }

        $this->info('Constructing ProTube hitlist.');

        $videos = [];

        // All-time
        $videos = array_merge($videos, DB::table('playedvideos')
            ->select(DB::raw('video_title, count(*) as count'))
            ->groupBy('video_title')->orderBy('count', 'desc')->limit(50)->get());

        // Last month
        $videos = array_merge($videos, DB::table('playedvideos')
            ->select(DB::raw('video_title, count(*) as count'))
            ->where('created_at', '>', date('Y-m-d', strtotime('-1 month')))
            ->groupBy('video_title')->orderBy('count', 'desc')->limit(50)->get());

        // Last week
        $videos = array_merge($videos, DB::table('playedvideos')
            ->select(DB::raw('video_title, count(*) as count'))
            ->where('created_at', '>', date('Y-m-d', strtotime('-1 week')))
            ->groupBy('video_title')->orderBy('count', 'desc')->limit(50)->get());

        $titles = [];

        $strip = [
            "  ", "-", "official", "video", "original", "optional", "subs", "feat", "ft.", "tekst", "ondertiteld", " music", " hd", " lyrics", " lyric", " sing", " along", " audio"
        ];
        $replace = [
            " ", " ", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", ""
        ];

        foreach ($videos as $video) {
            if (!in_array($video->video_title, array_keys($titles))) {
                $titles[$video->video_title] = (object)[
                    'title' => $video->video_title,
                    'title_formatted' => preg_replace('/(\(.*|[^a-z0-9\s])/', '',
                        str_replace($strip, $replace, strtolower($video->video_title))
                    ),
                    'count' => $video->count
                ];
            }
        }

        $this->info("Matching to Spotify music.\n---");

        $new_songs = [];

        foreach ($titles as $t => $title) {

            try {

                $song = $spotify->search($title->title_formatted, 'track', ['limit' => 1])->tracks->items;
                if (count($song) < 1) {
                    $this->error("Could not match < $title->title | $title->title_formatted > to a Spotify track.");
                } else {
                    $new_songs[] = $song[0]->uri;
                }

            } catch (\SpotifyWebAPI\SpotifyWebAPIException $e) {

                $this->error('Error during track search.');
                SlackController::sendNotification('[console *proto:spotify*] Exception during track search. Please investigate.');

            }
        }

        $new_songs = array_unique($new_songs);

        $this->info("---");

        $this->info("Composing playlist. ");

        $current_songs = [];

        try {

            foreach ($spotify->getUserPlaylistTracks(getenv("SPOTIFY_USER"), getenv("SPOTIFY_PLAYLIST"), ['fields' => 'items.track.uri'])->items as $s) {
                $current_songs[] = $s->track->uri;
            }

        } catch (\SpotifyWebAPI\SpotifyWebAPIException $e) {

            $this->error('Error during playlist check.');
            SlackController::sendNotification('[console *proto:spotify*] Exception during playlist check. Please investigate.');

        }

        $delete_songs = array_values(array_diff($current_songs, $new_songs));
        $add_songs = array_values(array_diff($new_songs, $current_songs));

        $this->info("Deleting " . count($delete_songs) . " songs.");

        try {

            $arr = [];
            foreach ($delete_songs as $i => $s) {
                $arr[] = (object)[
                    'id' => $s
                ];
            }

            $spotify->deleteUserPlaylistTracks(getenv("SPOTIFY_USER"), getenv("SPOTIFY_PLAYLIST"), $arr);

        } catch (\SpotifyWebAPI\SpotifyWebAPIException $e) {

            $this->error('Error during playlist update (delete old songs).');
            SlackController::sendNotification('[console *proto:spotify*] Exception during playlist update (delete old songs). Please investigate.');

        }

        $this->info("Adding " . count($add_songs) . " songs.");

        try {

            $spotify->addUserPlaylistTracks(getenv("SPOTIFY_USER"), getenv("SPOTIFY_PLAYLIST"), $add_songs);

        } catch (\SpotifyWebAPI\SpotifyWebAPIException $e) {

            $this->error('Error during playlist update (add new songs).');
            SlackController::sendNotification('[console *proto:spotify*] Exception during playlist update (add new songs). Please investigate.');

        }

        $this->info("Done!");

    }
}
