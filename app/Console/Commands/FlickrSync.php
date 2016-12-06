<?php

namespace Proto\Console\Commands;

use Illuminate\Console\Command;

use Proto\Models\Flickr;
use Proto\Models\FlickrAlbum;
use Proto\Models\FlickrItem;

class FlickrSync extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'proto:flickrsync';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sync album structure from Flickr to local database.';

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
        $albums = Flickr::getAlbumsFromAPI();

        foreach($albums as $album) {
            if(!FlickrAlbum::where('id', '=', $album->id)->exists()) {
                $albumObject = new FlickrAlbum();
                $albumObject->id = $album->id;
                $albumObject->name = $album->name;
                $albumObject->thumb = $album->thumb;
                $albumObject->save();
                $this->info("Added album " . $album->name . " to database.");
            }

            $this->info($album->id);

            $items = Flickr::getPhotosFromAPI($album->id);

            $count = 0;

            foreach($items->photos as $item) {
                if(!FlickrItem::where('url', '=', $item->url)->exists()) {
                    $itemObject = new FlickrItem();
                    $itemObject->url = $item->url;
                    $itemObject->thumb = $item->thumb;
                    $itemObject->album_id = $album->id;
                    $itemObject->save();
                    $count++;
                }
            }

            $this->info("Added " . $count . " items to album.");
        }
    }
}
