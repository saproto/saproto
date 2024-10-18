<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ut_accounts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id');
            $table->string('number'); //student number
            $table->string('mail'); //email
            $table->string('department')->nullable(); //B-CREA, M-ITECH
            $table->string('givenname');
            $table->string('middlename')->nullable();
            $table->string('surname');
            $table->integer('account_expires_at');
            $table->boolean('found')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ut_accounts');
    }
};
