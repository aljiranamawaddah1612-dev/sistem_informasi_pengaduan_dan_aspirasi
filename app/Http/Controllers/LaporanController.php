<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pengaduan;
use App\Models\Kategori;
use App\Exports\PengaduanExport;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;

class LaporanController extends Controller
{
    /**
     * Tampilkan halaman filter laporan
     */
    public function index(Request $request)
    {
        if (Auth::user()->role == 'masyarakat') {
            return abort(403);
        }

        $query = Pengaduan::query();

        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('tgl_pengaduan', [$request->start_date, $request->end_date]);
        }

        if ($request->filled('kategori_id')) {
            $query->where('kategori_id', $request->kategori_id);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $pengaduans = $query->latest()->get();

        return view('laporan.index', [
            'title' => 'Export Laporan',
            'pengaduans' => $pengaduans,
            'kategoris' => Kategori::all(),
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'kategori_id' => $request->kategori_id,
            'status' => $request->status,
        ]);
    }

    /**
     * Helper filter query
     */
    private function getFilteredData(Request $request)
    {
        $query = Pengaduan::with(['user', 'kategori']);

        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('tgl_pengaduan', [$request->start_date, $request->end_date]);
        }

        if ($request->filled('kategori_id')) {
            $query->where('kategori_id', $request->kategori_id);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        return $query->latest()->get();
    }

    /**
     * Export ke PDF
     */
    public function exportPdf(Request $request)
    {
        if (Auth::user()->role == 'masyarakat') {
            return abort(403);
        }

        $pengaduans = $this->getFilteredData($request);

        $pdf = Pdf::loadView('dashboard.pdf', [
            'pengaduans' => $pengaduans,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
        ]);

        return $pdf->download('laporan_pengaduan.pdf');
    }

    /**
     * Export ke Excel
     */
    public function exportExcel(Request $request)
    {
        if (Auth::user()->role == 'masyarakat') {
            return abort(403);
        }

        $pengaduans = $this->getFilteredData($request);

        return Excel::download(new PengaduanExport($pengaduans), 'laporan_pengaduan.xlsx');
    }
}
