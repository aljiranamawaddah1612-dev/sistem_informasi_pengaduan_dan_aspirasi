<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\PengaduanController;
use App\Http\Controllers\TanggapanController;
use App\Http\Controllers\AspirasiController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\InstansiController;
use App\Http\Controllers\WilayahController;
use App\Http\Controllers\PengumumanController;
use App\Http\Controllers\FaqController;
use App\Http\Controllers\UlasanController;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware('guest')->group(function () {
    Route::get('/', [LoginController::class, 'index'])->name('login');
    Route::post('/authenticate', [LoginController::class, 'authenticate'])->name('login.authenticate');
});

Route::middleware('auth')->group(function () {
    Route::get('/logout', [LoginController::class, 'logout'])->name('login.logout');
    Route::post('/switch-user', [LoginController::class, 'switchUser'])->name('login.switch_user');

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');
    Route::get('/dashboard/export-pdf', [DashboardController::class, 'exportPdf'])->name('dashboard.exportPdf');
    Route::get('/notifikasi/{id}/read', [DashboardController::class, 'readNotification'])->name('notifikasi.read');

    // Laporan (Admin & Petugas)
    Route::middleware('role:admin,petugas')->group(function () {
        Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.index');
        Route::get('/laporan/export-pdf', [LaporanController::class, 'exportPdf'])->name('laporan.exportPdf');
        Route::get('/laporan/export-excel', [LaporanController::class, 'exportExcel'])->name('laporan.exportExcel');
    });

    // Profile Management
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::put('/profile/update', [ProfileController::class, 'updateProfile'])->name('profile.update');
    Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password');

    Route::resource('/user', UserController::class)->middleware('role:admin');
    Route::resource('/kategori', KategoriController::class)->middleware('role:admin');
    
    // Pengaduan
    Route::resource('/pengaduan', PengaduanController::class)->except(['store']);
    Route::post('/pengaduan', [PengaduanController::class, 'store'])->name('pengaduan.store')->middleware('throttle:pengaduan');
    
    Route::resource('/aspirasi', AspirasiController::class);
    Route::post('/tanggapan', [TanggapanController::class, 'store'])->name('tanggapan.store');

    // New tables routes
    Route::resource('/instansi', InstansiController::class)->middleware('role:admin');
    Route::resource('/wilayah', WilayahController::class)->middleware('role:admin');
    Route::resource('/pengumuman', PengumumanController::class)->middleware('role:admin,petugas');
    Route::resource('/faq', FaqController::class)->middleware('role:admin');
    Route::resource('/ulasan', UlasanController::class);

    Route::get('/setting', [SettingController::class, 'index'])->name('setting.index');
    Route::put('/setting/{setting}/update', [SettingController::class, 'update'])->name('setting.update');
});
