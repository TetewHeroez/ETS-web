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
        Schema::table('users', function (Blueprint $table) {
            // Data pribadi
            $table->string('tempat_lahir')->nullable()->after('nim');
            $table->date('tanggal_lahir')->nullable()->after('tempat_lahir');
            $table->enum('jenis_kelamin', ['Laki-laki', 'Perempuan'])->nullable()->after('tanggal_lahir');
            $table->text('alamat_asal')->nullable()->after('jenis_kelamin');
            $table->text('alamat_surabaya')->nullable()->after('alamat_asal');
            
            // Data orang tua/wali
            $table->string('nama_ortu')->nullable()->after('alamat_surabaya');
            $table->text('alamat_ortu')->nullable()->after('nama_ortu');
            $table->string('no_hp')->nullable()->after('alamat_ortu');
            
            // Data kesehatan
            $table->string('golongan_darah')->nullable()->after('no_hp');
            $table->text('alergi')->nullable()->after('golongan_darah');
            $table->text('riwayat_penyakit')->nullable()->after('alergi');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'tempat_lahir',
                'tanggal_lahir',
                'jenis_kelamin',
                'alamat_asal',
                'alamat_surabaya',
                'nama_ortu',
                'alamat_ortu',
                'no_hp',
                'golongan_darah',
                'alergi',
                'riwayat_penyakit',
            ]);
        });
    }
};
