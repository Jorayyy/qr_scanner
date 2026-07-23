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
    Schema::create('movements', function (Blueprint $table) {
        $table->id();
        $table->foreignId('visitor_id')->constrained()->onDelete('cascade');
        
        // 🔑 THE TWO CRITICAL FIXES: Ensure both columns are explicitly defined!
        $table->string('action_type')->nullable(); 
        $table->string('location_name')->nullable();
        $table->text('remarks')->nullable(); // 🟢 ADD THIS EXACT LINE HERE!
        
        $table->timestamps();
    });
}



    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('movements');
    }
};
