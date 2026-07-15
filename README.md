# Aplikasi Sistem Informasi Pengaduan dan Aspirasi (SIPA)

Platform terpusat yang memudahkan masyarakat untuk menyampaikan keluhan, laporan masalah, serta saran (aspirasi) kepada pihak instansi atau pemerintah secara transparan, aman, dan mudah dilacak proses penyelesaiannya.

## 🚀 Fitur Utama

- **Autentikasi & Manajemen Akun**: Registrasi dengan validasi NIK (Nomor Induk Kependudukan), login, dan manajemen profil pengguna berdasarkan Role (Masyarakat, Petugas, Admin).
- **Manajemen Pengaduan (Ticketing)**: Form pelaporan dilengkapi dengan bukti foto, deskripsi, lokasi, dan kategori masalah. Pengguna mendapatkan nomor tiket pelacakan.
- **Manajemen Aspirasi**: Form khusus untuk menampung ide dan saran pembangunan dari publik.
- **Tracking & Notifikasi Status**: Status pengaduan (Menunggu, Diproses, Selesai, Ditolak) yang ter-update secara real-time.
- **Tanggapan Petugas**: Fitur bagi petugas untuk membalas laporan secara langsung di thread pengaduan.
- **Dashboard & Laporan (Reporting)**: Visualisasi data (chart/grafik) jumlah laporan per kategori, laporan bulan ini, serta fitur export laporan (PDF/Excel) untuk rapat evaluasi.

## 👥 Target Pengguna

- **Masyarakat (Pelapor)**: Warga yang ingin menyampaikan keluhan atau memberikan saran aspirasi.
- **Petugas (Verifikator/Responder)**: Tim internal instansi yang bertugas memverifikasi laporan masuk, meninjau lapangan, dan memberikan tanggapan resmi.
- **Admin / Pimpinan**: Mengelola seluruh data pengguna, kategori, serta memantau statistik penyelesaian pengaduan.

## 🛠️ Stack Teknologi

- **Backend**: PHP 8.2+ & Laravel 11
- **Frontend**: Blade Template Engine, Bootstrap 5 (NiceAdmin Template)
- **Database**: MySQL / SQLite
- **Autentikasi & Keamanan**: Built-in Laravel Auth, CSRF Protection, Password Hashing (Bcrypt)

## 💻 Instalasi Lokal

Ikuti langkah-langkah berikut untuk menjalankan proyek di mesin lokal Anda:

1. **Clone Repositori**:

    ```bash
    git clone <repository-url>
    cd uas
    ```

2. **Instal Dependensi PHP**:

    ```bash
    composer install
    ```

3. **Instal Dependensi JavaScript**:

    ```bash
    npm install
    ```

4. **Konfigurasi Lingkungan**:
   Salin file `.env.example` menjadi `.env` dan generate key. Konfigurasi database jika menggunakan MySQL, atau biarkan default untuk SQLite:

    ```bash
    cp .env.example .env
    php artisan key:generate
    ```

5. **Setup Database (SQLite)**:
   Buat file database kosong dan jalankan migrasi beserta seeder:

    ```bash
    touch database/database.sqlite
    php artisan migrate --seed
    ```

6. **Jalankan Aplikasi**:
   Jalankan server pengembangan Laravel dan proses build Vite:

    ```bash
    php artisan serve
    # Buka tab terminal baru:
    npm run dev
    ```

## 📄 Lisensi

Proyek ini bersifat open-source di bawah lisensi [MIT](https://opensource.org/licenses/MIT).
