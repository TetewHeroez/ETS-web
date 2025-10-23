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
        Schema::create('attendance_schedules', function (Blueprint $table) {
            $table->id();
            $table->string('title'); // Nama acara/forum
            $table->text('description')->nullable(); // Deskripsi acara
            $table->date('date'); // Tanggal kehadiran
            $table->time('start_time')->nullable(); // Jam mulai
            $table->time('end_time')->nullable(); // Jam selesai
            $table->boolean('is_active')->default(true); // Apakah jadwal masih aktif
            $table->boolean('is_open')->default(false); // Apakah absensi dibuka
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attendance_schedules');
    }
};
