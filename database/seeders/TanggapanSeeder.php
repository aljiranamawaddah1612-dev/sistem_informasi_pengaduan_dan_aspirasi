<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TanggapanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = \App\Models\User::where('role', 'admin')->first();
        $pengaduan = \App\Models\Pengaduan::where('status', 'selesai')->first();

        if ($admin && $pengaduan) {
            \App\Models\Tanggapan::create([
                'pengaduan_id' => $pengaduan->id,
                'user_id' => $admin->id,
                'tgl_tanggapan' => now()->subDays(9)->toDateString(),
                'tanggapan' => 'Terima kasih atas laporannya. Kami telah berkoordinasi dengan dinas terkait dan lampu jalan sudah diperbaiki.',
            ]);
        }
    }
}
