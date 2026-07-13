# Task 3: Manajemen Pengaduan

## Deskripsi
Membangun sistem *ticketing* keluhan/pengaduan masyarakat. Masyarakat dapat melaporkan masalah lengkap dengan bukti foto, dan memantau status pengaduannya.

## Detail Pengerjaan

1. **Migration & Model (`Pengaduan`)**
   - Buat migration tabel `pengaduans` sesuai struktur ERD:
     - `id` (bigint, PK)
     - `user_id` (bigint, FK) -> *reference to users*
     - `kategori_id` (bigint, FK) -> *reference to kategoris*
     - `tgl_pengaduan` (date)
     - `judul_laporan` (string)
     - `isi_laporan` (text)
     - `foto_lampiran` (string, nullable)
     - `status` (enum: '0', 'proses', 'selesai', 'ditolak') default '0'
   - Setup relasi Eloquent di Model `Pengaduan`:
     - `belongsTo` User (sebagai pelapor).
     - `belongsTo` Kategori.
     - `hasMany` Tanggapan.

2. **Seeder (`PengaduanSeeder`)**
   - Buat dummy pengaduan menggunakan seeder/factory, yang di-relasikan secara random ke data user dengan role "masyarakat" dan kategori yang sudah ada.
   - Buat data dengan status bervariasi (0, proses, selesai, ditolak) untuk keperluan visualisasi/testing antarmuka.

3. **Controller (`PengaduanController`)**
   - Role **Masyarakat**: Hanya bisa `create`, `store`, dan melihat daftarnya sendiri.
   - Role **Admin/Petugas**: Bisa melihat seluruh data pengaduan (`index`, `show`), mengubah status.
   - Tetap gunakan arsitektur *existing* (`DB::transaction()`, handling upload file sama seperti saat upload avatar di `UserController`).

4. **Views**
   - Buat file view yang ramah pengguna. Sertakan badge status warna-warni untuk field enum `status`.
