<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use App\Models\User;

class ProfileController extends Controller
{
    /**
     * Tampilkan halaman profil beserta tab Overview, Edit, Password.
     */
    public function index()
    {
        return view('profile.index', [
            'title' => 'Profil Saya',
            'user' => Auth::user()
        ]);
    }

    /**
     * Update data profil (Nama, Email, NIK, Telp, Avatar).
     */
    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $validate = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|lowercase|unique:users,email,' . $user->id,
            'nik' => 'nullable|numeric|digits_between:16,16|unique:users,nik,' . $user->id,
            'telp' => 'nullable|string|max:15|unique:users,telp,' . $user->id,
            'avatar' => 'nullable|image|mimes:png,jpg,jpeg|max:2048'
        ], [
            'name.required' => 'Nama wajib diisi',
            'email.required' => 'Email wajib diisi',
            'email.unique' => 'Email sudah digunakan',
            'nik.digits_between' => 'NIK harus 16 digit',
            'nik.unique' => 'NIK sudah terdaftar',
            'telp.unique' => 'Nomor Telepon sudah terdaftar',
            'avatar.image' => 'File harus berupa gambar',
            'avatar.max' => 'Ukuran avatar maksimal 2MB',
        ]);

        DB::beginTransaction();
        try {
            if ($request->hasFile('avatar')) {
                // Delete old avatar if exists
                if ($user->avatar && Storage::disk('public')->exists($user->avatar)) {
                    Storage::disk('public')->delete($user->avatar);
                }
                $validate['avatar'] = $request->file('avatar')->store('img', 'public');
            }

            $user->update($validate);
            DB::commit();

            return back()->withSuccess('Profil berhasil diperbarui!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withError('Gagal memperbarui profil: ' . $e->getMessage());
        }
    }

    /**
     * Update Password.
     */
    public function updatePassword(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'current_password' => 'required',
            'password' => 'required|min:8|confirmed',
        ], [
            'current_password.required' => 'Password saat ini wajib diisi',
            'password.required' => 'Password baru wajib diisi',
            'password.min' => 'Password baru minimal 8 karakter',
            'password.confirmed' => 'Konfirmasi password tidak cocok',
        ]);

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withError('Password saat ini tidak sesuai!');
        }

        DB::beginTransaction();
        try {
            $user->update([
                'password' => Hash::make($request->password)
            ]);
            DB::commit();

            return back()->withSuccess('Password berhasil diubah!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withError('Gagal mengubah password: ' . $e->getMessage());
        }
    }
}
