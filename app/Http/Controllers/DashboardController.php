<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Pengaduan;
use App\Models\Aspirasi;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        
        $totalUsers = User::count();
        $adminCount = User::where('role', 'admin')->count();
        $petugasCount = User::where('role', 'petugas')->count();
        $masyarakatCount = User::where('role', 'masyarakat')->count();

        // Query Pengaduan
        $queryPengaduan = Pengaduan::query();
        if ($user->role == 'masyarakat') {
            $queryPengaduan->where('user_id', $user->id);
        }

        // Apply Date Filter if exists
        $start_date = $request->get('start_date');
        $end_date = $request->get('end_date');

        if ($start_date && $end_date) {
            $queryPengaduan->whereBetween('tgl_pengaduan', [$start_date, $end_date]);
        }

        $totalPengaduan = $queryPengaduan->count();
        $pengaduanMasuk = (clone $queryPengaduan)->where('status', '0')->count();
        $pengaduanProses = (clone $queryPengaduan)->where('status', 'proses')->count();
        $pengaduanSelesai = (clone $queryPengaduan)->where('status', 'selesai')->count();
        $pengaduanDitolak = (clone $queryPengaduan)->where('status', 'ditolak')->count();

        // Aspirasi
        $queryAspirasi = Aspirasi::query();
        if ($user->role == 'masyarakat') {
            $queryAspirasi->where('user_id', $user->id);
        }
        $totalAspirasi = $queryAspirasi->count();

        return view('dashboard.index', [
            'title' => 'Dashboard',
            'totalUsers' => $totalUsers,
            'adminCount' => $adminCount,
            'petugasCount' => $petugasCount,
            'masyarakatCount' => $masyarakatCount,
            'totalPengaduan' => $totalPengaduan,
            'pengaduanMasuk' => $pengaduanMasuk,
            'pengaduanProses' => $pengaduanProses,
            'pengaduanSelesai' => $pengaduanSelesai,
            'pengaduanDitolak' => $pengaduanDitolak,
            'totalAspirasi' => $totalAspirasi,
            'start_date' => $start_date,
            'end_date' => $end_date,
        ]);
    }

    public function exportPdf(Request $request)
    {
        if (Auth::user()->role == 'masyarakat') {
            return abort(403);
        }

        $query = Pengaduan::with(['user', 'kategori']);
        
        if ($request->has('start_date') && $request->has('end_date') && $request->start_date && $request->end_date) {
            $query->whereBetween('tgl_pengaduan', [$request->start_date, $request->end_date]);
        }

        $pengaduans = $query->latest()->get();

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('dashboard.pdf', [
            'pengaduans' => $pengaduans,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
        ]);

        return $pdf->download('laporan-pengaduan.pdf');
    }

    public function show()
    {
        return view('dashboard.show', [
            'title' => 'My Profile',
            'user' => Auth::user()
        ]);
    }

    public function edit()
    {
        return view('dashboard.edit', [
            'title' => 'Edit Profile',
            'user' => Auth::user()
        ]);
    }

    public function update(Request $request)
    {
        try {
            DB::beginTransaction();

            $user = Auth::user();
            $validate = $request->validate([
                'name' => 'required',
                'password' => 'nullable|min:8',
                'passwordconfirm' => 'nullable|same:password',
                'email' => 'required|email|lowercase|unique:users,email,' . $user->id,
                'avatar' => 'nullable|image|mimes:png,jpg,jpeg,svg|max:512'
            ], [
                'name.required' => 'Nama wajib diisi',
                'password.min' => 'Password minimal 8 karakter',
                'passwordconfirm.same' => 'Konfirmasi password tidak cocok',
                'email.required' => 'Email wajib diisi',
                'email.email' => 'Format email tidak valid',
                'email.unique' => 'Email sudah terdaftar',
                'avatar.image' => 'File avatar harus berupa gambar',
                'avatar.mimes' => 'Format avatar harus png, jpg, jpeg, atau svg',
                'avatar.max' => 'Ukuran avatar tidak boleh lebih dari 512 KB',
            ]);

            if ($request->file('avatar')) {
                $validate['avatar'] = $request->file('avatar')->store('img', 'public');
                if ($user->avatar && Storage::disk('public')->exists($user->avatar)) {
                    Storage::disk('public')->delete($user->avatar);
                }
            }

            if ($request->password) {
                $validate['password'] = bcrypt($request->password);
            } else {
                unset($validate['password']);
            }
            $user->update($validate);

            DB::commit();
            return to_route('dashboard.show')->withSuccess('Data berhasil diubah');
        } catch (\Exception $e) {
            DB::rollBack();
            return to_route('dashboard.edit')->withError('Gagal mengubah data: ' . $e->getMessage());
        }
    }

    public function readNotification($id)
    {
        $notification = Auth::user()->notifications()->findOrFail($id);
        $notification->markAsRead();
        
        if (isset($notification->data['pengaduan_id'])) {
            return to_route('pengaduan.show', $notification->data['pengaduan_id']);
        }
        
        return back();
    }
}
