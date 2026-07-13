<?php

namespace App\Http\Controllers;

use App\Models\Pengaduan;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class PengaduanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();
        if ($user->role == 'masyarakat') {
            $pengaduans = Pengaduan::where('user_id', $user->id)->latest()->get();
        } else {
            $pengaduans = Pengaduan::latest()->get();
        }

        return view('pengaduan.index', [
            'title' => 'Data Pengaduan',
            'pengaduans' => $pengaduans,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (Auth::user()->role != 'masyarakat') {
            return abort(403, 'Hanya masyarakat yang dapat membuat pengaduan.');
        }

        return view('pengaduan.create', [
            'title' => 'Buat Pengaduan',
            'kategoris' => Kategori::all(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if (Auth::user()->role != 'masyarakat') {
            return abort(403, 'Hanya masyarakat yang dapat membuat pengaduan.');
        }

        $validate = $request->validate([
            'kategori_id' => 'required|exists:kategoris,id',
            'judul_laporan' => 'required|string|max:255',
            'isi_laporan' => 'required|string',
            'foto_lampiran' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ], [
            'kategori_id.required' => 'Kategori wajib dipilih',
            'kategori_id.exists' => 'Kategori tidak valid',
            'judul_laporan.required' => 'Judul laporan wajib diisi',
            'isi_laporan.required' => 'Isi laporan wajib diisi',
            'foto_lampiran.image' => 'Lampiran harus berupa gambar',
            'foto_lampiran.mimes' => 'Format gambar harus jpeg, png, atau jpg',
            'foto_lampiran.max' => 'Ukuran gambar maksimal 2MB',
        ]);

        DB::beginTransaction();

        try {
            $validate['user_id'] = Auth::id();
            $validate['tgl_pengaduan'] = now()->toDateString();
            $validate['status'] = '0';

            if ($request->file('foto_lampiran')) {
                $validate['foto_lampiran'] = $request->file('foto_lampiran')->store('pengaduan', 'public');
            }

            Pengaduan::create($validate);

            DB::commit();
            return to_route('pengaduan.index')->withSuccess('Pengaduan berhasil dikirim');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withError('Gagal mengirim pengaduan: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Pengaduan $pengaduan)
    {
        $user = Auth::user();
        if ($user->role == 'masyarakat' && $pengaduan->user_id != $user->id) {
            return abort(403, 'Anda tidak memiliki akses ke pengaduan ini.');
        }

        return view('pengaduan.show', [
            'title' => 'Detail Pengaduan',
            'pengaduan' => $pengaduan,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Pengaduan $pengaduan)
    {
        // Edit status form for admin/petugas
        if (Auth::user()->role == 'masyarakat') {
            return abort(403, 'Akses ditolak.');
        }

        return view('pengaduan.edit', [
            'title' => 'Update Status Pengaduan',
            'pengaduan' => $pengaduan,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Pengaduan $pengaduan)
    {
        if (Auth::user()->role == 'masyarakat') {
            return abort(403, 'Akses ditolak.');
        }

        $validate = $request->validate([
            'status' => 'required|in:0,proses,selesai,ditolak',
        ], [
            'status.required' => 'Status wajib dipilih',
            'status.in' => 'Status tidak valid',
        ]);

        DB::beginTransaction();

        try {
            $pengaduan->update(['status' => $validate['status']]);

            DB::commit();
            return to_route('pengaduan.index')->withSuccess('Status pengaduan berhasil diperbarui');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withError('Gagal memperbarui status: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pengaduan $pengaduan)
    {
        // Only admin/petugas can delete, or maybe masyarakat if status is 0?
        // For now, let's say only admin can delete.
        if (Auth::user()->role == 'masyarakat') {
            return abort(403, 'Akses ditolak.');
        }

        DB::beginTransaction();

        try {
            $pengaduan->delete();
            DB::commit();
            return to_route('pengaduan.index')->withSuccess('Pengaduan berhasil dihapus');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withError('Gagal menghapus pengaduan: ' . $e->getMessage());
        }
    }
}
