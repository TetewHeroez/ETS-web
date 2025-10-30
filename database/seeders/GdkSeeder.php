<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\GdkNilai;
use App\Models\GdkMateri;
use App\Models\GdkMetode;
use App\Models\GdkFlowchart;

class GdkSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Create Nilai entries
        $nilaiSolidaritas = GdkNilai::create([
            'nama_nilai' => 'Solidaritas',
            'deskripsi' => 'Nilai solidaritas dalam keanggotaan',
            'multiplier' => 0.4,
        ]);

        $nilaiWawasan = GdkNilai::create([
            'nama_nilai' => 'Wawasan',
            'deskripsi' => 'Nilai wawasan dan pengetahuan luas',
            'multiplier' => 0.3,
        ]);

        $nilaiAdaptif = GdkNilai::create([
            'nama_nilai' => 'Adaptif',
            'deskripsi' => 'Nilai adaptif dalam situasi dan perubahan',
            'multiplier' => 0.3,
        ]);

        // 2. Create Materi entries for Solidaritas
        $materiAngkatan = GdkMateri::create([
            'gdk_nilai_id' => $nilaiSolidaritas->id,
            'nama_materi' => 'Angkatan',
            'deskripsi' => 'Materi tentang angkatan dan solidaritas',
            'multiplier' => 1.0,
        ]);

        $metodeTandaPengenalAngkatan = GdkMetode::create([
            'gdk_materi_id' => $materiAngkatan->id,
            'nama_metode' => 'Tanda Pengenal Angkatan',
            'deskripsi' => 'Metode angkatan untuk penilaian solidaritas',
            'pa' => 'Pengenalan Tanda Pengenal',
            'pi' => 'Memakai tanda pengenal dengan benar',
            'multiplier' => 0.25,
        ]);

        $metodeMalamInaugurasi = GdkMetode::create([
            'gdk_materi_id' => $materiAngkatan->id,
            'nama_metode' => 'Malam Inaugurasi',
            'deskripsi' => 'Metode malam inaugurasi untuk penilaian solidaritas',
            'pa' => 'Malam Inaugurasi',
            'pi' => 'Memperkuat solidaritas angkatan',
            'multiplier' => 0.25,
        ]);

        $metodeIdentitasAngkatan = GdkMetode::create([
            'gdk_materi_id' => $materiAngkatan->id,
            'nama_metode' => 'Identitas Angkatan',
            'deskripsi' => 'Metode identitas angkatan untuk penilaian solidaritas',
            'pa' => 'Identitas Angkatan',
            'pi' => 'Mengenal karakter angkatan',
            'multiplier' => 0.25,
        ]);

        $metodeBiodataAngkatan = GdkMetode::create([
            'gdk_materi_id' => $materiAngkatan->id,
            'nama_metode' => 'Biodata Angkatan',
            'deskripsi' => 'Metode biodata angkatan untuk penilaian solidaritas',
            'pa' => 'Biodata Angkatan',
            'pi' => 'Mengenal setiap anggota',
            'multiplier' => 0.25,
        ]);

        // 3. Create Materi entries for Wawasan
        $materiKehimatikaan = GdkMateri::create([
            'gdk_nilai_id' => $nilaiWawasan->id,
            'nama_materi' => 'Kehimatikaan',
            'deskripsi' => 'Materi tentang keorganisasian HIMATIKA',
            'multiplier' => 1.0,
        ]);

        $metodeSafariHIMATIKA = GdkMetode::create([
            'gdk_materi_id' => $materiKehimatikaan->id,
            'nama_metode' => 'Safari HIMATIKA',
            'deskripsi' => 'Metode safari untuk penilaian wawasan',
            'pa' => 'Safari HIMATIKA',
            'pi' => 'Memahami organisasi HIMATIKA',
            'multiplier' => 0.5,
        ]);

        $metodeForumAtribut = GdkMetode::create([
            'gdk_materi_id' => $materiKehimatikaan->id,
            'nama_metode' => 'Forum Atribut',
            'deskripsi' => 'Metode forum atribut untuk penilaian wawasan',
            'pa' => 'Forum Atribut',
            'pi' => 'Memperdalam wawasan organisasi',
            'multiplier' => 0.5,
        ]);

        // 4. Create Materi entries for Adaptif
        $materiKeprofesian = GdkMateri::create([
            'gdk_nilai_id' => $nilaiAdaptif->id,
            'nama_materi' => 'Keprofesian',
            'deskripsi' => 'Materi tentang keprofesian dan karir',
            'multiplier' => 0.3,
        ]);

        $metodeFormula = GdkMetode::create([
            'gdk_materi_id' => $materiKeprofesian->id,
            'nama_metode' => 'FORMULA (Future of Real Math Unveiled by Alumni)',
            'deskripsi' => 'Materi FORMULA - program pembelajaran dari alumni',
            'pa' => 'Siap menuju dunia kerja',
            'pi' => 'Mengikuti Seminar dan Workshop',
            'multiplier' => 1.0,
        ]);

        $materiAplikatif = GdkMateri::create([
            'gdk_nilai_id' => $nilaiAdaptif->id,
            'nama_materi' => 'Aplikatif',
            'deskripsi' => 'Materi tentang aplikasi praktis keilmuan',
            'multiplier' => 0.35,
        ]);

        $metodeHIntern = GdkMetode::create([
            'gdk_materi_id' => $materiAplikatif->id,
            'nama_metode' => 'H-Intern',
            'deskripsi' => 'Metode internship dan pengalaman praktik',
            'pa' => 'H-Intern',
            'pi' => 'Mendapatkan pengalaman praktik',
            'multiplier' => 1.0,
        ]);

        $materiEtika = GdkMateri::create([
            'gdk_nilai_id' => $nilaiAdaptif->id,
            'nama_materi' => 'Etika',
            'deskripsi' => 'Materi tentang etika profesional dan sosial',
            'multiplier' => 0.35,
        ]);

        $metodeHaloWarga = GdkMetode::create([
            'gdk_materi_id' => $materiEtika->id,
            'nama_metode' => 'Halo Warga',
            'deskripsi' => 'Metode komunikasi dan interaksi dengan anggota',
            'pa' => 'Halo Warga',
            'pi' => 'Membangun komunikasi yang baik',
            'multiplier' => 1.0,
        ]);

        // Create Flowchart entries linked to Metode
        GdkFlowchart::create([
            'gdk_metode_id' => $metodeTandaPengenalAngkatan->id,
            'judul' => 'Flowchart Tanda Pengenal Angkatan',
            'deskripsi' => 'Alur kerja untuk tanda pengenal angkatan',
            'image_path' => null,
        ]);

        GdkFlowchart::create([
            'gdk_metode_id' => $metodeMalamInaugurasi->id,
            'judul' => 'Flowchart Malam Inaugurasi',
            'deskripsi' => 'Alur kerja untuk malam inaugurasi',
            'image_path' => null,
        ]);

        GdkFlowchart::create([
            'gdk_metode_id' => $metodeIdentitasAngkatan->id,
            'judul' => 'Flowchart Identitas Angkatan',
            'deskripsi' => 'Alur kerja untuk identitas angkatan',
            'image_path' => null,
        ]);

        GdkFlowchart::create([
            'gdk_metode_id' => $metodeBiodataAngkatan->id,
            'judul' => 'Flowchart Biodata Angkatan',
            'deskripsi' => 'Alur kerja untuk biodata angkatan',
            'image_path' => null,
        ]);

        GdkFlowchart::create([
            'gdk_metode_id' => $metodeSafariHIMATIKA->id,
            'judul' => 'Flowchart Safari HIMATIKA',
            'deskripsi' => 'Alur kerja untuk safari HIMATIKA',
            'image_path' => null,
        ]);

        GdkFlowchart::create([
            'gdk_metode_id' => $metodeForumAtribut->id,
            'judul' => 'Flowchart Forum Atribut',
            'deskripsi' => 'Alur kerja untuk forum atribut',
            'image_path' => null,
        ]);

        GdkFlowchart::create([
            'gdk_metode_id' => $metodeFormula->id,
            'judul' => 'Flowchart FORMULA',
            'deskripsi' => 'Alur kerja untuk program FORMULA',
            'image_path' => null,
        ]);

        GdkFlowchart::create([
            'gdk_metode_id' => $metodeHIntern->id,
            'judul' => 'Flowchart H-Intern',
            'deskripsi' => 'Alur kerja untuk program H-Intern',
            'image_path' => null,
        ]);

        GdkFlowchart::create([
            'gdk_metode_id' => $metodeHaloWarga->id,
            'judul' => 'Flowchart Halo Warga',
            'deskripsi' => 'Alur kerja untuk program Halo Warga',
            'image_path' => null,
        ]);
        
    }
}
