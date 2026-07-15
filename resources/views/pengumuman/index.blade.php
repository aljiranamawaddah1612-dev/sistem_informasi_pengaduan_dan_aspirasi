<x-app>
    <x-slot:title>{{ $title }}</x-slot:title>

    <div class="card shadow border-0 rounded-4">
        <div class="card-header bg-white border-0 pt-4 pb-0 d-flex justify-content-between align-items-center">
            <h5 class="m-0 fw-bold" style="color: var(--theme-bg);">Data Pengumuman</h5>
            <a href="{{ route('pengumuman.create') }}" class="btn btn-primary rounded-pill px-4 shadow-sm"><i class="bx bx-plus"></i> Tambah</a>
        </div>
        <div class="card-body mt-3">
            <div class="table-responsive">
                <table class="table table-hover align-middle" id="data-table">
                    <thead class="table-light">
                        <tr>
                            <th width="5%" class="text-center">No</th>
                            <th class="text-center">Gambar</th>
                            <th>Judul</th>
                            <th>Tanggal Publish</th>
                            <th>Penulis</th>
                            <th width="15%" class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($pengumumans as $item)
                            <tr>
                                <td class="text-center">{{ $loop->iteration }}</td>
                                <td class="text-center">
                                    @if($item->gambar)
                                        <img src="{{ asset('storage/' . $item->gambar) }}" alt="Gambar" width="80" class="rounded shadow-sm">
                                    @else
                                        <span class="text-muted small">Tidak ada gambar</span>
                                    @endif
                                </td>
                                <td class="fw-semibold text-dark">{{ $item->judul }}</td>
                                <td>
                                    <span class="badge bg-light text-dark border">
                                        <i class="bx bx-calendar"></i> {{ $item->tanggal_publish ? \Carbon\Carbon::parse($item->tanggal_publish)->translatedFormat('d M Y') : '-' }}
                                    </span>
                                </td>
                                <td>{{ $item->penulis->name ?? 'Admin' }}</td>
                                <td class="text-center">
                                    <a href="{{ route('pengumuman.edit', $item->id) }}" class="btn btn-warning btn-sm text-white rounded-circle shadow-sm" style="width: 32px; height: 32px;"><i class="bx bx-edit"></i></a>
                                    <button type="button" class="btn btn-danger btn-sm rounded-circle shadow-sm" style="width: 32px; height: 32px;" onclick="$('#form-delete').attr('action', '{{ route('pengumuman.destroy', $item->id) }}')" data-bs-toggle="modal" data-bs-target="#deleteModal"><i class="bx bx-trash"></i></button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app>
