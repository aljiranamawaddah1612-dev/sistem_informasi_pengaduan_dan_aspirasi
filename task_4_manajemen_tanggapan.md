# Task 4: Manajemen Tanggapan

## Deskripsi
Fitur spesifik bagi Petugas dan Admin untuk menindaklanjuti atau membalas pengaduan yang masuk dari masyarakat.

## Detail Pengerjaan

1. **Migration & Model (`Tanggapan`)**
   - Buat migration `tanggapans` dengan struktur:
     - `id` (bigint, PK)
     - `pengaduan_id` (bigint, FK) -> *reference to pengaduans*
     - `petugas_id` (bigint, FK) -> *reference to users (role: petugas/admin)*
     - `tgl_tanggapan` (date)
     - `isi_tanggapan` (text)
   - Setup relasi `belongsTo` Pengaduan dan `belongsTo` User (sebagai petugas).

2. **Seeder (`TanggapanSeeder`)**
   - Buat data dummy balasan petugas. Relasikan dengan data pengaduan dummy yang statusnya "proses" atau "selesai". Pastikan `petugas_id` diambil dari user dengan role petugas.

3. **Controller (`TanggapanController`)**
   - Aksi untuk menginput balasan/tindak lanjut terhadap suatu pengaduan.
   - Saat Tanggapan ditambahkan, sistem sebaiknya sekaligus mengupdate `status` pada tabel Pengaduan (misal otomatis menjadi "selesai"). Lakukan ini dalam satu blok `DB::beginTransaction()`.
   - Pastikan validasi isi tanggapan sesuai standar kustom pesan error.

4. **Views**
   - Tanggapan biasanya ditampilkan di halaman detail pengaduan (`pengaduan.show`).
   - Buatkan form input di sana khusus untuk user yang login sebagai Petugas/Admin.
