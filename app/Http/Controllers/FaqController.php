<?php

namespace App\Http\Controllers;

use App\Models\Faq;
use Illuminate\Http\Request;

class FaqController extends Controller
{
    public function index()
    {
        $faqs = Faq::latest()->get();
        return view('faq.index', [
            'title' => 'Kelola FAQ',
            'faqs' => $faqs
        ]);
    }

    public function create()
    {
        return view('faq.create', [
            'title' => 'Tambah FAQ'
        ]);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'pertanyaan' => 'required|max:255',
            'jawaban' => 'required',
        ]);

        $validatedData['status_aktif'] = $request->has('status_aktif');
        Faq::create($validatedData);

        return redirect()->route('faq.index')->with('success', 'FAQ berhasil ditambahkan!');
    }

    public function edit(Faq $faq)
    {
        return view('faq.edit', [
            'title' => 'Edit FAQ',
            'faq' => $faq
        ]);
    }

    public function update(Request $request, Faq $faq)
    {
        $validatedData = $request->validate([
            'pertanyaan' => 'required|max:255',
            'jawaban' => 'required',
        ]);

        $validatedData['status_aktif'] = $request->has('status_aktif');
        $faq->update($validatedData);

        return redirect()->route('faq.index')->with('success', 'FAQ berhasil diperbarui!');
    }

    public function destroy(Faq $faq)
    {
        $faq->delete();
        return redirect()->route('faq.index')->with('success', 'FAQ berhasil dihapus!');
    }
}
