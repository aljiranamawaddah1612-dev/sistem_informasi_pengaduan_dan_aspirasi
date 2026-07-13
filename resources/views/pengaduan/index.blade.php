<x-app>

    <x-slot:title>{{ $title }}</x-slot:title>

    <div class="card shadow-lg p-3">

        @if(Auth::user()->role == 'masyarakat')
        <div class="mb-3">
            <a class="btn btn-primary" href="{{ route('pengaduan.create') }}" role="button">Buat Pengaduan</a>
        </div>
        @endif

        <div class="table-responsive">
            <table class="table table-bordered table-striped w-100 datatable" id="data-table">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Tanggal</th>
                        @if(Auth::user()->role != 'masyarakat')
                        <th scope="col">Pelapor</th>
                        @endif
                        <th scope="col">Kategori</th>
                        <th scope="col">Judul Laporan</th>
                        <th scope="col">Status</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($pengaduans as $pengaduan)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ \Carbon\Carbon::parse($pengaduan->tgl_pengaduan)->format('d M Y') }}</td>
                            @if(Auth::user()->role != 'masyarakat')
                            <td>{{ $pengaduan->user->name }}</td>
                            @endif
                            <td>{{ $pengaduan->kategori->nama_kategori }}</td>
                            <td>{{ $pengaduan->judul_laporan }}</td>
                            <td>
                                @if($pengaduan->status == '0')
                                    <span class="badge bg-secondary">Menunggu</span>
                                @elseif($pengaduan->status == 'proses')
                                    <span class="badge bg-warning text-dark">Diproses</span>
                                @elseif($pengaduan->status == 'selesai')
                                    <span class="badge bg-success">Selesai</span>
                                @elseif($pengaduan->status == 'ditolak')
                                    <span class="badge bg-danger">Ditolak</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('pengaduan.show', $pengaduan) }}" class="btn btn-info btn-sm">
                                    <i class='bx bx-show'></i> Detail
                                </a>
                                @if(Auth::user()->role != 'masyarakat')
                                <a href="{{ route('pengaduan.edit', $pengaduan) }}" class="btn btn-warning btn-sm">
                                    <i class='bx bx-edit-alt'></i> Update Status
                                </a>
                                <button type="button" class="btn btn-danger btn-sm btn-delete" data-bs-toggle="modal"
                                    data-bs-target="#deleteModal" data-route="{{ route('pengaduan.destroy', $pengaduan) }}">
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
