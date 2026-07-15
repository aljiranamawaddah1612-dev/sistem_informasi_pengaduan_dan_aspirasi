<x-app>
    <x-slot:title>{{ $title }}</x-slot:title>

    <div class="card shadow border-0 rounded-4">
        <div class="card-body p-4">
            <form action="{{ route('faq.update', $faq->id) }}" method="post" class="form">
                @csrf
                @method('put')
                <div class="mb-4">
                    <label for="pertanyaan" class="form-label required fw-bold text-muted small">PERTANYAAN</label>
                    <input type="text" name="pertanyaan" id="pertanyaan" class="form-control form-control-lg bg-light" required value="{{ old('pertanyaan', $faq->pertanyaan) }}">
                </div>
                <div class="mb-4">
                    <label for="jawaban" class="form-label required fw-bold text-muted small">JAWABAN</label>
                    <textarea name="jawaban" id="jawaban" rows="4" class="form-control bg-light" required>{{ old('jawaban', $faq->jawaban) }}</textarea>
                </div>
                <div class="form-check form-switch mb-4">
                    <input class="form-check-input" type="checkbox" id="status_aktif" name="status_aktif" value="1" {{ old('status_aktif', $faq->status_aktif) ? 'checked' : '' }}>
                    <label class="form-check-label fw-bold text-muted small" for="status_aktif">Tampilkan di Halaman Utama</label>
                </div>
                
                <hr class="my-4">
                <div class="d-flex justify-content-end gap-2">
                    <a href="{{ route('faq.index') }}" class="btn btn-light border px-4 rounded-pill fw-semibold">Batal</a>
                    <button type="submit" class="btn btn-primary px-4 rounded-pill fw-semibold shadow-sm"><i class="bx bx-check-circle me-1"></i> Update FAQ</button>
                </div>
            </form>
        </div>
    </div>
</x-app>
