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
            // 1. Drop the old full name string field safely
            $table->dropColumn('full_name');

            // 2. ✅ FIXED FOR SQLITE: We make them temporary nullable, or assign a default fallback string value
            $table->string('first_name', 100)->default('')->after('id');
            $table->string('middle_name', 100)->nullable()->after('first_name');
            $table->string('last_name', 100)->default('')->after('middle_name');

            // 3. Keep person_to_visit but make it fully optional
            $table->string('person_to_visit', 255)->nullable()->change();

            // 4. Add the explicit office tracking input field element 
            $table->string('office_to_visit', 255)->nullable()->after('person_to_visit');
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('visitors', function (Blueprint $table) {
            // Rollback actions if needed
            $table->string('full_name', 255)->after('id');
            $table->dropColumn(['first_name', 'middle_name', 'last_name', 'office_to_visit']);
            $table->string('person_to_visit', 255)->nullable(false)->change();
        });
    }
};
