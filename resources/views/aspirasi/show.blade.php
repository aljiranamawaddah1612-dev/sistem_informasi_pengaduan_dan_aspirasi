<x-app>

    <x-slot:title>{{ $title }}</x-slot:title>

    <div class="row">
        <div class="col-md-8">
            <div class="card shadow-lg p-4 mb-4">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h4 class="fw-bold mb-0">{{ $aspirasi->judul_aspirasi }}</h4>
                    <div>
                        @if($aspirasi->status == 'tinjau')
                            <span class="badge bg-warning text-dark fs-6">Ditinjau</span>
                        @elseif($aspirasi->status == 'diterima')
                            <span class="badge bg-success fs-6">Diterima</span>
                        @endif
                    </div>
                </div>

                <div class="text-muted mb-4">
                    <i class="bx bx-calendar me-1"></i> {{ \Carbon\Carbon::parse($aspirasi->tgl_aspirasi)->format('d M Y') }} | 
                    <i class="bx bx-category me-1"></i> {{ $aspirasi->kategori->nama_kategori }} |
                    <i class="bx bx-user me-1"></i> {{ $aspirasi->user->name }}
                </div>

                <div class="mb-4">
                    <p style="white-space: pre-wrap;">{{ $aspirasi->isi_aspirasi }}</p>
                </div>

                <div class="mt-4">
                    <a href="{{ route('aspirasi.index') }}" class="btn btn-secondary">
                        <i class='bx bx-arrow-back'></i> Kembali
                    </a>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card shadow-lg p-3 text-center">
                <h6 class="fw-bold border-bottom pb-2">Bukti Lampiran</h6>
                @if($aspirasi->foto_lampiran)
                    <img src="{{ asset('storage/' . $aspirasi->foto_lampiran) }}" alt="Lampiran" class="img-fluid rounded mt-2">
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
