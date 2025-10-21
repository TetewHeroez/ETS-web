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
        Schema::create('scores', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Member yang dinilai
            $table->foreignId('assignment_id')->constrained()->onDelete('cascade'); // Tugas yang dinilai
            $table->decimal('score', 5, 2); // Nilai (0-100)
            $table->text('notes')->nullable(); // Catatan dari admin
            $table->timestamps();
            
            // Unique constraint: satu user hanya bisa punya satu nilai per tugas
            $table->unique(['user_id', 'assignment_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('scores');
    }
};
