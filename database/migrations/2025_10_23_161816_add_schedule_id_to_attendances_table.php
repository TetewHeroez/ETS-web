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
        Schema::table('attendances', function (Blueprint $table) {
            $table->foreignId('attendance_schedule_id')->nullable()->after('id')->constrained('attendance_schedules')->onDelete('cascade');
            // Make date nullable since it will be taken from schedule
            $table->date('date')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('attendances', function (Blueprint $table) {
            $table->dropForeign(['attendance_schedule_id']);
            $table->dropColumn('attendance_schedule_id');
        });
    }
};
