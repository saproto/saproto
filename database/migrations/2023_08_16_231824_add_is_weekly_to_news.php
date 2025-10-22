<?php

use App\Models\HashMapItem;
use App\Models\Newsitem;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('newsitems', function (Blueprint $table) {
            $table->boolean('is_weekly')->default(false);
        });

        $lastSent = HashMapItem::query()->where('key', 'newsletter_last_sent')->first();
        $text = HashMapItem::query()->where('key', 'newsletter_text')->first();
        if ($text) {
            $newsItem = new Newsitem([
                'title' => 'Weekly newsletter of week '.Date::now()->weekOfYear.' of '.Date::now()->year,
                'content' => $text->value,
                'is_weekly' => true,
                'publication' => Date::createFromTimestamp($lastSent->value, date_default_timezone_get())->toDateTimeString(),
            ]);

            $newsItem->save();
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('newsitems', function (Blueprint $table) {
            $table->dropColumn('is_weekly');
        });
    }
};
