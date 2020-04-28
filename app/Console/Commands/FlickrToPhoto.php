<?php

namespace Proto\Console\Commands;

use Illuminate\Console\Command;

use Proto\Models\FlickrAlbum;
use Proto\Models\Photo;
use Proto\Models\PhotoAlbum;
use Proto\Models\StorageEntry;
use Proto\Models\FlickrLikes;
use Proto\Models\PhotoLikes;

class FlickrToPhoto extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'proto:flickrtophoto';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Migrate all Flickr albums and photos to the photo storage';

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
        $this->info('Downloading all albums');
        foreach (FlickrAlbum::all() as $flickrAlbum) {
            if($flickrAlbum->migrated) continue;
            $this->info('Downloading album '.$flickrAlbum->name);
            $photoAlbum = new PhotoAlbum();
            $photoAlbum->name = $flickrAlbum->name;
            $photoAlbum->date_create = $flickrAlbum->date_create;
            $photoAlbum->date_taken = $flickrAlbum->date_taken;
            $photoAlbum->event_id = $flickrAlbum->event_id;
            $photoAlbum->private = $flickrAlbum->private;
            $photoAlbum->published = True;
            $photoAlbum->save();
            $id = $photoAlbum->id;
            $flickrThumb = $flickrAlbum->thumb;
            $thumb = null;
            foreach ($flickrAlbum->items as $flickrItem) {
                if($flickrItem->migrated) continue;
                $photoUrl = $flickrItem->url;
                $photoData = file_get_contents($photoUrl);
                $photoMime = get_headers($photoUrl, 1)['Content-Type'];
                $photoName = basename($photoUrl);
                $photoPath = "photos/" . $id . "/";
                $photoFile = new StorageEntry();
                $photoFile->createFromData($photoData, $photoMime, $photoName, $photoPath);
                $photoFile->save();

                $photo = new Photo();
                $photo->date_taken = $flickrItem->date_taken;
                $photo->private = $flickrItem->private;
                $photo->album_id = $id;
                $photo->file_id = $photoFile->id;

                $photo->save();

                foreach(FlickrLikes::where("photo_id","=", intval($flickrItem->id))->get() as $flickrLike) {
                    if($flickrLike->migrated) continue;
                    $photoLike = new PhotoLikes();
                    $photoLike->photo_id = $photo->id;
                    $photoLike->user_id = $flickrLike->user_id;
                    $photoLike->save();
                    $flickrLike->migrated = true;
                    $flickrLike->save();
                }

                $photo->save();
                $flickrItem->migrated = true;
                $flickrItem->save();

                if($flickrItem->thumb == $flickrThumb) {
                    $this->info('Found thumb');
                    $thumb = $photo->id;
                }
            }
            $photoAlbum->thumb_id = $thumb;
            $photoAlbum->save();
            $flickrAlbum->migrated = true;
            $flickrAlbum->save();
        }
    }
}
