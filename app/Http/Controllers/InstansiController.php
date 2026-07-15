<?php

namespace App\Http\Controllers;

use App\Models\Instansi;
use Illuminate\Http\Request;

class InstansiController extends Controller
{
    public function index()
    {
        $instansis = Instansi::latest()->get();
        return view('instansi.index', [
            'title' => 'Data Instansi',
            'instansis' => $instansis
        ]);
    }

    public function create()
    {
        return view('instansi.create', [
            'title' => 'Tambah Instansi'
        ]);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nama_instansi' => 'required|max:255',
            'deskripsi' => 'nullable',
            'kontak' => 'nullable|max:255',
        ], [
            'nama_instansi.required' => 'Nama instansi wajib diisi',
            'nama_instansi.max' => 'Nama instansi maksimal 255 karakter',
        ]);

        Instansi::create($validatedData);

        return redirect()->route('instansi.index')->with('success', 'Instansi berhasil ditambahkan!');
    }

    public function edit(Instansi $instansi)
    {
        return view('instansi.edit', [
            'title' => 'Edit Instansi',
            'instansi' => $instansi
        ]);
    }

    public function update(Request $request, Instansi $instansi)
    {
        $validatedData = $request->validate([
            'nama_instansi' => 'required|max:255',
            'deskripsi' => 'nullable',
            'kontak' => 'nullable|max:255',
        ], [
            'nama_instansi.required' => 'Nama instansi wajib diisi',
            'nama_instansi.max' => 'Nama instansi maksimal 255 karakter',
        ]);

        $instansi->update($validatedData);

        return redirect()->route('instansi.index')->with('success', 'Instansi berhasil diperbarui!');
    }

    public function destroy(Instansi $instansi)
    {
        $instansi->delete();

        return redirect()->route('instansi.index')->with('success', 'Instansi berhasil dihapus!');
    }
}
