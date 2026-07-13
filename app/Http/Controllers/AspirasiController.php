<?php

namespace App\Http\Controllers;

use App\Models\Aspirasi;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class AspirasiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();
        if ($user->role == 'masyarakat') {
            $aspirasis = Aspirasi::where('user_id', $user->id)->latest()->get();
        } else {
            $aspirasis = Aspirasi::latest()->get();
        }

        return view('aspirasi.index', [
            'title' => 'Data Aspirasi',
            'aspirasis' => $aspirasis,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (Auth::user()->role != 'masyarakat') {
            return abort(403, 'Hanya masyarakat yang dapat membuat aspirasi.');
        }

        return view('aspirasi.create', [
            'title' => 'Buat Aspirasi',
            'kategoris' => Kategori::all(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if (Auth::user()->role != 'masyarakat') {
            return abort(403, 'Akses ditolak.');
        }

        $validate = $request->validate([
            'kategori_id' => 'required|exists:kategoris,id',
            'judul_aspirasi' => 'required|string|max:255',
            'isi_aspirasi' => 'required|string',
            'foto_lampiran' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ], [
            'kategori_id.required' => 'Kategori wajib dipilih',
            'judul_aspirasi.required' => 'Judul aspirasi wajib diisi',
            'isi_aspirasi.required' => 'Isi aspirasi wajib diisi',
            'foto_lampiran.image' => 'Lampiran harus berupa gambar',
        ]);

        DB::beginTransaction();

        try {
            $validate['user_id'] = Auth::id();
            $validate['tgl_aspirasi'] = now()->toDateString();
            $validate['status'] = 'tinjau';

            if ($request->file('foto_lampiran')) {
                $validate['foto_lampiran'] = $request->file('foto_lampiran')->store('aspirasi', 'public');
            }

            Aspirasi::create($validate);

            DB::commit();
            return to_route('aspirasi.index')->withSuccess('Aspirasi berhasil dikirim');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withError('Gagal mengirim aspirasi: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Aspirasi $aspirasi)
    {
        $user = Auth::user();
        if ($user->role == 'masyarakat' && $aspirasi->user_id != $user->id) {
            return abort(403, 'Akses ditolak.');
        }

        return view('aspirasi.show', [
            'title' => 'Detail Aspirasi',
            'aspirasi' => $aspirasi,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Aspirasi $aspirasi)
    {
        if (Auth::user()->role == 'masyarakat') {
            return abort(403, 'Akses ditolak.');
        }

        return view('aspirasi.edit', [
            'title' => 'Update Status Aspirasi',
            'aspirasi' => $aspirasi,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Aspirasi $aspirasi)
    {
        if (Auth::user()->role == 'masyarakat') {
            return abort(403, 'Akses ditolak.');
        }

        $validate = $request->validate([
            'status' => 'required|in:tinjau,diterima',
        ]);

        DB::beginTransaction();

        try {
            $aspirasi->update(['status' => $validate['status']]);

            DB::commit();
            return to_route('aspirasi.index')->withSuccess('Status aspirasi berhasil diperbarui');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withError('Gagal memperbarui status: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Aspirasi $aspirasi)
    {
        if (Auth::user()->role == 'masyarakat') {
            return abort(403, 'Akses ditolak.');
        }

        DB::beginTransaction();

        try {
            $aspirasi->delete();
            DB::commit();
            return to_route('aspirasi.index')->withSuccess('Aspirasi berhasil dihapus');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withError('Gagal menghapus aspirasi: ' . $e->getMessage());
        }
    }
}
