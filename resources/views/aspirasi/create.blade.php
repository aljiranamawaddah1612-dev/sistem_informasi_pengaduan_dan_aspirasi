<x-app>

    <x-slot:title>{{ $title }}</x-slot:title>

    <div class="card shadow-lg p-3">

        <form action="{{ route('aspirasi.store') }}" method="post" enctype="multipart/form-data" class="form">
            @csrf

            <div class="row g-3 mb-3">
                <div class="col-md-4">
                    <label for="foto_lampiran" class="form-label">Bukti Foto / Sketsa (Opsional)</label>
                    <input class="form-control @error('foto_lampiran') is-invalid  @enderror" type="file" id="upload"
                        name="foto_lampiran" accept="image/*">
                    @error('foto_lampiran')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                    <img src="{{ asset('niceadmin/img/notfound.png') }}" alt="Preview" class="w-100 rounded mt-2"
                        id="preview">
                </div>

                <div class="col-md-8">
                    <div class="mb-3">
                        <label for="kategori_id" class="form-label required">Kategori Aspirasi</label>
                        <select class="form-select select2-default @error('kategori_id') is-invalid  @enderror" id="kategori_id"
                            name="kategori_id" required>
                            <option value="">Pilih Kategori</option>
                            @foreach ($kategoris as $kategori)
                                <option value="{{ $kategori->id }}" @selected(old('kategori_id') == $kategori->id)>{{ $kategori->nama_kategori }}</option>
                            @endforeach
                        </select>
                        @error('kategori_id')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="judul_aspirasi" class="form-label required">Judul Ide / Saran</label>
                        <input class="form-control @error('judul_aspirasi') is-invalid  @enderror" type="text" id="judul_aspirasi"
                            name="judul_aspirasi" required value="{{ old('judul_aspirasi') }}">
                        @error('judul_aspirasi')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="isi_aspirasi" class="form-label required">Detail Penjelasan</label>
                        <textarea class="form-control @error('isi_aspirasi') is-invalid  @enderror" id="isi_aspirasi"
                            name="isi_aspirasi" rows="5" required>{{ old('isi_aspirasi') }}</textarea>
                        @error('isi_aspirasi')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="text-end">
                <a href="{{ route('aspirasi.index') }}" class="btn btn-warning me-1">Batal</a>
                <button type="submit" class="btn btn-primary">Kirim Aspirasi</button>
            </div>

        </form>

    </div>

</x-app>
