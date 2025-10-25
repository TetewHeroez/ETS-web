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
            // Add relationship to GDK flowchart (metode)
            // Note: position without 'after' to avoid referencing non-existent weight column
            $table->foreignId('gdk_flowchart_id')->nullable()->constrained('gdk_flowchart')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('assignments', function (Blueprint $table) {
            $table->dropForeignIdFor('gdk_flowchart');
        });
    }
};
