<x-app>
    <x-slot:title>{{ $title }}</x-slot:title>
    <div class="card shadow border-0 rounded-4">
        <div class="card-header bg-white border-0 pt-4 pb-0">
            <h5 class="m-0 fw-bold" style="color: var(--theme-bg);">Data Ulasan Masyarakat</h5>
        </div>
        <div class="card-body mt-3">
            <div class="table-responsive">
                <table class="table table-hover align-middle" id="data-table">
                    <thead class="table-light">
                        <tr>
                            <th width="5%" class="text-center">No</th>
                            <th>Pelapor</th>
                            <th>Judul Laporan</th>
                            <th class="text-center">Rating</th>
                            <th>Komentar</th>
                            <th width="10%" class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($ulasans as $item)
                            <tr>
                                <td class="text-center">{{ $loop->iteration }}</td>
                                <td class="fw-semibold text-dark">{{ $item->user->name ?? 'User Dihapus' }}</td>
                                <td>{{ \Illuminate\Support\Str::limit($item->pengaduan->judul_laporan ?? 'Laporan Dihapus', 30) }}</td>
                                <td class="text-center">
                                    <div class="text-warning">
                                        @for ($i = 0; $i < $item->rating; $i++)
                                            <i class='bx bxs-star'></i>
                                        @endfor
                                        @for ($i = $item->rating; $i < 5; $i++)
                                            <i class='bx bx-star'></i>
                                        @endfor
                                    </div>
                                </td>
                                <td>{{ \Illuminate\Support\Str::limit($item->komentar ?? '-', 50) }}</td>
                                <td class="text-center">
                                    <button type="button" class="btn btn-danger btn-sm rounded-circle shadow-sm" style="width: 32px; height: 32px;" onclick="$('#form-delete').attr('action', '{{ route('ulasan.destroy', $item->id) }}')" data-bs-toggle="modal" data-bs-target="#deleteModal"><i class="bx bx-trash"></i></button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app>
