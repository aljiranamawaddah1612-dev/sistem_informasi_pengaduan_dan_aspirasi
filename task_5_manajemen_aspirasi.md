# Task 5: Manajemen Aspirasi

## Deskripsi
Modul untuk menampung ide dan saran dari masyarakat yang tidak selalu menuntut tindak lanjut seperti halnya pengaduan, namun tetap dicatat dalam sistem dan dievaluasi (ditinjau/diterima).

## Detail Pengerjaan

1. **Migration & Model (`Aspirasi`)**
   - Buat migration `aspirasis` sesuai ERD:
     - `id` (bigint, PK)
     - `user_id` (bigint, FK)
     - `kategori_id` (bigint, FK)
     - `tgl_aspirasi` (date)
     - `judul_aspirasi` (string)
     - `isi_aspirasi` (text)
     - `foto_lampiran` (string, nullable)
     - `status` (enum: 'tinaju', 'diterima') default 'tinjau'
   - Setup relasi Eloquent (`belongsTo` User, `belongsTo` Kategori) di Model `Aspirasi.php`.

2. **Seeder (`AspirasiSeeder`)**
   - Buat dummy data saran/ide dari masyarakat dengan status 'tinjau' dan 'diterima'.

3. **Controller (`AspirasiController`)**
   - Logika CRUD standar.
   - Masyarakat: `create` dan `store` ide, melihat riwayat idenya.
   - Admin/Petugas: me-`review` dan mengubah `status` aspirasi.
   - Konsisten dengan pola upload gambar (`foto_lampiran`) menggunakan `Storage` layaknya avatar.

4. **Views**
   - Sesuaikan *list view* aspirasi dan *form submission* agar intuitif dan selaras dengan *template* NiceAdmin.
