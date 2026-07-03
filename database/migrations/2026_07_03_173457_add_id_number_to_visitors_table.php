<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
public function up()
{
    Schema::table('visitors', function ($table) {
        // Adds the id_number column right after the full name column
        $table->string('id_number')->nullable()->after('full_name'); 
    });
}

public function down()
{
    Schema::table('visitors', function ($table) {
        $table->dropColumn('id_number');
    });
}


};
