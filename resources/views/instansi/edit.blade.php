<x-app>
    <x-slot:title>{{ $title }}</x-slot:title>

    <div class="card shadow border-0 rounded-4">
        <div class="card-body p-4">
            <form action="{{ route('instansi.update', $instansi->id) }}" method="post" class="form">
                @csrf
                @method('put')
                <div class="mb-4">
                    <label for="nama_instansi" class="form-label required fw-bold text-muted small">NAMA INSTANSI</label>
                    <input type="text" name="nama_instansi" id="nama_instansi" class="form-control form-control-lg bg-light" required value="{{ old('nama_instansi', $instansi->nama_instansi) }}">
                </div>
                <div class="mb-4">
                    <label for="kontak" class="form-label fw-bold text-muted small">KONTAK (Opsional)</label>
                    <input type="text" name="kontak" id="kontak" class="form-control bg-light" value="{{ old('kontak', $instansi->kontak) }}">
                </div>
                <div class="mb-4">
                    <label for="deskripsi" class="form-label fw-bold text-muted small">DESKRIPSI (Opsional)</label>
                    <textarea name="deskripsi" id="deskripsi" rows="4" class="form-control bg-light">{{ old('deskripsi', $instansi->deskripsi) }}</textarea>
                </div>
                
                <hr class="my-4">
                <div class="d-flex justify-content-end gap-2">
                    <a href="{{ route('instansi.index') }}" class="btn btn-light border px-4 rounded-pill fw-semibold">Batal</a>
                    <button type="submit" class="btn btn-primary px-4 rounded-pill fw-semibold shadow-sm"><i class="bx bx-check-circle me-1"></i> Update Instansi</button>
                </div>
            </form>
        </div>
    </div>
</x-app>
