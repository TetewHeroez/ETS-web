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
        Schema::create('gdk_flowchart', function (Blueprint $table) {
            $table->id();
            $table->string('judul'); // Judul flowchart/agenda
            $table->text('deskripsi')->nullable();
            $table->string('image_path')->nullable(); // Path ke gambar flowchart
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gdk_flowchart');
    }
};
