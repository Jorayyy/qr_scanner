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
            $table->timestamp('pass_expires_at')->nullable()->after('qr_code_token');
            $table->string('id_document_path')->nullable()->after('pass_expires_at');
            $table->text('id_document_text')->nullable()->after('id_document_path');
            $table->string('id_document_type')->nullable()->after('id_document_text');
            $table->timestamp('id_verified_at')->nullable()->after('id_document_type');
            $table->unsignedBigInteger('id_verified_by')->nullable()->after('id_verified_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('visitors', function (Blueprint $table) {
            $table->dropColumn([
                'pass_expires_at',
                'id_document_path',
                'id_document_text',
                'id_document_type',
                'id_verified_at',
                'id_verified_by'
            ]);
        });
    }
};
