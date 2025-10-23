<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Contract;

class ContractSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Contract::create([
            'title' => 'Kontrak Padamu HIMATIKA ITS 2024',
            'description' => 'Dengan ini, setiap peserta Padamu HIMATIKA ITS 2024 menyetujui hal-hal berikut:',
            'rules' => [
                'Menjaga norma dan etika yang berlaku di ITS',
                'Mengikuti seluruh kegiatan Padamu HIMATIKA ITS 2024',
                'Setiap peserta Padamu HIMATIKA ITS 2024 bertanggung jawab atas seluruh peserta Padamu HIMATIKA ITS 2024 yang lain',
                'Tidak ada campur tangan dari pihak di luar HIMATIKA ITS',
                'Tidak ada kegiatan Padamu HIMATIKA ITS 2024 di luar diskusi dan arahan yang telah disepakati'
            ],
            'is_active' => true
        ]);
    }
}
