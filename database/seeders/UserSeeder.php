<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            [
                'nik' => '1234567890123456',
                'name' => 'Admin Sistem',
                'email' => 'admin@gmail.com',
                'telp' => '081234567890',
                'role' => 'admin',
            ],
            [
                'nik' => '2345678901234567',
                'name' => 'Petugas Lapangan',
                'email' => 'petugas@gmail.com',
                'telp' => '082345678901',
                'role' => 'petugas',
            ],
            [
                'nik' => '3456789012345678',
                'name' => 'Masyarakat Umum',
                'email' => 'masyarakat@gmail.com',
                'telp' => '083456789012',
                'role' => 'masyarakat',
            ],
        ];

        foreach ($users as $user) {
            if (User::where('email', $user['email'])->exists()) {
                continue;
            }

            User::factory()->create([
                'nik' => $user['nik'],
                'name' => $user['name'],
                'email' => $user['email'],
                'telp' => $user['telp'],
                'role' => $user['role'],
            ]);
        }
    }
}
