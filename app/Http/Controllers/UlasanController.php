<?php

namespace App\Http\Controllers;

use App\Models\Ulasan;
use Illuminate\Http\Request;

class UlasanController extends Controller
{
    public function index()
    {
        $ulasans = Ulasan::with(['user', 'pengaduan'])->latest()->get();
        return view('ulasan.index', [
            'title' => 'Ulasan Laporan',
            'ulasans' => $ulasans
        ]);
    }

    public function destroy(Ulasan $ulasan)
    {
        $ulasan->delete();
        return redirect()->route('ulasan.index')->with('success', 'Ulasan berhasil dihapus!');
    }
}
