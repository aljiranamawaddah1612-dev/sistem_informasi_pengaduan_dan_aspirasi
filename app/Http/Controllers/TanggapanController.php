<?php

namespace App\Http\Controllers;

use App\Models\Tanggapan;
use App\Models\Pengaduan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Notifications\StatusPengaduanUpdated;

class TanggapanController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if (Auth::user()->role == 'masyarakat') {
            return abort(403, 'Akses ditolak.');
        }

        $validate = $request->validate([
            'pengaduan_id' => 'required|exists:pengaduans,id',
            'tanggapan' => 'required|string',
            'status' => 'required|in:proses,selesai,ditolak',
        ], [
            'pengaduan_id.required' => 'Pengaduan tidak valid',
            'tanggapan.required' => 'Tanggapan wajib diisi',
            'status.required' => 'Status wajib dipilih',
        ]);

        DB::beginTransaction();

        try {
            // Create Tanggapan
            Tanggapan::create([
                'pengaduan_id' => $validate['pengaduan_id'],
                'user_id' => Auth::id(),
                'tgl_tanggapan' => now()->toDateString(),
                'tanggapan' => $validate['tanggapan'],
            ]);

            // Update Pengaduan status
            $pengaduan = Pengaduan::find($validate['pengaduan_id']);
            $pengaduan->update(['status' => $validate['status']]);

            // Notify User
            $pengaduan->user->notify(new StatusPengaduanUpdated($pengaduan));

            DB::commit();
            return back()->withSuccess('Tanggapan berhasil dikirim dan status diperbarui');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withError('Gagal mengirim tanggapan: ' . $e->getMessage());
        }
    }
}
