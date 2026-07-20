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
        Schema::table('visitors', function (Blueprint $table) {
            // 🏆 INDEXING COLUMNS FOR LIGHTNING-FAST LOOKUPS AT THE GATES
            $table->index('id_number');
            $table->index('qr_code_token');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('visitors', function (Blueprint $table) {
            // Drop indexes if we ever need to roll back
            $table->dropIndex(['id_number']);
            $table->dropIndex(['qr_code_token']);
        });
    }
};
