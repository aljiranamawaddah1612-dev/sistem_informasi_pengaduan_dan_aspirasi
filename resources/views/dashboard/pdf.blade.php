<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Pengaduan Masyarakat</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        .header { text-align: center; margin-bottom: 20px; border-bottom: 2px solid #000; padding-bottom: 10px; }
        .header h2, .header h4 { margin: 0; padding: 0; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        table, th, td { border: 1px solid #000; }
        th, td { padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
    </style>
</head>
<body>
    <div class="header">
        <h2>Laporan Rekapitulasi Pengaduan Masyarakat</h2>
        @if($start_date && $end_date)
            <h4>Periode: {{ \Carbon\Carbon::parse($start_date)->format('d M Y') }} s/d {{ \Carbon\Carbon::parse($end_date)->format('d M Y') }}</h4>
        @else
            <h4>Semua Periode</h4>
        @endif
    </div>

    <table>
        <thead>
            <tr>
                <th style="width: 5%">No</th>
                <th style="width: 15%">Tanggal</th>
                <th style="width: 20%">Nama Pelapor</th>
                <th style="width: 15%">Kategori</th>
                <th style="width: 35%">Judul Laporan</th>
                <th style="width: 10%">Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($pengaduans as $p)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ \Carbon\Carbon::parse($p->tgl_pengaduan)->format('d M Y') }}</td>
                    <td>{{ $p->user->name }}</td>
                    <td>{{ $p->kategori->nama_kategori }}</td>
                    <td>{{ $p->judul_laporan }}</td>
                    <td>
                        @if($p->status == '0') Menunggu
                        @elseif($p->status == 'proses') Diproses
                        @elseif($p->status == 'selesai') Selesai
                        @elseif($p->status == 'ditolak') Ditolak
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" style="text-align: center;">Tidak ada data pada periode ini</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>
