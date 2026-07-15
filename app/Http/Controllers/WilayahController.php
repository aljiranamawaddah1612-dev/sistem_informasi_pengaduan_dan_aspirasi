<?php

namespace App\Http\Controllers;

use App\Models\Wilayah;
use Illuminate\Http\Request;

class WilayahController extends Controller
{
    public function index()
    {
        $wilayahs = Wilayah::latest()->get();
        return view('wilayah.index', [
            'title' => 'Data Wilayah',
            'wilayahs' => $wilayahs
        ]);
    }

    public function create()
    {
        return view('wilayah.create', [
            'title' => 'Tambah Wilayah'
        ]);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nama_wilayah' => 'required|max:255',
            'kode_pos' => 'nullable|max:10',
        ], [
            'nama_wilayah.required' => 'Nama wilayah wajib diisi',
            'nama_wilayah.max' => 'Nama wilayah maksimal 255 karakter',
            'kode_pos.max' => 'Kode pos maksimal 10 karakter',
        ]);

        Wilayah::create($validatedData);

        return redirect()->route('wilayah.index')->with('success', 'Wilayah berhasil ditambahkan!');
    }

    public function edit(Wilayah $wilayah)
    {
        return view('wilayah.edit', [
            'title' => 'Edit Wilayah',
            'wilayah' => $wilayah
        ]);
    }

    public function update(Request $request, Wilayah $wilayah)
    {
        $validatedData = $request->validate([
            'nama_wilayah' => 'required|max:255',
            'kode_pos' => 'nullable|max:10',
        ], [
            'nama_wilayah.required' => 'Nama wilayah wajib diisi',
            'nama_wilayah.max' => 'Nama wilayah maksimal 255 karakter',
            'kode_pos.max' => 'Kode pos maksimal 10 karakter',
        ]);

        $wilayah->update($validatedData);

        return redirect()->route('wilayah.index')->with('success', 'Wilayah berhasil diperbarui!');
    }

    public function destroy(Wilayah $wilayah)
    {
        $wilayah->delete();

        return redirect()->route('wilayah.index')->with('success', 'Wilayah berhasil dihapus!');
    }
}
