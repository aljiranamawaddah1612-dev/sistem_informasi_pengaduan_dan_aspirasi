<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PengaduanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $masyarakat = \App\Models\User::where('role', 'masyarakat')->first();
        $kategori1 = \App\Models\Kategori::first();
        $kategori2 = \App\Models\Kategori::skip(1)->first();

        if ($masyarakat && $kategori1) {
            \App\Models\Pengaduan::create([
                'user_id' => $masyarakat->id,
                'kategori_id' => $kategori1->id,
                'tgl_pengaduan' => now()->subDays(5)->toDateString(),
                'judul_laporan' => 'Jalan berlubang di depan pasar',
                'isi_laporan' => 'Terdapat banyak lubang besar yang membahayakan pengendara roda dua.',
                'status' => 'proses',
            ]);

            \App\Models\Pengaduan::create([
                'user_id' => $masyarakat->id,
                'kategori_id' => $kategori2->id,
                'tgl_pengaduan' => now()->subDays(2)->toDateString(),
                'judul_laporan' => 'Pelayanan kelurahan lambat',
                'isi_laporan' => 'Antrian pembuatan KTP sangat lama dan petugas tidak ramah.',
                'status' => '0',
            ]);
            
            \App\Models\Pengaduan::create([
                'user_id' => $masyarakat->id,
                'kategori_id' => $kategori1->id,
                'tgl_pengaduan' => now()->subDays(10)->toDateString(),
                'judul_laporan' => 'Lampu jalan mati',
                'isi_laporan' => 'Lampu PJU di jalan merdeka mati sejak seminggu lalu.',
                'status' => 'selesai',
            ]);
        }
    }
}
