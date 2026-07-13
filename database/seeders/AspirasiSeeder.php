<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AspirasiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $masyarakat = \App\Models\User::where('role', 'masyarakat')->first();
        $kategori = \App\Models\Kategori::first();

        if ($masyarakat && $kategori) {
            \App\Models\Aspirasi::create([
                'user_id' => $masyarakat->id,
                'kategori_id' => $kategori->id,
                'tgl_aspirasi' => now()->subDays(3)->toDateString(),
                'judul_aspirasi' => 'Pembangunan Taman Bermain',
                'isi_aspirasi' => 'Sebaiknya ada taman bermain anak di sekitar perumahan agar anak-anak memiliki fasilitas umum.',
                'status' => 'tinjau',
            ]);

            \App\Models\Aspirasi::create([
                'user_id' => $masyarakat->id,
                'kategori_id' => $kategori->id,
                'tgl_aspirasi' => now()->subDays(10)->toDateString(),
                'judul_aspirasi' => 'Penambahan Armada Sampah',
                'isi_aspirasi' => 'Mengingat jumlah penduduk yang meningkat, tolong ditambah armada angkut sampah setiap hari jumat.',
                'status' => 'diterima',
            ]);
        }
    }
}
