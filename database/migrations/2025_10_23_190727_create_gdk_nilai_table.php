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
        Schema::create('gdk_nilai', function (Blueprint $table) {
            $table->id();
            $table->string('nama_nilai'); // Nama nilai (Solidaritas, Wawasan, Adaptif)
            $table->text('deskripsi')->nullable();
            $table->decimal('multiplier', 5, 2)->default(1.00); // Multiplier untuk nilai
            $table->integer('urutan')->default(0); // Urutan tampilan
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gdk_nilai');
    }
};
