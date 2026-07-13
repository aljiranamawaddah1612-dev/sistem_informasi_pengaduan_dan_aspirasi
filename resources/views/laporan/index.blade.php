<x-app>
    <x-slot:title>{{ $title }}</x-slot:title>

    <div class="card shadow-lg p-4 mb-4">
        <h5 class="fw-bold mb-3"><i class='bx bx-filter-alt text-primary'></i> Filter & Cetak Laporan</h5>
        
        <form action="{{ route('laporan.index') }}" method="GET" class="row g-3 align-items-end">
            <div class="col-md-3">
                <label for="start_date" class="form-label">Tanggal Mulai</label>
                <input type="date" class="form-control" name="start_date" id="start_date" value="{{ $start_date }}">
            </div>
            <div class="col-md-3">
                <label for="end_date" class="form-label">Tanggal Akhir</label>
                <input type="date" class="form-control" name="end_date" id="end_date" value="{{ $end_date }}">
            </div>
            <div class="col-md-2">
                <label for="kategori_id" class="form-label">Kategori</label>
                <select name="kategori_id" id="kategori_id" class="form-select">
                    <option value="">Semua Kategori</option>
                    @foreach($kategoris as $kategori)
                        <option value="{{ $kategori->id }}" @selected($kategori_id == $kategori->id)>{{ $kategori->nama_kategori }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <label for="status" class="form-label">Status</label>
                <select name="status" id="status" class="form-select">
                    <option value="">Semua Status</option>
                    <option value="0" @selected($status === '0')>Menunggu</option>
                    <option value="proses" @selected($status === 'proses')>Diproses</option>
                    <option value="selesai" @selected($status === 'selesai')>Selesai</option>
                    <option value="ditolak" @selected($status === 'ditolak')>Ditolak</option>
                </select>
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-primary w-100">
                    Terapkan
                </button>
            </div>
        </form>

        <div class="d-flex justify-content-end gap-2 mt-4">
            <a href="{{ route('laporan.exportPdf', request()->all()) }}" class="btn btn-danger">
                <i class='bx bxs-file-pdf'></i> Export PDF
            </a>
            <a href="{{ route('laporan.exportExcel', request()->all()) }}" class="btn btn-success">
                <i class='bx bxs-file-export'></i> Export Excel
            </a>
        </div>
    </div>

    <div class="card shadow-lg p-3">
        <div class="table-responsive">
            <table class="table table-bordered table-striped w-100">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Tanggal</th>
                        <th scope="col">Pelapor</th>
                        <th scope="col">Kategori</th>
                        <th scope="col">Judul Laporan</th>
                        <th scope="col">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($pengaduans as $pengaduan)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ \Carbon\Carbon::parse($pengaduan->tgl_pengaduan)->format('d M Y') }}</td>
                            <td>{{ $pengaduan->user->name }}</td>
                            <td>{{ $pengaduan->kategori->nama_kategori }}</td>
                            <td>{{ $pengaduan->judul_laporan }}</td>
                            <td>
                                @if($pengaduan->status == '0')
                                    <span class="badge bg-secondary">Menunggu</span>
                                @elseif($pengaduan->status == 'proses')
                                    <span class="badge bg-warning text-dark">Diproses</span>
                                @elseif($pengaduan->status == 'selesai')
                                    <span class="badge bg-success">Selesai</span>
                                @elseif($pengaduan->status == 'ditolak')
                                    <span class="badge bg-danger">Ditolak</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center">Tidak ada data ditemukan</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</x-app>
