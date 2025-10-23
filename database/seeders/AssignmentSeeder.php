<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Assignment;
use Carbon\Carbon;

class AssignmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $assignments = [
            [
                'title' => 'Tugas 1 - Pengenalan Laravel',
                'description' => 'Membuat aplikasi CRUD sederhana menggunakan Laravel dengan fitur create, read, update, dan delete untuk mengelola data mahasiswa.',
                'deadline' => Carbon::now()->addWeeks(2),
                'weight' => 2,
                'is_active' => true,
            ],
            [
                'title' => 'Tugas 2 - Database Migration',
                'description' => 'Membuat migration untuk tabel baru dan menjalankan seeder untuk mengisi data awal. Termasuk pembuatan relasi antar tabel.',
                'deadline' => Carbon::now()->addWeeks(3),
                'weight' => 1,
                'is_active' => true,
            ],
            [
                'title' => 'Tugas 3 - Authentication & Authorization',
                'description' => 'Implementasi sistem login, logout, dan middleware untuk mengatur akses berdasarkan role user (admin, member).',
                'deadline' => Carbon::now()->addWeeks(4),
                'weight' => 3,
                'is_active' => true,
            ],
            [
                'title' => 'Tugas 4 - API Development',
                'description' => 'Membuat RESTful API dengan Laravel untuk mengelola data assignments dan submissions. Termasuk validasi dan response format yang konsisten.',
                'deadline' => Carbon::now()->addWeeks(5),
                'weight' => 2,
                'is_active' => true,
            ],
            [
                'title' => 'Project Akhir - Web Application',
                'description' => 'Membuat aplikasi web lengkap dengan fitur-fitur yang telah dipelajari: CRUD, authentication, file upload, dan dashboard analytics.',
                'deadline' => Carbon::now()->addWeeks(8),
                'weight' => 4,
                'is_active' => true,
            ],
            [
                'title' => 'Tugas Tambahan - Code Review',
                'description' => 'Review kode dari rekan tim dan memberikan feedback konstruktif. Tugas ini tidak aktif untuk sementara.',
                'deadline' => Carbon::now()->addWeeks(6),
                'weight' => 1,
                'is_active' => false,
            ],
        ];

        foreach ($assignments as $assignment) {
            Assignment::create($assignment);
        }
    }
}
