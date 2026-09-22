<?php

use App\Models\EmailListSubscription;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        EmailListSubscription::query()->whereDoesntHave('user')->delete();
        EmailListSubscription::query()->whereDoesntHave('emaillist')->delete();
        Schema::table('users_mailinglists', function (Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('list_id')->references('id')->on('mailinglists')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users_mailinglist', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropForeign(['list_id']);
        });
    }
};
