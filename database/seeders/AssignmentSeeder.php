<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Assignment;
use App\Models\GdkFlowchart;
use Carbon\Carbon;

class AssignmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get GDK Flowchart entries for linking - using filter instead of where
        $flowcharts = GdkFlowchart::all();
        
        // Map flowcharts untuk assignment linking by judul
        $flowchartTandaPengenal = $flowcharts->filter(function($f) {
            return str_contains($f->judul, 'Tanda Pengenal');
        })->first();
        
        $flowchartMalamInaugurasi = $flowcharts->filter(function($f) {
            return str_contains($f->judul, 'Inaugurasi');
        })->first();
        
        $flowchartSafariHIMATIKA = $flowcharts->filter(function($f) {
            return str_contains($f->judul, 'Safari');
        })->first();
        
        $flowchartForumAtribut = $flowcharts->filter(function($f) {
            return str_contains($f->judul, 'Forum Atribut');
        })->first();
        
        $flowchartFormula = $flowcharts->filter(function($f) {
            return str_contains($f->judul, 'FORMULA');
        })->first();
        
        $flowchartHIntern = $flowcharts->filter(function($f) {
            return str_contains($f->judul, 'H-Intern');
        })->first();
        
        $flowchartBiodata = $flowcharts->filter(function($f) {
            return str_contains($f->judul, 'Biodata');
        })->first();
        
        $flowchartHaloWarga = $flowcharts->filter(function($f) {
            return str_contains($f->judul, 'Halo Warga');
        })->first();

        $assignments = [
            [
                'title' => 'Tugas Tanda Pengenal Angkatan',
                'description' => 'Upload foto menggunakan tanda pengenal angkatan dengan benar.',
                'deadline' => Carbon::now()->addWeeks(1),
                'submission_type' => 'image',
                'gdk_flowchart_id' => $flowchartTandaPengenal?->id,
            ],
            [
                'title' => 'Refleksi Malam Inaugurasi',
                'description' => 'Tulis refleksi pribadi tentang pengalaman malam inaugurasi.',
                'deadline' => Carbon::now()->addWeeks(2),
                'submission_type' => 'pdf',
                'gdk_flowchart_id' => $flowchartMalamInaugurasi?->id,
            ],
            [
                'title' => 'Laporan Safari HIMATIKA',
                'description' => 'Membuat laporan hasil kegiatan safari HIMATIKA dengan analisis mendalam tentang organisasi.',
                'deadline' => Carbon::now()->addWeeks(3),
                'submission_type' => 'pdf',
                'gdk_flowchart_id' => $flowchartSafariHIMATIKA?->id,
            ],
            [
                'title' => 'Essay Forum Atribut',
                'description' => 'Tulis essay tentang makna atribut HIMATIKA.',
                'deadline' => Carbon::now()->addWeeks(3),
                'submission_type' => 'pdf',
                'gdk_flowchart_id' => $flowchartForumAtribut?->id,
            ],
            [
                'title' => 'Sertifikat FORMULA',
                'description' => 'Upload sertifikat keikutsertaan seminar FORMULA.',
                'deadline' => Carbon::now()->addMonth(),
                'submission_type' => 'image',
                'gdk_flowchart_id' => $flowchartFormula?->id,
            ],
            [
                'title' => 'Laporan H-Intern',
                'description' => 'Laporan kegiatan internship yang telah dilakukan.',
                'deadline' => Carbon::now()->addMonths(2),
                'submission_type' => 'pdf',
                'gdk_flowchart_id' => $flowchartHIntern?->id,
            ],
            [
                'title' => 'Form Biodata Lengkap',
                'description' => 'Upload biodata lengkap seluruh anggota angkatan.',
                'deadline' => Carbon::now()->addWeeks(2),
                'submission_type' => 'pdf',
                'gdk_flowchart_id' => $flowchartBiodata?->id,
            ],
            [
                'title' => 'Video Halo Warga',
                'description' => 'Link video perkenalan untuk program Halo Warga.',
                'deadline' => Carbon::now()->addWeeks(1),
                'submission_type' => 'link',
                'gdk_flowchart_id' => $flowchartHaloWarga?->id,
            ],
        ];

        foreach ($assignments as $assignment) {
            Assignment::create($assignment);
        }
    }
}
