<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::dropIfExists('dmx_channels');
        Schema::dropIfExists('dmx_fixtures');
        Schema::dropIfExists('dmx_overrides');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
