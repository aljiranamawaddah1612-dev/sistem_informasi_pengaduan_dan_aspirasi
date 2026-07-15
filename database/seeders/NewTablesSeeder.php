<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class NewTablesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Seed Instansi
        \App\Models\Instansi::create([
            'nama_instansi' => 'Dinas Pendidikan',
            'deskripsi' => 'Dinas yang mengurus pendidikan.',
            'kontak' => '021-123456',
        ]);
        \App\Models\Instansi::create([
            'nama_instansi' => 'Dinas Kesehatan',
            'deskripsi' => 'Dinas yang mengurus kesehatan dan rumah sakit.',
            'kontak' => '021-654321',
        ]);

        // 2. Seed Wilayah
        \App\Models\Wilayah::create([
            'nama_wilayah' => 'Kecamatan Tamalanrea',
            'kode_pos' => '90245',
        ]);
        \App\Models\Wilayah::create([
            'nama_wilayah' => 'Kecamatan Biringkanaya',
            'kode_pos' => '90241',
        ]);

        // 3. Seed FAQ
        \App\Models\Faq::create([
            'pertanyaan' => 'Bagaimana cara membuat laporan pengaduan?',
            'jawaban' => 'Silakan login terlebih dahulu, lalu masuk ke menu Pengaduan dan klik Tambah Laporan.',
            'status_aktif' => true,
        ]);
        \App\Models\Faq::create([
            'pertanyaan' => 'Berapa lama laporan saya akan diproses?',
            'jawaban' => 'Laporan akan diverifikasi dalam waktu maksimal 2x24 jam kerja oleh admin atau petugas.',
            'status_aktif' => true,
        ]);

        // 4. Seed Pengumuman (needs a valid user_id for penulis_id)
        $admin = \App\Models\User::where('role', 'admin')->first();
        if ($admin) {
            \App\Models\Pengumuman::create([
                'judul' => 'Pembaruan Sistem Aplikasi SIPA v2.0',
                'isi_pengumuman' => '<p>Diberitahukan kepada seluruh masyarakat bahwa sistem pengaduan kini telah diupdate dengan berbagai fitur baru seperti ulasan laporan, dan FAQ.</p>',
                'tanggal_publish' => now(),
                'penulis_id' => $admin->id,
            ]);
        }

        // 5. Seed Ulasan (needs valid user_id and pengaduan_id)
        $user = \App\Models\User::where('role', 'masyarakat')->first();
        $pengaduan = \App\Models\Pengaduan::first();
        
        if ($user && $pengaduan) {
            \App\Models\Ulasan::create([
                'user_id' => $user->id,
                'pengaduan_id' => $pengaduan->id,
                'rating' => 5,
                'komentar' => 'Penanganan sangat cepat dan responsif. Terima kasih!',
            ]);
        }
    }
}
