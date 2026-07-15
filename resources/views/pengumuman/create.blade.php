<x-app>
    <x-slot:title>{{ $title }}</x-slot:title>

    <div class="card shadow border-0 rounded-4">
        <div class="card-body p-4">
            <form action="{{ route('pengumuman.store') }}" method="post" enctype="multipart/form-data" class="form">
                @csrf
                <div class="row">
                    <div class="col-md-8">
                        <div class="mb-4">
                            <label for="judul" class="form-label required fw-bold text-muted small">JUDUL PENGUMUMAN</label>
                            <input type="text" name="judul" id="judul" class="form-control form-control-lg bg-light" required value="{{ old('judul') }}" placeholder="Masukkan judul pengumuman...">
                        </div>
                        <div class="mb-4">
                            <label for="isi_pengumuman" class="form-label required fw-bold text-muted small">ISI PENGUMUMAN</label>
                            <textarea name="isi_pengumuman" id="isi_pengumuman" rows="5" class="form-control tinymce-editor">{{ old('isi_pengumuman') }}</textarea>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="mb-4">
                            <label for="tanggal_publish" class="form-label fw-bold text-muted small">TANGGAL PUBLISH</label>
                            <input type="date" name="tanggal_publish" id="tanggal_publish" class="form-control bg-light" value="{{ old('tanggal_publish', date('Y-m-d')) }}">
                        </div>
                        <div class="mb-4">
                            <label for="gambar" class="form-label fw-bold text-muted small">GAMBAR (OPSIONAL)</label>
                            <input type="file" name="gambar" id="upload" class="form-control bg-light" accept="image/*">
                            <div class="mt-3 text-center p-3 border rounded bg-light">
                                <img src="" id="preview" alt="Preview Gambar" class="img-fluid rounded shadow-sm" style="max-height: 200px; display: none;">
                                <div id="no-preview" class="text-muted small">Belum ada gambar yang dipilih</div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <hr class="my-4">
                <div class="d-flex justify-content-end gap-2">
                    <a href="{{ route('pengumuman.index') }}" class="btn btn-light border px-4 rounded-pill fw-semibold">Batal</a>
                    <button type="submit" class="btn btn-primary px-4 rounded-pill fw-semibold shadow-sm"><i class="bx bx-save me-1"></i> Simpan Pengumuman</button>
                </div>
            </form>
        </div>
    </div>

    @push('scripts')
    <script>
        $('#upload').on('change', function(event) {
            if (event.target.files && event.target.files[0]) {
                $('#preview').attr('src', URL.createObjectURL(event.target.files[0])).show();
                $('#no-preview').hide();
            }
        });

        // Use tinymce included in app layout
        tinymce.init({
            selector: '.tinymce-editor',
            height: 400,
            menubar: false,
            plugins: [
                'advlist autolink lists link image charmap print preview anchor',
                'searchreplace visualblocks code fullscreen',
                'insertdatetime media table paste code help wordcount'
            ],
            toolbar: 'undo redo | formatselect | ' +
            'bold italic backcolor | alignleft aligncenter ' +
            'alignright alignjustify | bullist numlist outdent indent | ' +
            'removeformat | help',
            content_style: 'body { font-family:Inter,Helvetica,Arial,sans-serif; font-size:15px }'
        });
    </script>
    @endpush
</x-app>
