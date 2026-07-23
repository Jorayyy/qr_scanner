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
        Schema::table('visitors', function (Blueprint $blueprint) {
            // 🆕 Adding the new nullable attributes after the vehicle_type field
            $blueprint->string('vehicle_brand', 50)->nullable()->after('vehicle_type');
            $blueprint->string('vehicle_model', 50)->nullable()->after('vehicle_brand');
            $blueprint->string('vehicle_plate', 20)->nullable()->after('vehicle_model');
            $blueprint->string('vehicle_color', 30)->nullable()->after('vehicle_plate');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('visitors', function (Blueprint $blueprint) {
            // Drop columns if the migration is rolled back
            $blueprint->dropColumn(['vehicle_brand', 'vehicle_model', 'vehicle_plate', 'vehicle_color']);
        });
    }
};
