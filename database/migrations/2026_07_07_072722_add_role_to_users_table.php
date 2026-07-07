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
        // Place it right here to add the column to the database
        Schema::table('users', function (Blueprint $table) {
            $table->string('role')->default('guard'); // Options: admin, guard
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Tell the system how to drop the column if you ever roll back
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('role');
        });
    }
};
