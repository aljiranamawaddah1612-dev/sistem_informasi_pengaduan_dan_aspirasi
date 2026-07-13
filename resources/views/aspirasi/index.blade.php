<x-app>

    <x-slot:title>{{ $title }}</x-slot:title>

    <div class="card shadow-lg p-3">

        @if(Auth::user()->role == 'masyarakat')
        <div class="mb-3">
            <a class="btn btn-primary" href="{{ route('aspirasi.create') }}" role="button">Buat Aspirasi / Ide Baru</a>
        </div>
        @endif

        <div class="table-responsive">
            <table class="table table-bordered table-striped w-100 datatable" id="data-table">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Tanggal</th>
                        @if(Auth::user()->role != 'masyarakat')
                        <th scope="col">Pengirim</th>
                        @endif
                        <th scope="col">Kategori</th>
                        <th scope="col">Topik Aspirasi</th>
                        <th scope="col">Status</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($aspirasis as $aspirasi)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ \Carbon\Carbon::parse($aspirasi->tgl_aspirasi)->format('d M Y') }}</td>
                            @if(Auth::user()->role != 'masyarakat')
                            <td>{{ $aspirasi->user->name }}</td>
                            @endif
                            <td>{{ $aspirasi->kategori->nama_kategori }}</td>
                            <td>{{ $aspirasi->judul_aspirasi }}</td>
                            <td>
                                @if($aspirasi->status == 'tinjau')
                                    <span class="badge bg-warning text-dark">Ditinjau</span>
                                @elseif($aspirasi->status == 'diterima')
                                    <span class="badge bg-success">Diterima</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('aspirasi.show', $aspirasi) }}" class="btn btn-info btn-sm">
                                    <i class='bx bx-show'></i> Detail
                                </a>
                                @if(Auth::user()->role != 'masyarakat')
                                <a href="{{ route('aspirasi.edit', $aspirasi) }}" class="btn btn-warning btn-sm">
                                    <i class='bx bx-edit-alt'></i> Update Status
                                </a>
                                <button type="button" class="btn btn-danger btn-sm btn-delete" data-bs-toggle="modal"
                                    data-bs-target="#deleteModal" data-route="{{ route('aspirasi.destroy', $aspirasi) }}">
                                    <i class='bx bx-trash'></i>
                                </button>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

    </div>

    @push('scripts')
        <script>
            $('#data-table').on('click', '.btn-delete', function() {
                $('#form-delete').attr('action', $(this).data('route'))
            })
        </script>
    @endpush

</x-app>
