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
        Schema::table('assignments', function (Blueprint $table) {
            // Add submission_type column: 'pdf', 'image', or 'link'
            // Note: position without 'after' to avoid referencing non-existent weight column
            $table->enum('submission_type', ['pdf', 'image', 'link'])->default('link');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('assignments', function (Blueprint $table) {
            $table->dropColumn('submission_type');
        });
    }
};
