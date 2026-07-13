<x-app>

    <x-slot:title>{{ $title }}</x-slot:title>

    <div class="row">
        <div class="col-md-8">
            <div class="card shadow-lg p-4 mb-4">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h4 class="fw-bold mb-0">{{ $pengaduan->judul_laporan }}</h4>
                    <div>
                        @if($pengaduan->status == '0')
                            <span class="badge bg-secondary fs-6">Menunggu</span>
                        @elseif($pengaduan->status == 'proses')
                            <span class="badge bg-warning text-dark fs-6">Diproses</span>
                        @elseif($pengaduan->status == 'selesai')
                            <span class="badge bg-success fs-6">Selesai</span>
                        @elseif($pengaduan->status == 'ditolak')
                            <span class="badge bg-danger fs-6">Ditolak</span>
                        @endif
                    </div>
                </div>

                <div class="text-muted mb-4">
                    <i class="bx bx-calendar me-1"></i> {{ \Carbon\Carbon::parse($pengaduan->tgl_pengaduan)->format('d M Y') }} | 
                    <i class="bx bx-category me-1"></i> {{ $pengaduan->kategori->nama_kategori }} |
                    <i class="bx bx-user me-1"></i> {{ $pengaduan->user->name }}
                </div>

                <div class="mb-4">
                    <p style="white-space: pre-wrap;">{{ $pengaduan->isi_laporan }}</p>
                </div>
            </div>

            <!-- Menampilkan Daftar Tanggapan -->
            <h5 class="fw-bold mb-3"><i class='bx bx-chat'></i> Tindak Lanjut / Tanggapan</h5>
            
            @forelse($pengaduan->tanggapans as $tanggapan)
            <div class="card shadow-sm mb-3 border-start border-4 border-primary">
                <div class="card-body py-3">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <span class="fw-bold text-primary">{{ $tanggapan->user->name }} ({{ $tanggapan->user->role }})</span>
                        <small class="text-muted">{{ \Carbon\Carbon::parse($tanggapan->tgl_tanggapan)->format('d M Y') }}</small>
                    </div>
                    <p class="mb-0" style="white-space: pre-wrap;">{{ $tanggapan->tanggapan }}</p>
                </div>
            </div>
            @empty
            <div class="alert alert-secondary">
                Belum ada tanggapan.
            </div>
            @endforelse

            <!-- Form Tanggapan untuk Admin/Petugas -->
            @if(Auth::user()->role != 'masyarakat')
            <div class="card shadow-lg p-4 mt-4 bg-light">
                <h6 class="fw-bold mb-3">Berikan Tanggapan & Update Status</h6>
                <form action="{{ route('tanggapan.store') }}" method="POST" class="form">
                    @csrf
                    <input type="hidden" name="pengaduan_id" value="{{ $pengaduan->id }}">

                    <div class="mb-3">
                        <label for="status" class="form-label required">Ubah Status Laporan</label>
                        <select class="form-select @error('status') is-invalid @enderror" name="status" id="status" required>
                            <option value="proses" @selected($pengaduan->status == 'proses')>Diproses</option>
                            <option value="selesai" @selected($pengaduan->status == 'selesai')>Selesai</option>
                            <option value="ditolak" @selected($pengaduan->status == 'ditolak')>Ditolak</option>
                        </select>
                        @error('status')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="tanggapan" class="form-label required">Isi Tanggapan</label>
                        <textarea name="tanggapan" id="tanggapan" rows="4" class="form-control @error('tanggapan') is-invalid @enderror" required>{{ old('tanggapan') }}</textarea>
                        @error('tanggapan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="text-end">
                        <button type="submit" class="btn btn-primary">Kirim Tanggapan</button>
                    </div>
                </form>
            </div>
            @endif

            <div class="mt-4">
                <a href="{{ route('pengaduan.index') }}" class="btn btn-secondary">
                    <i class='bx bx-arrow-back'></i> Kembali
                </a>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card shadow-lg p-3 text-center">
                <h6 class="fw-bold border-bottom pb-2">Bukti Lampiran</h6>
                @if($pengaduan->foto_lampiran)
                    <img src="{{ asset('storage/' . $pengaduan->foto_lampiran) }}" alt="Lampiran" class="img-fluid rounded mt-2">
                @else
                    <div class="text-muted mt-3 py-4 border rounded bg-light">
                        <i class='bx bx-image-alt fs-1'></i>
                        <p class="mb-0">Tidak ada lampiran</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

</x-app>
