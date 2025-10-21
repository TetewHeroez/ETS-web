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
            'name' => 'Super Admin',
            'email' => 'superadmin@ets.com',
            'password' => bcrypt('password123'),
            'role' => 'superadmin',
            'nrp' => null,
        ]);

        // Admin
        User::factory()->create([
            'name' => 'Admin ETS',
            'email' => 'admin@ets.com',
            'password' => bcrypt('password123'),
            'role' => 'admin',
            'nrp' => null,
        ]);

        // Member 1
        User::factory()->create([
            'name' => 'Budi Santoso',
            'email' => 'budi@ets.com',
            'password' => bcrypt('password'),
            'role' => 'member',
            'nrp' => '2024001',
        ]);

        // Member 2
        User::factory()->create([
            'name' => 'Siti Nurhaliza',
            'email' => 'siti@ets.com',
            'password' => bcrypt('password'),
            'role' => 'member',
            'nrp' => '2024002',
        ]);

        // Member 3
        User::factory()->create([
            'name' => 'Ahmad Rizky',
            'email' => 'ahmad@ets.com',
            'password' => bcrypt('password'),
            'role' => 'member',
            'nrp' => '2024003',
        ]);
    }
}
