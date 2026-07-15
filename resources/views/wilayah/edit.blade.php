<x-app>
    <x-slot:title>{{ $title }}</x-slot:title>

    <div class="card shadow border-0 rounded-4">
        <div class="card-body p-4">
            <form action="{{ route('wilayah.update', $wilayah->id) }}" method="post" class="form">
                @csrf
                @method('put')
                <div class="mb-4">
                    <label for="nama_wilayah" class="form-label required fw-bold text-muted small">NAMA WILAYAH / DESA</label>
                    <input type="text" name="nama_wilayah" id="nama_wilayah" class="form-control form-control-lg bg-light" required value="{{ old('nama_wilayah', $wilayah->nama_wilayah) }}">
                </div>
                <div class="mb-4">
                    <label for="kode_pos" class="form-label fw-bold text-muted small">KODE POS (Opsional)</label>
                    <input type="text" name="kode_pos" id="kode_pos" class="form-control bg-light" value="{{ old('kode_pos', $wilayah->kode_pos) }}">
                </div>
                
                <hr class="my-4">
                <div class="d-flex justify-content-end gap-2">
                    <a href="{{ route('wilayah.index') }}" class="btn btn-light border px-4 rounded-pill fw-semibold">Batal</a>
                    <button type="submit" class="btn btn-primary px-4 rounded-pill fw-semibold shadow-sm"><i class="bx bx-check-circle me-1"></i> Update Wilayah</button>
                </div>
            </form>
        </div>
    </div>
</x-app>
