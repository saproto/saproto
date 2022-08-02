<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ConvertStorageEntriesToPhotos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('photos', function (Blueprint $table) {
            $table->integer('album_id')->nullable()->change();
        });
        Schema::table('events', function(Blueprint $table) {
            $table->renameColumn('image_id', 'photo_id');
        });
        Schema::table('companies', function(Blueprint $table) {
            $table->renameColumn('image_id', 'photo_id');
        });

        Schema::table('committees', function(Blueprint $table) {
            $table->renameColumn('image_id', 'photo_id');
        });

        Schema::table('users', function(Blueprint $table) {
            $table->renameColumn('image_id', 'photo_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
            Schema::table('photos', function (Blueprint $table) {
                $table->integer('album_id')->change();
            });

        if(Schema::hasColumn('events', 'photo_id')) {
            Schema::table('events', function (Blueprint $table) {
                $table->renameColumn('photo_id', 'image_id');
            });
        }
        if(Schema::hasColumn('companies', 'photo_id')) {
            Schema::table('companies', function (Blueprint $table) {
                $table->renameColumn('photo_id', 'image_id');
            });
        }

        if(Schema::hasColumn('committees', 'photo_id')) {
            Schema::table('committees', function (Blueprint $table) {
                $table->renameColumn('photo_id', 'image_id');
            });
        }

        if(Schema::hasColumn('users', 'photo_id')) {
            Schema::table('users', function (Blueprint $table) {
                $table->renameColumn('photo_id', 'image_id');
            });
        }
    }
}
