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
        // Add gdk_metode_id to gdk_flowchart table
        Schema::table('gdk_flowchart', function (Blueprint $table) {
            $table->foreignId('gdk_metode_id')->nullable()->after('id')->constrained('gdk_metode')->onDelete('set null');
        });

        // Remove score and notes from scores table (auto-calculated now)
        Schema::table('scores', function (Blueprint $table) {
            $table->dropColumn(['score', 'notes']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Restore score and notes columns
        Schema::table('scores', function (Blueprint $table) {
            $table->decimal('score', 5, 2)->nullable();
            $table->text('notes')->nullable();
        });

        // Remove gdk_metode_id from gdk_flowchart
        Schema::table('gdk_flowchart', function (Blueprint $table) {
            $table->dropForeign(['gdk_metode_id']);
            $table->dropColumn('gdk_metode_id');
        });
    }
};
