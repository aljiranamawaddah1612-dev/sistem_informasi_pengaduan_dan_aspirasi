# Task 7: Sistem Notifikasi dan Tracking Status

## Deskripsi
Membangun fitur untuk memberikan pemberitahuan (notifikasi) kepada masyarakat (pelapor) setiap kali ada perubahan status pada pengaduan mereka, serta notifikasi bagi Petugas saat ada laporan baru masuk.

## Detail Pengerjaan

1. **Konfigurasi Database Notifikasi**
   - Laravel memiliki fitur bawaan untuk notifikasi. Jalankan `php artisan notifications:table` lalu `migrate` untuk membuat tabel `notifications`.

2. **Pembuatan Class Notifikasi (`Notification`)**
   - Buat class `StatusPengaduanUpdated` (via `php artisan make:notification`).
   - Setup channel notifikasi via `database` (in-app notification).
   - (Opsional) Setup via `mail` jika `.env` SMTP sudah dikonfigurasi.

3. **Integrasi dengan Controller**
   - Di `TanggapanController` atau `PengaduanController` (saat update status/balas pesan), panggil notifikasi ke user (pelapor). `Notification::send($pengaduan->user, new StatusPengaduanUpdated($pengaduan));`
   - Di `PengaduanController` (saat laporan baru masuk), beri notifikasi ke semua user yang role-nya `admin` atau `petugas`.

4. **Views (UI Notifikasi)**
   - Manfaatkan ikon *bell* (lonceng) pada header *template* NiceAdmin.
   - Tampilkan *dropdown* daftar notifikasi *unread*.
   - Buat fungsi agar saat diklik, notifikasi ditandai sebagai *read* (`markAsRead()`) dan *redirect* ke halaman detail pengaduan yang bersangkutan.
