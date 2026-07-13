<?php

namespace App\Exports;

use App\Models\Pengaduan;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class PengaduanExport implements FromCollection, WithHeadings, WithMapping
{
    protected $pengaduans;

    public function __construct($pengaduans)
    {
        $this->pengaduans = $pengaduans;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return collect($this->pengaduans);
    }

    public function headings(): array
    {
        return [
            'No',
            'Tanggal Pengaduan',
            'Nama Pelapor',
            'Kategori',
            'Judul Laporan',
            'Status'
        ];
    }

    public function map($pengaduan): array
    {
        $statusLabel = '';
        if ($pengaduan->status == '0') $statusLabel = 'Menunggu';
        elseif ($pengaduan->status == 'proses') $statusLabel = 'Diproses';
        elseif ($pengaduan->status == 'selesai') $statusLabel = 'Selesai';
        elseif ($pengaduan->status == 'ditolak') $statusLabel = 'Ditolak';

        return [
            $pengaduan->id, // Ideally an incrementing index if you pass it, but ID is fine for now
            \Carbon\Carbon::parse($pengaduan->tgl_pengaduan)->format('d M Y'),
            $pengaduan->user->name,
            $pengaduan->kategori->nama_kategori,
            $pengaduan->judul_laporan,
            $statusLabel
        ];
    }
}
