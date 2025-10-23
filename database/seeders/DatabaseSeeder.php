<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Superadmin
        User::factory()->create([
            'name' => 'Teosofi Hidayah Agung',
            'email' => 'teosofihidayahagung@gmail.com',
            'password' => bcrypt('password123'),
            'role' => 'superadmin',
            'nrp' => '5002221132',
            'jabatan' => 'Koor SC',
            'status' => 'aktif',
        ]);

        User::factory()->create([
            'name' => 'Gabirella Alfa Indahsari',
            'email' => 'gabriellaalfa312@gmail.com',
            'password' => bcrypt('password123'),
            'role' => 'superadmin',
            'nrp' => '5002221039',
            'jabatan' => 'Koor IC',
            'status' => 'aktif',
        ]);

        // Admin
        User::factory()->create([
            'name' => 'Arnelita Putri Febrianti',
            'email' => 'arnelitaputrifebrianti@gmail.com',
            'password' => bcrypt('password123'),
            'role' => 'admin',
            'nrp' => '5002221112',
            'jabatan' => 'SC',
            'status' => 'aktif',
        ]);

        User::factory()->create([
            'name' => 'Eka Nur Fitriawati',
            'email' => 'pitkanur@gmail.com',
            'password' => bcrypt('password123'),
            'role' => 'admin',
            'nrp' => '5002221121',
            'jabatan' => 'IC',
            'status' => 'aktif',
        ]);

        User::factory()->create([
            'name' => 'Siti Nisrina Salsabila',
            'email' => 'stnisrinasalsabila@gmail.com',
            'password' => bcrypt('password123'),
            'role' => 'admin',
            'nrp' => '5002221140',
            'jabatan' => 'OC',
            'status' => 'aktif',
        ]);

        // Member
        User::factory()->create([
            'name' => 'Galang Pijar Robbany',
            'email' => 'pijargalang85@gmail.com',
            'password' => bcrypt('5002241098'),
            'role' => 'member',
            'nrp' => '5002241098',
            'jabatan' => 'PPH',
            'status' => 'aktif',
            'kelompok' => 'Phi',
            'hobi' => 'Event Organizer',
            'tempat_lahir' => 'Malang',
            'tanggal_lahir' => '2006-01-12',
            'jenis_kelamin' => 'Laki-laki',
            'alamat_asal' => 'Perumahan Bumi Ardimulyo G-9',
            'alamat_surabaya' => 'Jl. Keputih Tegal 8, Keputih, Kec. Sukolilo',
            'nama_ortu' => 'Endang Mirasari',
            'alamat_ortu' => 'Perumahan bumi ardimulyo G-9',
            'no_hp_ortu' => '085875801121',
            'no_hp' => '085159439936',
            'golongan_darah' => 'B',
            'alergi' => 'udang, dan beberapa seafood',
            'riwayat_penyakit' => 'Asam Lambung',
        ]);
    }
}
