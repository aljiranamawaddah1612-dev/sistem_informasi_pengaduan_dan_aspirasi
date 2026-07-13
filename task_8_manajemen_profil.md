# Task 8: Manajemen Profil Pengguna

## Deskripsi
Fitur bagi seluruh pengguna (Admin, Petugas, dan Masyarakat) untuk dapat memperbarui data pribadi mereka, termasuk mengganti foto avatar, nomor telepon, dan memperbarui kata sandi (password).

## Detail Pengerjaan

1. **Profile Controller (`ProfileController`)**
   - Buat controller khusus untuk menangani update profil user yang sedang login (`Auth::user()`).
   - Buat method `edit` dan `update`.
   - Buat method `updatePassword`.

2. **Validasi & Logika Update**
   - Gunakan aturan validasi serupa dengan `UserController` saat mengunggah `avatar` (validasi image, mimes, ukuran max).
   - Pastikan update profil menggunakan `DB::beginTransaction()`.
   - Untuk update password, pastikan ada pengecekan "Old Password" menggunakan `Hash::check()`, validasi "New Password" minimum 8 karakter, dan "Confirm Password".

3. **Views (`profile.edit`)**
   - Manfaatkan komponen *Profile* bawaan NiceAdmin yang biasanya terdapat di halaman profil.
   - Pisahkan tab antara "Overview", "Edit Profile", dan "Change Password" sesuai desain NiceAdmin.
