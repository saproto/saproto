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
    public function ensureLocalDirectoryExists($directoryPath, $output) {
        if (! File::exists(Storage::disk('local')->path($directoryPath))){
            File::makeDirectory(Storage::disk('local')->path($directoryPath), 0777, true);
            $output->writeln('created the folder: '.$directoryPath);
        }
    }

    public function ensurePublicDirectoryExists($directoryPath, $output) {
        if (! File::exists(Storage::disk('public')->path($directoryPath))){
            File::makeDirectory(Storage::disk('public')->path($directoryPath), 0777, true);
            $output->writeln('created the folder: '.$directoryPath);
        }
    }

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $output = new ConsoleOutput();
        if(! Schema::hasColumn('photos', 'large_file_id')) {
            Schema::table('photos', function (Blueprint $table) {
                $table->integer('large_file_id')->after('file_id')->nullable();
                $table->integer('medium_file_id')->after('large_file_id')->nullable();
                $table->integer('small_file_id')->after('medium_file_id')->nullable();
                $table->integer('tiny_file_id')->after('small_file_id')->nullable();
            });
        }
        $output->writeln('created schemas!');

//        first copy over all the new files before resizing
        foreach(Photo::all() as $photo){
            $oldFolderPath = 'photos/'.$photo->album->id.'/';
            $oldPath = $oldFolderPath.$photo->fileRelation->hash;
            $newFolderPath = 'photos/original_photos/'.$photo->album->id.'/';
            $newPath = $newFolderPath.$photo->fileRelation->hash;

            $this->ensureLocalDirectoryExists($newFolderPath, $output);
            $this->ensurePublicDirectoryExists($newFolderPath, $output);

            if($photo->private){
                $newStorageLocation = Storage::disk('local')->path($newPath);
            }else{
                $newStorageLocation = Storage::disk('public')->path($newPath);
            }

            if (File::move(Storage::disk('local')->path($oldPath) ,$newStorageLocation)) {
                $photo->fileRelation->filename = $newPath;
                $photo->fileRelation->save();
            }else{
                $output->writeln('could not move '.$photo->fileRelation->filename);
            }
        }
        $output->writeln('moved all photos! starting resizing');

//        resize all photos and copy the public photos to that directory
        foreach (Photo::all() as $photo){
            if($photo->private){
                $path = Storage::disk('local')->path($photo->fileRelation->filename);
            }else{
                $path = Storage::disk('public')->path($photo->fileRelation->filename);
            }

            $large_photos_storage = 'photos/large_photos/'.$photo->album->id.'/';
            $medium_photos_storage = 'photos/medium_photos/'.$photo->album->id.'/';
            $small_photos_storage = 'photos/small_photos/'.$photo->album->id.'/';
            $tiny_photos_storage = 'photos/tiny_photos/'.$photo->album->id.'/';

            $this->ensureLocalDirectoryExists($large_photos_storage, $output);
            $this->ensureLocalDirectoryExists($medium_photos_storage, $output);
            $this->ensureLocalDirectoryExists($small_photos_storage, $output);
            $this->ensureLocalDirectoryExists($tiny_photos_storage, $output);

            $this->ensurePublicDirectoryExists($large_photos_storage, $output);
            $this->ensurePublicDirectoryExists($medium_photos_storage, $output);
            $this->ensurePublicDirectoryExists($small_photos_storage, $output);
            $this->ensurePublicDirectoryExists($tiny_photos_storage, $output);

//          resize all photos to the 4 extra levels of quality
            $large_file = new StorageEntry();
            $large_file->createFromPhoto($path, $large_photos_storage, 860, $photo->fileRelation->original_filename, null, $photo->public);
            $large_file->save();

            $medium_file = new StorageEntry();
            $medium_file->createFromPhoto($path, $medium_photos_storage, 640, $photo->fileRelation->original_filename, null, $photo->public);
            $medium_file->save();

            $small_file = new StorageEntry();
            $small_file->createFromPhoto($path, $small_photos_storage,420, $photo->fileRelation->original_filename, null, $photo->public);
            $small_file->save();

            $tiny_file = new StorageEntry();
            $tiny_file->createFromPhoto($path, $tiny_photos_storage,20, $photo->fileRelation->original_filename, null, $photo->public);
            $tiny_file->save();

            $photo->large_file_id = $large_file->id;
            $photo->medium_file_id = $medium_file->id;
            $photo->small_file_id = $small_file->id;
            $photo->tiny_file_id = $tiny_file->id;
            $photo->save();
        }
        $output->writeln('resized all photos!');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $output = new ConsoleOutput();
        $output->writeln('starting moving all files back over');
        foreach(Photo::all() as $photo){
            if($photo->private){
                $oldPath = Storage::disk('local')->path('photos/original_photos/'.$photo->album->id.'/'.$photo->fileRelation->hash);
            }else{
                $oldPath = Storage::disk('public')->path('photos/original_photos/'.$photo->album->id.'/'.$photo->fileRelation->hash);
            }

            $newPath = 'photos/'.$photo->album->id.'/'.$photo->fileRelation->hash;
            $newPathFromRoot = Storage::disk('local')->path($newPath);

            $this->ensureLocalDirectoryExists('photos/'.$photo->album->id.'/', $output);

            if (! File::exists($newPathFromRoot) && File::move($oldPath , $newPathFromRoot)) {
                $photo->fileRelation->filename = $newPath;
                $photo->fileRelation->save();

                $large_photo = StorageEntry::find($photo->large_file_id);
                if($large_photo)$large_photo->delete();

                $medium_photo = StorageEntry::find($photo->medium_file_id);
                if($medium_photo)$medium_photo->delete();

                $small_photo = StorageEntry::find($photo->small_file_id);
                if($small_photo)$small_photo->delete();

                $tiny_photo = StorageEntry::find($photo->tiny_file_id);
                if($tiny_photo)$tiny_photo->delete();
            }
        }
        $output->writeln('dropping the columns!');
        if(Schema::hasColumn('photos', 'large_file_id')) {
            Schema::table('photos', function (Blueprint $table) {
                $table->dropColumn('large_file_id');
                $table->dropColumn('medium_file_id');
                $table->dropColumn('small_file_id');
                $table->dropColumn('tiny_file_id');
            });
        }
        $output->writeln('deleting folders!');
        File::cleanDirectory(Storage::disk('public')->path('photos'));
        File::deleteDirectory(Storage::disk('public')->path('photos'));
        File::deleteDirectory(Storage::disk('local')->path('photos/original_photos/'));
        File::deleteDirectory(Storage::disk('local')->path('photos/large_photos/'));
        File::deleteDirectory(Storage::disk('local')->path('photos/medium_photos/'));
        File::deleteDirectory(Storage::disk('local')->path('photos/small_photos/'));
        File::deleteDirectory(Storage::disk('local')->path('photos/tiny_photos/'));
    }
}
