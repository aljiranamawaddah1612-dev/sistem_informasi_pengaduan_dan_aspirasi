# Task 6: Dashboard dan Pelaporan

## Deskripsi
Menyajikan rangkuman dan statistik seluruh proses pengaduan dan aspirasi bagi Admin dan Pimpinan agar mempermudah pengambilan keputusan.

## Detail Pengerjaan

1. **Dashboard Controller Updates**
   - Update `app/Http/Controllers/DashboardController.php` untuk mengambil metrik utama.
   - Hitung total Pengaduan Masuk, Diproses, dan Selesai.
   - Hitung total Aspirasi.
   - Persiapkan data array untuk divisualisasikan dalam bentuk grafik (misal: pengaduan per bulan atau pengaduan per kategori).

2. **Dashboard View**
   - Tampilkan *cards summary* angka-angka tersebut.
   - Integrasikan chart bawaan NiceAdmin (misal ApexCharts/Chart.js) dengan data dinamis dari Controller.

3. **Fitur Export Laporan**
   - Tambahkan fungsi untuk mem-filter data pengaduan berdasarkan rentang tanggal.
   - Gunakan package (seperti Laravel DomPDF yang sudah terinstal dari NiceAdmin default/vendor) untuk mencetak laporan rekapitulasi pengaduan.
   - Tambahkan *button* Cetak Laporan di UI Admin.
