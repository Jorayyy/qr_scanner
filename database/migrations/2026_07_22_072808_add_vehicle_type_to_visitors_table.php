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
        // Adds a string column that defaults to 'none' if empty
        $table->string('vehicle_type')->default('none')->after('person_to_visit');
    });
}

public function down(): void
{
    Schema::table('visitors', function (Blueprint $table) {
        $table->dropColumn('vehicle_type');
    });
}
};
