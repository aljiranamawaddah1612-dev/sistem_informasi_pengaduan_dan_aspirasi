# Task 10: Optimasi, Pencarian Lanjutan, dan Keamanan (Security)

## Deskripsi
Langkah penyempurnaan aplikasi sebelum *deployment*. Berfokus pada perbaikan *User Experience* (UX) seperti pencarian/filter tabel, serta pengetatan keamanan untuk menghindari *spam* pengaduan.

## Detail Pengerjaan

1. **Integrasi DataTables / Live Search**
   - Pada halaman daftar pengaduan di sisi Admin, integrasikan jQuery DataTables bawaan NiceAdmin (atau implementasikan *live search* bawaan Laravel pagination) agar data yang banyak mudah dicari berdasarkan nama pelapor atau kata kunci isi laporan.

2. **Pengamanan Form & Anti-Spam (Rate Limiting)**
   - Pada fitur `PengaduanController@store`, tambahkan validasi *Rate Limiting* (pembatasan request). Misalnya, satu user (satu NIK) hanya boleh mengirim maksimal 3 pengaduan per hari untuk menghindari spamming.
   - Terapkan fungsi `ThrottleRequests` (middleware `throttle`) pada rute pengiriman form.

3. **Optimasi Foto Lampiran**
   - Pastikan setiap fungsi *upload image* menggunakan *resize* image atau validasi ukuran maksimal yang ketat (misal maks 2MB) agar *storage* server tidak cepat penuh.

4. **Testing & QA Akses Role (Middleware)**
   - Buat kustom Middleware (`RoleMiddleware`) untuk memastikan rute Admin benar-benar tidak bisa diakses oleh Masyarakat, begitupun sebaliknya. Pasang middleware ini secara teliti di seluruh *Route group* yang sudah dibuat di web.php.
