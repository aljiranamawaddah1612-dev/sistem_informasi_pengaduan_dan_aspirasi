# Task 9: Export Laporan (Cetak PDF / Excel)

## Deskripsi
Fitur rekapitulasi pelaporan tingkat lanjut yang memungkinkan Admin atau Pimpinan mengunduh data pengaduan dalam bentuk dokumen resmi (PDF) atau spreadsheet (Excel/CSV) untuk keperluan rapat evaluasi instansi.

## Detail Pengerjaan

1. **Instalasi Package Pendukung**
   - Package Laravel DomPDF (dari `barryvdh/laravel-dompdf`) sudah terinstal sebelumnya via `composer install` bawaan NiceAdmin default. Jika belum, lakukan instalasi.
   - (Opsional) Install `maatwebsite/excel` jika memerlukan fitur ekspor Excel.

2. **Laporan Controller (`LaporanController`)**
   - Buat fungsi `index` untuk menampilkan halaman filter. Di halaman ini, Admin bisa memasukkan tanggal mulai (`start_date`) dan tanggal akhir (`end_date`), serta opsi filter berdasarkan `kategori` atau `status`.
   - Buat fungsi `exportPdf` yang merender data hasil filter ke file view HTML khusus cetak, lalu menggunakan `Pdf::loadView(...)` untuk men-generate file PDF.

3. **Views (Form Cetak & Template Laporan)**
   - View Filter: Form sederhana di dashboard admin.
   - View Laporan Cetak: Template HTML polos dengan kop surat instansi (jika ada), tabel data pengaduan (Nomor, Nama Pelapor, Kategori, Tanggal, Status), yang desainnya ramah cetak (A4).
