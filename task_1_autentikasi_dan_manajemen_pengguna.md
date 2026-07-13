# Task 1: Autentikasi dan Manajemen Pengguna (User Management)

## Deskripsi
Menyesuaikan sistem autentikasi dan manajemen pengguna yang sudah ada di Laravel agar selaras dengan kebutuhan PRD Aplikasi SIPA. Fokus pada penyesuaian field tabel `users`, *role*, serta *seeders* data dummy.

## Detail Pengerjaan

1. **Update Migration (`0001_01_01_000000_create_users_table.php`)**
   - Tambahkan field `nik` (string, unique).
   - Tambahkan field `telp` (string).
   - Ubah field enum `role` yang tadinya `['Superadmin', 'Admin']` menjadi `['admin', 'petugas', 'masyarakat']` sesuai spesifikasi PRD.
   - Atur default `role` menjadi `masyarakat`.

2. **Update Model (`app/Models/User.php`)**
   - Tambahkan `nik` dan `telp` ke dalam array `#[Fillable]`.

3. **Update Seeder & Factory**
   - **`UserFactory.php`**: Sesuaikan definisi state default untuk men-generate data `nik` (angka acak 16 digit), `telp` (angka acak), dan merandomize `role` jika tidak ditentukan.
   - **`UserSeeder.php`**: Perbarui dummy data. Buat minimal 1 akun untuk setiap role:
     - Admin: `admin@gmail.com`
     - Petugas: `petugas@gmail.com`
     - Masyarakat: `masyarakat@gmail.com`
   - Pastikan setiap akun ini memiliki `nik` dan `telp`.

4. **Update CRUD Logic (`app/Http/Controllers/UserController.php`)**
   - WAJIB mempertahankan *coding style* yang sudah ada: penggunaan `DB::beginTransaction()`, block `try-catch`, pengkondisian simpan foto (avatar), dan `to_route(...)->withSuccess(...)`.
   - **Method `store` & `update`**: Tambahkan validasi untuk input `nik` (required, unique, min 16 chars) dan `telp`. Sesuaikan validasi `role` agar menerima opsi `admin, petugas, masyarakat`.
   - Pastikan custom error validation messages (`name.required`, dll) ditambahkan untuk `nik` dan `telp`.
   - Sesuaikan tampilan Blade (`user.index`, `user.create`, `user.edit`, `user.show`) untuk menampilkan, menginput, dan memperbarui kolom `nik` dan `telp`.
