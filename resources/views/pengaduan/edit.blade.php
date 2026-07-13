<x-app>

    <x-slot:title>{{ $title }}</x-slot:title>

    <div class="card shadow-lg p-3">

        <form action="{{ route('pengaduan.update', $pengaduan) }}" method="post" class="form">
            @csrf
            @method('put')

            <div class="row mb-3">
                <div class="col-md-12">
                    <h5>Judul: {{ $pengaduan->judul_laporan }}</h5>
                    <p>Status Saat Ini: 
                        @if($pengaduan->status == '0')
                            <span class="badge bg-secondary">Menunggu</span>
                        @elseif($pengaduan->status == 'proses')
                            <span class="badge bg-warning text-dark">Diproses</span>
                        @elseif($pengaduan->status == 'selesai')
                            <span class="badge bg-success">Selesai</span>
                        @elseif($pengaduan->status == 'ditolak')
                            <span class="badge bg-danger">Ditolak</span>
                        @endif
                    </p>
                </div>
            </div>

            <div class="mb-3">
                <label for="status" class="form-label required">Update Status Menjadi</label>
                <select class="form-select @error('status') is-invalid  @enderror" id="status"
                    name="status" required>
                    <option value="0" @selected($pengaduan->status == '0')>Menunggu</option>
                    <option value="proses" @selected($pengaduan->status == 'proses')>Diproses</option>
                    <option value="selesai" @selected($pengaduan->status == 'selesai')>Selesai</option>
                    <option value="ditolak" @selected($pengaduan->status == 'ditolak')>Ditolak</option>
                </select>
                @error('status')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="text-end">
                <a href="{{ route('pengaduan.index') }}" class="btn btn-warning me-1">Kembali</a>
                <button type="submit" class="btn btn-primary">Simpan Status</button>
            </div>

        </form>

    </div>

</x-app>
