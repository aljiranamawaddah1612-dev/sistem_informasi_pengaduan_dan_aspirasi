<x-app>
    <x-slot:title>{{ $title }}</x-slot:title>

    <div class="card shadow border-0 rounded-4">
        <div class="card-header bg-white border-0 pt-4 pb-0 d-flex justify-content-between align-items-center">
            <h5 class="m-0 fw-bold" style="color: var(--theme-bg);">Data Wilayah</h5>
            <a href="{{ route('wilayah.create') }}" class="btn btn-primary rounded-pill px-4 shadow-sm"><i class="bx bx-plus"></i> Tambah</a>
        </div>
        <div class="card-body mt-3">
            <div class="table-responsive">
                <table class="table table-hover align-middle" id="data-table">
                    <thead class="table-light">
                        <tr>
                            <th width="5%" class="text-center">No</th>
                            <th>Nama Wilayah / Desa</th>
                            <th>Kode Pos</th>
                            <th width="15%" class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($wilayahs as $item)
                            <tr>
                                <td class="text-center">{{ $loop->iteration }}</td>
                                <td class="fw-semibold text-dark">{{ $item->nama_wilayah }}</td>
                                <td>{{ $item->kode_pos ?? '-' }}</td>
                                <td class="text-center">
                                    <a href="{{ route('wilayah.edit', $item->id) }}" class="btn btn-warning btn-sm text-white rounded-circle shadow-sm" style="width: 32px; height: 32px;"><i class="bx bx-edit"></i></a>
                                    <button type="button" class="btn btn-danger btn-sm rounded-circle shadow-sm" style="width: 32px; height: 32px;" onclick="$('#form-delete').attr('action', '{{ route('wilayah.destroy', $item->id) }}')" data-bs-toggle="modal" data-bs-target="#deleteModal"><i class="bx bx-trash"></i></button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app>
