<?php

namespace App\Http\Controllers;

use App\Models\Pengumuman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PengumumanController extends Controller
{
    public function index()
    {
        $pengumumans = Pengumuman::latest()->get();
        return view('pengumuman.index', [
            'title' => 'Pengumuman',
            'pengumumans' => $pengumumans
        ]);
    }

    public function create()
    {
        return view('pengumuman.create', [
            'title' => 'Tambah Pengumuman'
        ]);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'judul' => 'required|max:255',
            'isi_pengumuman' => 'required',
            'tanggal_publish' => 'nullable|date',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,svg|max:2048',
        ], [
            'judul.required' => 'Judul wajib diisi',
            'isi_pengumuman.required' => 'Isi pengumuman wajib diisi',
            'gambar.image' => 'File harus berupa gambar',
            'gambar.mimes' => 'Format gambar harus jpeg, png, jpg, svg',
            'gambar.max' => 'Ukuran gambar maksimal 2MB',
        ]);

        if ($request->file('gambar')) {
            $validatedData['gambar'] = $request->file('gambar')->store('pengumuman', 'public');
        }

        $validatedData['penulis_id'] = Auth::id();

        Pengumuman::create($validatedData);

        return redirect()->route('pengumuman.index')->with('success', 'Pengumuman berhasil ditambahkan!');
    }

    public function edit(Pengumuman $pengumuman)
    {
        return view('pengumuman.edit', [
            'title' => 'Edit Pengumuman',
            'pengumuman' => $pengumuman
        ]);
    }

    public function update(Request $request, Pengumuman $pengumuman)
    {
        $validatedData = $request->validate([
            'judul' => 'required|max:255',
            'isi_pengumuman' => 'required',
            'tanggal_publish' => 'nullable|date',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,svg|max:2048',
        ], [
            'judul.required' => 'Judul wajib diisi',
            'isi_pengumuman.required' => 'Isi pengumuman wajib diisi',
            'gambar.image' => 'File harus berupa gambar',
            'gambar.mimes' => 'Format gambar harus jpeg, png, jpg, svg',
            'gambar.max' => 'Ukuran gambar maksimal 2MB',
        ]);

        if ($request->file('gambar')) {
            if ($pengumuman->gambar) {
                Storage::disk('public')->delete($pengumuman->gambar);
            }
            $validatedData['gambar'] = $request->file('gambar')->store('pengumuman', 'public');
        }

        $pengumuman->update($validatedData);

        return redirect()->route('pengumuman.index')->with('success', 'Pengumuman berhasil diperbarui!');
    }

    public function destroy(Pengumuman $pengumuman)
    {
        if ($pengumuman->gambar) {
            Storage::disk('public')->delete($pengumuman->gambar);
        }
        $pengumuman->delete();

        return redirect()->route('pengumuman.index')->with('success', 'Pengumuman berhasil dihapus!');
    }
}
