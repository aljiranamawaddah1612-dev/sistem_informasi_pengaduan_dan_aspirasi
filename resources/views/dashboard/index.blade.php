<x-app>

    <x-slot:title>{{ $title }}</x-slot:title>

    <!-- Welcome Card -->
    <div class="card shadow-sm border-0 mb-4">
        <div class="card-body p-4">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h3 class="fw-bold mb-3">
                        <i class='bx bx-smile text-primary me-2'></i>
                        Selamat Datang, {{ Auth::user()->name }}!
                    </h3>
                    <p class="text-muted mb-0">
                        Anda login sebagai <span class="badge bg-primary">{{ Auth::user()->role }}</span>
                    </p>
                    <p class="text-muted mt-2">
                        <i class='bx bx-time-five me-1'></i>
                        {{ now()->isoFormat('dddd, D MMMM YYYY - HH:mm') }}
                    </p>
                </div>
                <div class="col-md-4 text-center">
                    <img src="{{ Auth::user()->avatar ? asset('storage/' . Auth::user()->avatar) : asset('niceadmin/img/noprofil.png') }}"
                        alt="Avatar" class="img-fluid rounded-circle border border-3 border-primary"
                        style="max-width: 150px;">
                </div>
            </div>
        </div>
    </div>

    <!-- Export Laporan (Hanya untuk Admin/Petugas) -->
    @if(Auth::user()->role != 'masyarakat')
    <div class="card shadow-sm border-0 mb-4">
        <div class="card-header bg-white border-bottom">
            <h5 class="mb-0 fw-bold">
                <i class='bx bx-printer me-2 text-primary'></i>
                Cetak Laporan Pengaduan
            </h5>
        </div>
        <div class="card-body mt-3">
            <form action="{{ route('dashboard.index') }}" method="GET" class="row g-3 align-items-end">
                <div class="col-md-4">
                    <label for="start_date" class="form-label">Tanggal Mulai</label>
                    <input type="date" class="form-control" name="start_date" id="start_date" value="{{ $start_date }}">
                </div>
                <div class="col-md-4">
                    <label for="end_date" class="form-label">Tanggal Akhir</label>
                    <input type="date" class="form-control" name="end_date" id="end_date" value="{{ $end_date }}">
                </div>
                <div class="col-md-4">
                    <button type="submit" class="btn btn-primary me-2">
                        <i class='bx bx-filter-alt'></i> Filter Data
                    </button>
                    @if($start_date && $end_date)
                    <a href="{{ route('dashboard.exportPdf', ['start_date' => $start_date, 'end_date' => $end_date]) }}" class="btn btn-danger">
                        <i class='bx bxs-file-pdf'></i> Cetak PDF
                    </a>
                    @else
                    <a href="{{ route('dashboard.exportPdf') }}" class="btn btn-danger">
                        <i class='bx bxs-file-pdf'></i> Cetak Semua (PDF)
                    </a>
                    @endif
                </div>
            </form>
        </div>
    </div>
    @endif

    <!-- Statistics Cards -->
    <div class="row g-4 mb-4">
        <!-- Card Total Pengaduan -->
        <div class="col-md-3">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <p class="text-muted mb-1 small">Total Pengaduan</p>
                            <h2 class="fw-bold mb-0">{{ $totalPengaduan }}</h2>
                        </div>
                        <div class="bg-primary bg-opacity-10 rounded-circle p-3">
                            <i class='bx bx-message-square-detail fs-2 text-primary'></i>
                        </div>
                    </div>
                </div>
                <div class="card-footer bg-primary bg-opacity-10 border-0 py-2">
                    <small class="text-primary fw-semibold">
                        Semua laporan masuk
                    </small>
                </div>
            </div>
        </div>

        <!-- Card Menunggu -->
        <div class="col-md-3">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <p class="text-muted mb-1 small">Menunggu (Baru)</p>
                            <h2 class="fw-bold mb-0">{{ $pengaduanMasuk }}</h2>
                        </div>
                        <div class="bg-secondary bg-opacity-10 rounded-circle p-3">
                            <i class='bx bx-time fs-2 text-secondary'></i>
                        </div>
                    </div>
                </div>
                <div class="card-footer bg-secondary bg-opacity-10 border-0 py-2">
                    <small class="text-secondary fw-semibold">
                        Belum ditindaklanjuti
                    </small>
                </div>
            </div>
        </div>

        <!-- Card Diproses -->
        <div class="col-md-3">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <p class="text-muted mb-1 small">Diproses</p>
                            <h2 class="fw-bold mb-0">{{ $pengaduanProses }}</h2>
                        </div>
                        <div class="bg-warning bg-opacity-10 rounded-circle p-3">
                            <i class='bx bx-loader-circle fs-2 text-warning'></i>
                        </div>
                    </div>
                </div>
                <div class="card-footer bg-warning bg-opacity-10 border-0 py-2">
                    <small class="text-warning fw-semibold">
                        Sedang ditangani
                    </small>
                </div>
            </div>
        </div>

        <!-- Card Selesai -->
        <div class="col-md-3">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <p class="text-muted mb-1 small">Selesai</p>
                            <h2 class="fw-bold mb-0">{{ $pengaduanSelesai }}</h2>
                        </div>
                        <div class="bg-success bg-opacity-10 rounded-circle p-3">
                            <i class='bx bx-check-double fs-2 text-success'></i>
                        </div>
                    </div>
                </div>
                <div class="card-footer bg-success bg-opacity-10 border-0 py-2">
                    <small class="text-success fw-semibold">
                        Telah terselesaikan
                    </small>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4 mb-4">
        <!-- Aspirasi -->
        <div class="col-md-4">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <p class="text-muted mb-1 small">Total Aspirasi & Ide</p>
                            <h2 class="fw-bold mb-0">{{ $totalAspirasi }}</h2>
                        </div>
                        <div class="bg-info bg-opacity-10 rounded-circle p-3">
                            <i class='bx bx-bulb fs-2 text-info'></i>
                        </div>
                    </div>
                </div>
                <div class="card-footer bg-info bg-opacity-10 border-0 py-2">
                    <small class="text-info fw-semibold">
                        Masukan dari masyarakat
                    </small>
                </div>
            </div>
        </div>

        @if(Auth::user()->role == 'admin')
        <!-- Users -->
        <div class="col-md-4">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <p class="text-muted mb-1 small">Total Users</p>
                            <h2 class="fw-bold mb-0">{{ $totalUsers }}</h2>
                        </div>
                        <div class="bg-primary bg-opacity-10 rounded-circle p-3">
                            <i class='bx bx-user fs-2 text-primary'></i>
                        </div>
                    </div>
                </div>
                <div class="card-footer bg-primary bg-opacity-10 border-0 py-2">
                    <small class="text-primary fw-semibold">
                        Masyarakat: {{ $masyarakatCount }} | Petugas: {{ $petugasCount }} | Admin: {{ $adminCount }}
                    </small>
                </div>
            </div>
        </div>
        @endif
    </div>

    <!-- Chart -->
    <div class="card shadow-sm border-0 mb-4">
        <div class="card-header bg-white border-bottom">
            <h5 class="mb-0 fw-bold">
                <i class='bx bx-bar-chart-alt-2 me-2 text-primary'></i>
                Statistik Pengaduan Berdasarkan Status
            </h5>
        </div>
        <div class="card-body pt-4">
            <div id="pengaduanChart"></div>
        </div>
    </div>


    @push('modals')
    @endpush

    @push('scripts')
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            new ApexCharts(document.querySelector("#pengaduanChart"), {
                series: [{
                    name: 'Jumlah Pengaduan',
                    data: [{{ $pengaduanMasuk }}, {{ $pengaduanProses }}, {{ $pengaduanSelesai }}, {{ $pengaduanDitolak }}]
                }],
                chart: {
                    type: 'bar',
                    height: 350
                },
                plotOptions: {
                    bar: {
                        borderRadius: 4,
                        horizontal: false,
                    }
                },
                dataLabels: {
                    enabled: true
                },
                xaxis: {
                    categories: ['Menunggu', 'Diproses', 'Selesai', 'Ditolak'],
                },
                colors: ['#6c757d', '#ffc107', '#198754', '#dc3545']
            }).render();
        });
    </script>
    @endpush

</x-app>
