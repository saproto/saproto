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
        $dbAlbums = FlickrAlbum::all();

        // Album cleanup
        foreach($dbAlbums as $dbAlbum) {
            $found = false;

            foreach($albums as $album) {
                if($album->id == $dbAlbum->id) {
                    $found = true;
                    break;
                }
            }

            if(!$found) {
                $this->info('Deleted album ' . $dbAlbum->name . " from database.");
                $dbAlbum->items()->delete();
                $dbAlbum->delete();
            }
        }

        foreach($albums as $album) {
            $dbAlbum = FlickrAlbum::where('id', '=', $album->id)->first();

            if(!$dbAlbum) {
                $albumObject = new FlickrAlbum();
                $albumObject->id = $album->id;
                $albumObject->name = $album->name;
                $albumObject->thumb = $album->thumb;
                $albumObject->date_create = $album->date_create;
                $albumObject->date_update = $album->date_update;
                $albumObject->save();
                $this->info("Added album " . $album->name . " to database.");

                $dbAlbum = $albumObject;
            }

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

            if($count > 0) {
                $this->info("Added " . $count . " items to album.");
                $dbAlbum->date_update = $album->date_update;
                $dbAlbum->save();
            }

            $dbItems = $dbAlbum->items;

            // Item cleanup
            foreach($dbItems as $dbItem) {
                $found = false;

                foreach ($items->photos as $item) {
                    if ($item->url == $dbItem->url) {
                        $found = true;
                        break;
                    }
                }

                if(!$found) {
                    $this->info('Deleted item from album ' . $dbAlbum->name . ' from database');
                    $dbItem->delete();
                }
            }
        }
    }
}
