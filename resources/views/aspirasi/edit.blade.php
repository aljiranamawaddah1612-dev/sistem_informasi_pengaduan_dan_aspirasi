<x-app>

    <x-slot:title>{{ $title }}</x-slot:title>

    <div class="card shadow-lg p-3">

        <form action="{{ route('aspirasi.update', $aspirasi) }}" method="post" class="form">
            @csrf
            @method('put')

            <div class="row mb-3">
                <div class="col-md-12">
                    <h5>Judul: {{ $aspirasi->judul_aspirasi }}</h5>
                    <p>Status Saat Ini: 
                        @if($aspirasi->status == 'tinjau')
                            <span class="badge bg-warning text-dark">Ditinjau</span>
                        @elseif($aspirasi->status == 'diterima')
                            <span class="badge bg-success">Diterima</span>
                        @endif
                    </p>
                </div>
            </div>

            <div class="mb-3">
                <label for="status" class="form-label required">Update Status Menjadi</label>
                <select class="form-select @error('status') is-invalid  @enderror" id="status"
                    name="status" required>
                    <option value="tinjau" @selected($aspirasi->status == 'tinjau')>Ditinjau</option>
                    <option value="diterima" @selected($aspirasi->status == 'diterima')>Diterima</option>
                </select>
                @error('status')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="text-end">
                <a href="{{ route('aspirasi.index') }}" class="btn btn-warning me-1">Kembali</a>
                <button type="submit" class="btn btn-primary">Simpan Status</button>
            </div>

        </form>

    </div>

</x-app>
