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
            // Note: is_active was never added to assignments table
            // This migration is a no-op to maintain migration history
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // No-op: is_active was never in the table
    }
};
