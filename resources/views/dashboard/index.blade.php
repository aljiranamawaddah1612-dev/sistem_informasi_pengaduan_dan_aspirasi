<x-app>

    <x-slot:title>{{ $title }}</x-slot:title>

    <style>
        .dashboard-container {
            font-family: 'Inter', 'Nunito', sans-serif;
        }

        .premium-card {
            background: #ffffff;
            border-radius: 20px;
            border: 1px solid rgba(0, 0, 0, 0.05);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.03);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .premium-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.08);
        }

        .icon-box {
            width: 60px;
            height: 60px;
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 28px;
            color: #fff;
            background: linear-gradient(135deg, var(--theme-bg), var(--theme-hover));
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
        }
        
        .icon-box.accent-orange {
            background: linear-gradient(135deg, #f59e0b, #d97706);
        }
        .icon-box.accent-blue {
            background: linear-gradient(135deg, #3b82f6, #2563eb);
        }
        .icon-box.accent-green {
            background: linear-gradient(135deg, #10b981, #059669);
        }
        .icon-box.accent-red {
            background: linear-gradient(135deg, #ef4444, #dc2626);
        }

        .welcome-section {
            background: linear-gradient(135deg, var(--theme-bg), var(--theme-hover));
            border-radius: 24px;
            padding: 40px;
            color: white;
            box-shadow: 0 15px 40px rgba(0,0,0,0.15);
            position: relative;
            overflow: hidden;
            margin-bottom: 2rem;
        }

        .welcome-section::after {
            content: '';
            position: absolute;
            top: -50px;
            right: -50px;
            width: 300px;
            height: 300px;
            background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, rgba(255,255,255,0) 70%);
            border-radius: 50%;
        }

        .stat-value {
            font-size: 2.2rem;
            font-weight: 800;
            color: #1e293b;
            letter-spacing: -1px;
        }

        .stat-label {
            font-size: 0.9rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: #64748b;
        }

        .filter-container {
            background: rgba(255,255,255,0.9);
            backdrop-filter: blur(10px);
            border-radius: 16px;
            padding: 20px;
            border: 1px solid rgba(0,0,0,0.05);
        }

    </style>

    <div class="dashboard-container">
        <!-- Welcome Section -->
        <div class="welcome-section d-flex justify-content-between align-items-center">
            <div style="z-index: 1;">
                <h2 class="fw-bold mb-2">Selamat Datang di SIPA, {{ Auth::user()->name }}!</h2>
                <p class="mb-0 opacity-75 fs-5">Sistem Informasi Pengaduan dan Aspirasi Masyarakat Terpadu.</p>
            </div>
            <div class="d-none d-md-flex flex-column align-items-end" style="z-index: 1;">
                <span class="badge bg-light text-dark px-4 py-2 rounded-pill fs-6 fw-bold mb-2 shadow-sm">
                    {{ ucfirst(Auth::user()->role) }}
                </span>
                <div class="text-white opacity-75 small">
                    <i class="bx bx-calendar"></i> {{ now()->translatedFormat('l, d F Y') }}
                </div>
            </div>
        </div>

        <!-- Export Laporan (Hanya untuk Admin/Petugas) -->
        @if(Auth::user()->role != 'masyarakat')
        <div class="filter-container mb-4 shadow-sm">
            <form action="{{ route('dashboard.index') }}" method="GET" class="row g-3 align-items-end">
                <div class="col-md-3">
                    <label class="form-label text-muted small fw-bold">Mulai Tanggal</label>
                    <input type="date" class="form-control form-control-lg rounded-3" name="start_date" value="{{ $start_date }}">
                </div>
                <div class="col-md-3">
                    <label class="form-label text-muted small fw-bold">Sampai Tanggal</label>
                    <input type="date" class="form-control form-control-lg rounded-3" name="end_date" value="{{ $end_date }}">
                </div>
                <div class="col-md-6 d-flex gap-2">
                    <button type="submit" class="btn btn-dark btn-lg fw-bold rounded-3 px-4 shadow-sm">
                        <i class='bx bx-filter-alt me-1'></i> Filter
                    </button>
                    @if($start_date && $end_date)
                    <a href="{{ route('dashboard.exportPdf', ['start_date' => $start_date, 'end_date' => $end_date]) }}" class="btn btn-danger btn-lg fw-bold rounded-3 px-4 shadow-sm">
                        <i class='bx bxs-file-pdf me-1'></i> Export PDF
                    </a>
                    @else
                    <a href="{{ route('dashboard.exportPdf') }}" class="btn btn-danger btn-lg fw-bold rounded-3 px-4 shadow-sm">
                        <i class='bx bxs-file-pdf me-1'></i> Export PDF
                    </a>
                    @endif
                </div>
            </form>
        </div>
        @endif

        <!-- Quick Stats -->
        <div class="row g-4 mb-4">
            <!-- Total Pengaduan -->
            <div class="col-xl-3 col-md-6">
                <div class="premium-card p-4">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div>
                            <div class="stat-label mb-1">Menunggu Verifikasi</div>
                            <div class="stat-value">{{ $pengaduanMasuk }}</div>
                        </div>
                        <div class="icon-box accent-orange">
                            <i class='bx bx-time-five'></i>
                        </div>
                    </div>
                    <div class="text-muted small fw-semibold">
                        Laporan baru masuk
                    </div>
                </div>
            </div>

            <!-- Sedang Diproses -->
            <div class="col-xl-3 col-md-6">
                <div class="premium-card p-4">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div>
                            <div class="stat-label mb-1">Sedang Diproses</div>
                            <div class="stat-value">{{ $pengaduanProses }}</div>
                        </div>
                        <div class="icon-box accent-blue">
                            <i class='bx bx-loader-circle'></i>
                        </div>
                    </div>
                    <div class="text-muted small fw-semibold">
                        Laporan dalam penanganan
                    </div>
                </div>
            </div>

            <!-- Telah Selesai -->
            <div class="col-xl-3 col-md-6">
                <div class="premium-card p-4">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div>
                            <div class="stat-label mb-1">Telah Selesai</div>
                            <div class="stat-value">{{ $pengaduanSelesai }}</div>
                        </div>
                        <div class="icon-box accent-green">
                            <i class='bx bx-check-shield'></i>
                        </div>
                    </div>
                    <div class="text-muted small fw-semibold">
                        Laporan tuntas diselesaikan
                    </div>
                </div>
            </div>

            <!-- Aspirasi -->
            <div class="col-xl-3 col-md-6">
                <div class="premium-card p-4">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div>
                            <div class="stat-label mb-1">Total Aspirasi</div>
                            <div class="stat-value">{{ $totalAspirasi }}</div>
                        </div>
                        <div class="icon-box">
                            <i class='bx bx-bulb'></i>
                        </div>
                    </div>
                    <div class="text-muted small fw-semibold">
                        Ide dan masukan warga
                    </div>
                </div>
            </div>
        </div>

        <!-- Charts Section -->
        <div class="row g-4 mb-4">
            <!-- Main Area Chart -->
            <div class="col-lg-8">
                <div class="premium-card h-100 p-4">
                    <h5 class="fw-bold mb-4" style="color: #1e293b;">Tren Laporan Masuk (Status)</h5>
                    <div id="trendChart"></div>
                </div>
            </div>

            <!-- Donut Chart -->
            <div class="col-lg-4">
                <div class="premium-card h-100 p-4">
                    <h5 class="fw-bold mb-4" style="color: #1e293b;">Proporsi Status Laporan</h5>
                    <div id="statusDonutChart" class="d-flex justify-content-center align-items-center h-75"></div>
                </div>
            </div>
        </div>
        
        @if(Auth::user()->role == 'admin')
        <!-- Admin Info Row -->
        <div class="row g-4 mb-4">
            <div class="col-12">
                <div class="premium-card p-4">
                    <div class="d-flex align-items-center justify-content-between">
                        <div class="d-flex align-items-center gap-4">
                            <div class="icon-box" style="width: 80px; height: 80px; font-size: 36px;">
                                <i class='bx bx-group'></i>
                            </div>
                            <div>
                                <h4 class="fw-bold mb-1">{{ $totalUsers }} Total Pengguna Sistem</h4>
                                <p class="text-muted mb-0">Rincian: {{ $adminCount }} Admin, {{ $petugasCount }} Petugas, {{ $masyarakatCount }} Masyarakat</p>
                            </div>
                        </div>
                        <a href="{{ route('user.index') }}" class="btn btn-outline-dark rounded-pill px-4 fw-bold">Kelola Pengguna</a>
                    </div>
                </div>
            </div>
        </div>
        @endif
    </div>

    @push('scripts')
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            // Data Setup
            const dataMenunggu = {{ $pengaduanMasuk }};
            const dataProses = {{ $pengaduanProses }};
            const dataSelesai = {{ $pengaduanSelesai }};
            const dataDitolak = {{ $pengaduanDitolak }};

            // Main Bar Chart (Replaced Area with Bar for better representation of Status)
            new ApexCharts(document.querySelector("#trendChart"), {
                series: [{
                    name: 'Jumlah Laporan',
                    data: [dataMenunggu, dataProses, dataSelesai, dataDitolak]
                }],
                chart: {
                    type: 'bar',
                    height: 350,
                    toolbar: { show: false },
                    fontFamily: 'Inter, sans-serif'
                },
                plotOptions: {
                    bar: {
                        borderRadius: 8,
                        columnWidth: '40%',
                        distributed: true,
                    }
                },
                colors: ['#f59e0b', '#3b82f6', '#10b981', '#ef4444'],
                dataLabels: {
                    enabled: true,
                    style: {
                        fontSize: '14px',
                        fontWeight: 'bold',
                        colors: ['#fff']
                    }
                },
                xaxis: {
                    categories: ['Menunggu', 'Diproses', 'Selesai', 'Ditolak'],
                    axisBorder: { show: false },
                    axisTicks: { show: false },
                    labels: {
                        style: {
                            fontSize: '14px',
                            fontWeight: 600,
                            colors: '#64748b'
                        }
                    }
                },
                yaxis: {
                    labels: {
                        style: {
                            colors: '#64748b'
                        }
                    }
                },
                grid: {
                    borderColor: '#f1f5f9',
                    strokeDashArray: 4,
                },
                legend: {
                    show: false
                }
            }).render();

            // Donut Chart for Status Proportion
            new ApexCharts(document.querySelector("#statusDonutChart"), {
                series: [dataMenunggu, dataProses, dataSelesai, dataDitolak],
                chart: {
                    type: 'donut',
                    height: 320,
                    fontFamily: 'Inter, sans-serif'
                },
                labels: ['Menunggu', 'Diproses', 'Selesai', 'Ditolak'],
                colors: ['#f59e0b', '#3b82f6', '#10b981', '#ef4444'],
                plotOptions: {
                    pie: {
                        donut: {
                            size: '75%',
                            labels: {
                                show: true,
                                name: {
                                    fontSize: '16px',
                                    fontWeight: 600,
                                    color: '#64748b'
                                },
                                value: {
                                    fontSize: '28px',
                                    fontWeight: 800,
                                    color: '#1e293b'
                                },
                                total: {
                                    show: true,
                                    label: 'Total',
                                    formatter: function (w) {
                                        return w.globals.seriesTotals.reduce((a, b) => {
                                            return a + b
                                        }, 0)
                                    }
                                }
                            }
                        }
                    }
                },
                dataLabels: {
                    enabled: false
                },
                legend: {
                    position: 'bottom',
                    fontSize: '14px',
                    fontWeight: 600,
                    markers: {
                        radius: 12
                    }
                },
                stroke: {
                    show: true,
                    colors: '#fff',
                    width: 3
                }
            }).render();
        });
    </script>
    @endpush

</x-app>
