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
        $wizardQuery = DB::table('hashmap')
            ->where('key', 'wizard');

        Schema::table('users', function (Blueprint $table) {
            $table->boolean('wizard')->default(false);
        });

        foreach ($wizardQuery->get() as $wizard) {
            DB::table('users')
                ->where('id', (int) $wizard->subkey)
                ->update(['wizard' => true]);
        }

        $wizardQuery->delete();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('wizard');
        });
    }
};
