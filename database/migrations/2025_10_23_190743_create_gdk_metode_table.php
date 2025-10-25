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
        Schema::create('gdk_metode', function (Blueprint $table) {
            $table->id();
            $table->foreignId('gdk_materi_id')->constrained('gdk_materi')->onDelete('cascade');
            $table->string('nama_metode'); // Nama metode/tugas (Tanda Pengenal Angkatan, Safari HIMATIKA, dll)
            $table->text('deskripsi')->nullable();
            $table->decimal('multiplier', 5, 2)->default(1.00); // Multiplier untuk metode
            $table->string('pa')->nullable(); // Program Activity
            $table->string('pi')->nullable(); // Performance Indicator
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gdk_metode');
    }
};
