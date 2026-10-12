<?php

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
        DB::table('emails_events')
            ->whereNotExists(function ($query) {
                $query->select(DB::raw(1))
                    ->from('emails')
                    ->whereColumn('emails.id', 'emails_events.email_id');
            })->delete();

        Schema::table('emails_events', function (Blueprint $table) {
            $table->foreign('email_id')->references('id')->on('emails')->onDelete('cascade');
            $table->foreign('event_id')->references('id')->on('events')->onDelete('cascade');
        });

        DB::table('emails_lists')
            ->whereNotExists(function ($query) {
                $query->select(DB::raw(1))
                    ->from('emails')
                    ->whereColumn('emails.id', 'emails_lists.email_id');
            })->delete();

        // email_lists
        Schema::table('emails_lists', function (Blueprint $table) {
            $table->foreign('email_id')->references('id')->on('emails')->onDelete('cascade');
            $table->foreign('list_id')->references('id')->on('mailinglists')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('emails_events', function (Blueprint $table) {
            $table->dropForeign(['email_id']);
            $table->dropForeign(['event_id']);
        });

        Schema::table('emails_lists', function (Blueprint $table) {
            $table->dropForeign(['email_id']);
            $table->dropForeign(['list_id']);
        });
    }
};
