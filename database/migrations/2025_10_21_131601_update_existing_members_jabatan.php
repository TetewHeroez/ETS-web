<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Update all existing users with role 'member' to have jabatan 'PPH'
        DB::table('users')
            ->where('role', 'member')
            ->whereNull('jabatan')
            ->update(['jabatan' => 'PPH']);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Optionally revert jabatan to null for members
        DB::table('users')
            ->where('role', 'member')
            ->where('jabatan', 'PPH')
            ->update(['jabatan' => null]);
    }
};
