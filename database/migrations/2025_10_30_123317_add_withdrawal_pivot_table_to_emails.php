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

        Schema::create('emails_withdrawals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('email_id')->constrained('emails')->cascadeOnDelete();
            $table->foreignId('withdrawal_id')->constrained('withdrawals')->cascadeOnDelete();
            $table->timestamps();
        });

        Schema::table('emails', function (Blueprint $table) {
            $table->boolean('to_withdrawal')->default(false)->after('to_event');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('emails', function (Blueprint $table) {
            $table->dropColumn('to_withdrawal');
        });

        Schema::dropIfExists('emails_withdrawals');
    }
};
