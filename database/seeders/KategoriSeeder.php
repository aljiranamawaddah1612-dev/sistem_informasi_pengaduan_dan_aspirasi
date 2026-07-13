<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class KategoriSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $kategoris = [
            ['nama_kategori' => 'Infrastruktur', 'deskripsi' => 'Pengaduan terkait jalan rusak, jembatan, bangunan umum, dll.'],
            ['nama_kategori' => 'Pelayanan Publik', 'deskripsi' => 'Keluhan terhadap layanan aparat atau instansi.'],
            ['nama_kategori' => 'Keamanan', 'deskripsi' => 'Laporan masalah ketertiban umum dan keamanan.'],
            ['nama_kategori' => 'Lingkungan', 'deskripsi' => 'Sampah, pencemaran, atau masalah lingkungan lainnya.'],
        ];

        foreach ($kategoris as $kategori) {
            \App\Models\Kategori::create($kategori);
        }
    }
}
