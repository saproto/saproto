<?php

use App\Models\StickerType;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sticker_types', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->timestamps();
        });

        StickerType::query()->insert([
            'title' => 'Proto',
            'created_at' => Date::now(),
            'updated_at' => Date::now(),
        ]);

        Schema::table('stickers', function (Blueprint $table) {
            $table->foreignId('sticker_type_id')->default(1)->after('country_code')->constrained('sticker_types');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sticker_types');
    }
};
