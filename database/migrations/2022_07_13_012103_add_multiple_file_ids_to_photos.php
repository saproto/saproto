<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;
use Proto\Models\Photo;
use Proto\Models\StorageEntry;
use Symfony\Component\Console\Output\ConsoleOutput;

class AddMultipleFileIdsToPhotos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */


    public function up()
    {
        $output = new ConsoleOutput();
        if(!Schema::hasColumn('photos', 'large_file_id')) {
            Schema::table('photos', function (Blueprint $table) {
                $table->integer('large_file_id')->after('file_id')->nullable();
                $table->integer('medium_file_id')->after('large_file_id')->nullable();
                $table->integer('small_file_id')->after('medium_file_id')->nullable();
                $table->integer('tiny_file_id')->after('small_file_id')->nullable();
            });
        }
        $output->writeln("created schemas!");
        foreach(Photo::all() as $photo){
            $oldPath =  Storage::disk('local')->path('photos/'.$photo->album->id.'/'.$photo->fileRelation->hash);
            $newPath = 'photos/original_photos/'.$photo->album->id.'/'.$photo->fileRelation->hash;
            $newPathFromRoot=Storage::disk('local')->path($newPath);

            if (!File::exists(Storage::disk('local')->path('photos/original_photos/'.$photo->album->id.'/'))){
                File::makeDirectory(Storage::disk('local')->path('photos/original_photos/'.$photo->album->id.'/'), 0777, True);
            }

            if (File::copy($oldPath , $newPathFromRoot)) {
                $photo->fileRelation->filename=$newPath;
                $photo->fileRelation->save();
            }else{
                $output->writeln("could not move ".$photo->fileRelation->filename);
            }
        }
        $output->writeln("moved all photos! starting resizing");

        foreach (Photo::all() as $photo){
            $path=Storage::disk('local')->path($photo->fileRelation->filename);
            $large_photos_storage =  'photos/large_photos/'.$photo->album->id.'/';
            $medium_photos_storage =  'photos/medium_photos/'.$photo->album->id.'/';
            $small_photos_storage =  'photos/small_photos/'.$photo->album->id.'/';
            $tiny_photos_storage =  'photos/tiny_photos/'.$photo->album->id.'/';

            if (!File::exists(Storage::disk('local')->path($large_photos_storage))) {
                File::makeDirectory(Storage::disk('local')->path($large_photos_storage), 0777, True);
                $output->writeln("created the folder: ".Storage::disk('local')->path($large_photos_storage));
            }
            if (!File::exists(Storage::disk('local')->path($medium_photos_storage))) {
                File::makeDirectory(Storage::disk('local')->path($medium_photos_storage), 0777, True);
                $output->writeln("created the folder: ".Storage::disk('local')->path($medium_photos_storage));
            }
            if (!File::exists(Storage::disk('local')->path($small_photos_storage))) {
                File::makeDirectory(Storage::disk('local')->path($small_photos_storage), 0777, True);
                $output->writeln("created the folder: ".Storage::disk('local')->path($small_photos_storage));
            }
            if (!File::exists(Storage::disk('local')->path($tiny_photos_storage))) {
                File::makeDirectory(Storage::disk('local')->path($tiny_photos_storage), 0777, True);
                $output->writeln("created the folder: ".Storage::disk('local')->path($tiny_photos_storage));
            }

            $large_file = new StorageEntry();
            $large_file->createFromPhoto($path, $large_photos_storage, 860, $photo->fileRelation->original_filename);
            $large_file->save();

            $medium_file = new StorageEntry();
            $medium_file->createFromPhoto($path, $medium_photos_storage, 640, $photo->fileRelation->original_filename);
            $medium_file->save();

            $small_file = new StorageEntry();
            $small_file->createFromPhoto($path, $small_photos_storage,420, $photo->fileRelation->original_filename);
            $small_file->save();

            $tiny_file = new StorageEntry();
            $tiny_file->createFromPhoto($path, $tiny_photos_storage,20, $photo->fileRelation->original_filename);
            $tiny_file->save();

            $photo->large_file_id = $large_file->id;
            $photo->medium_file_id = $medium_file->id;
            $photo->small_file_id = $small_file->id;
            $photo->tiny_file_id = $tiny_file->id;
            $photo->save();
        }
        $output->writeln("resized all photos!");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $output = new ConsoleOutput();
        $output->writeln("starting moving all files back over");
        foreach(Photo::all() as $photo){
            $oldPath =  Storage::disk('local')->path('photos/original_photos/'.$photo->album->id.'/'.$photo->fileRelation->hash);
            $newPath = 'photos/'.$photo->album->id.'/'.$photo->fileRelation->hash;
            $newPathFromRoot=Storage::disk('local')->path($newPath);

            if (!File::exists(Storage::disk('local')->path('photos/'.$photo->album->id.'/'))){
                File::makeDirectory(Storage::disk('local')->path('photos/'.$photo->album->id.'/'), 0777, True);
            }

            if (File::move($oldPath , $newPathFromRoot)) {
                $photo->fileRelation->filename=$newPath;
                $photo->fileRelation->save();

                $large_photo=StorageEntry::find($photo->large_file_id);
                if($large_photo)$large_photo->delete();

                $medium_photo=StorageEntry::find($photo->medium_file_id);
                if($medium_photo)$medium_photo->delete();

                $small_photo=StorageEntry::find($photo->small_file_id);
                if($small_photo)$small_photo->delete();

                $tiny_photo=StorageEntry::find($photo->tiny_file_id);
                if($tiny_photo)$tiny_photo->delete();
            }
        }
        $output->writeln("dropping the columns!");
        if(Schema::hasColumn('photos', 'large_file_id')) {
            Schema::table('photos', function (Blueprint $table) {
                $table->dropColumn('large_file_id');
                $table->dropColumn('medium_file_id');
                $table->dropColumn('small_file_id');
                $table->dropColumn('tiny_file_id');
            });
        }
        $output->writeln("deleting folders!");
        File::deleteDirectory(Storage::disk('local')->path('photos/original_photos/'));
        File::deleteDirectory(Storage::disk('local')->path('photos/large_photos/'));
        File::deleteDirectory(Storage::disk('local')->path('photos/medium_photos/'));
        File::deleteDirectory(Storage::disk('local')->path('photos/small_photos/'));
        File::deleteDirectory(Storage::disk('local')->path('photos/tiny_photos/'));
    }
}
