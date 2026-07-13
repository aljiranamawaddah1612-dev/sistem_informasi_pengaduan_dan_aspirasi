# Task 2: Kategori Pengaduan dan Aspirasi

## Deskripsi
Membuat modul Master Data Kategori untuk mengklasifikasikan jenis masalah/saran, seperti Infrastruktur, Pelayanan, Kebersihan, dan lainnya.

## Detail Pengerjaan

1. **Migration & Model (`Kategori`)**
   - Buat migration tabel `kategoris` dengan struktur:
     - `id` (bigint, PK)
     - `nama_kategori` (string)
     - `deskripsi` (text, nullable)
     - `timestamps`
   - Buat Model `Kategori.php` dengan `$fillable` yang sesuai.

2. **Seeder (`KategoriSeeder`)**
   - Buat dummy data dengan Seeder untuk kategori umum (misal: "Infrastruktur", "Pelayanan Publik", "Keamanan", "Lingkungan").
   - Panggil class seeder ini di dalam `DatabaseSeeder.php`.

3. **Controller (`KategoriController`)**
   - Buat fungsi CRUD lengkap (index, create, store, edit, update, destroy).
   - Terapkan standar penulisan *existing*:
     - Validasi data (`required`, pesan error kustom).
     - Penggunaan `DB::beginTransaction()` dan `DB::commit()` / `DB::rollBack()`.
     - *Flash message* success dan error.

4. **Views**
   - Buat file view Blade (index, create, edit) yang mengadopsi UI NiceAdmin yang sudah ada.
