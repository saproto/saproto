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
        $this->info('Album clean-up...');
        foreach ($dbAlbums as $dbAlbum) {
            $found = false;

            foreach ($albums as $album) {
                if ($album->id == $dbAlbum->id) {
                    $found = true;
                    break;
                }
            }

            if (!$found) {
                $this->info('Deleted album ' . $dbAlbum->name . " from database.");
                $dbAlbum->items()->delete();
                $dbAlbum->delete();
            }
        }

        // Get new albums
        $this->info('Getting new data...');
        $n = 0;
        foreach ($albums as $album) {

            $n++;

            $this->info("Now processing " . $album->name . "... ($n/" . count($albums) . ")");

            $dbAlbum = FlickrAlbum::where('id', '=', $album->id)->first();

            if ($dbAlbum === false) {
                $this->error('Flickr API not available.');
                continue;
            } else if (!$dbAlbum) {
                $albumObject = new FlickrAlbum();
                $albumObject->id = $album->id;
                $albumObject->name = $album->name;
                $albumObject->thumb = $album->thumb;
                $albumObject->date_create = $album->date_create;
                $albumObject->date_update = $album->date_update;
                $albumObject->save();
                $this->info("  added to database.");

                $dbAlbum = $albumObject;
            } else {
                $albumObject = FlickrAlbum::findOrFail($album->id);
                $albumObject->id = $album->id;
                $albumObject->name = $album->name;
                $albumObject->thumb = $album->thumb;
                $albumObject->save();
                $this->info("  updated in database.");
            }

            $items = Flickr::getPhotosFromAPI($album->id);

            if ($items === false) {
                $this->error('Flickr API not available.');
                continue;
            }

            $count = 0;

            $this->info('  looking for new photos.');

            foreach ($items->photos as $item) {
                if (!FlickrItem::where('id', '=', $item->id)->exists()) {
                    $itemObject = new FlickrItem();
                    $itemObject->id = $item->id;
                    $itemObject->url = $item->url;
                    $itemObject->thumb = $item->thumb;
                    $itemObject->album_id = $album->id;
                    $itemObject->date_taken = strtotime($item->timestamp);
                    $itemObject->save();
                    $count++;
                }
            }

            if ($count > 0) {
                $this->info("  added " . $count . " items to album.");
                $dbAlbum->date_update = $album->date_update;
                $dbAlbum->save();
            }

            $dbItems = $dbAlbum->items;

            // Item cleanup
            $this->info("  starting clean-up.");
            foreach ($dbItems as $dbItem) {
                $found = false;

                foreach ($items->photos as $item) {
                    if ($item->url == $dbItem->url) {
                        $found = true;
                        break;
                    }
                }

                if (!$found) {
                    $this->info('  removed item ' . $dbAlbum->name . ' from album.');
                    $dbItem->delete();
                }
            }

            if ($albumObject->event === null) {
                $dates = FlickrItem::where('album_id', $albumObject->id)->orderBy('date_taken', 'asc')->get()->pluck('date_taken');

                $albumObject->date_taken = (count($dates) > 0 ? $dates[ceil(count($dates) / 2)] : 0);
                $albumObject->save();
            } else {
                $albumObject->date_taken = $albumObject->event->start;
                $albumObject->save();
            }
            $this->info('  album date set to ' . date('Y-m-d H:i:s', $albumObject->date_taken) . '.');

            $this->info("Done!\n");

        }
    }
}
