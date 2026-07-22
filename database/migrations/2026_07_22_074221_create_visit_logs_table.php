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
    Schema::create('visit_logs', function (Blueprint $table) {
        $table->id();
        $table->foreignId('visitor_id')->constrained()->onDelete('cascade'); // Links to visitors table
        $table->string('purpose_of_visit');
        $table->string('person_to_visit');
        $table->string('vehicle_type')->default('none');
        $table->string('qr_code_token')->unique();
        $table->string('status')->default('pending'); // pending, checked_in, checked_out
        $table->string('current_location')->default('Main Gate');
        $table->timestamps();
    });
}

public function down(): void
{
    Schema::dropIfExists('visit_logs');
}

};
