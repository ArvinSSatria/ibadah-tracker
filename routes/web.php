<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RiwayatController;
use App\Http\Controllers\ShalatLogController;
use App\Http\Controllers\IbadahLainController;
use App\Http\Controllers\TilawahLogController;

// Mengarahkan halaman utama langsung ke halaman registrasi.
Route::get('/', function () {
    return redirect()->route('register');
});

// Semua rute yang memerlukan login dimasukkan ke dalam grup ini.
Route::middleware('auth')->group(function () {
    // Rute Dasbor yang benar, memanggil Controller untuk mengambil data.
    Route::get('/dashboard', [ShalatLogController::class, 'index'])->name('dashboard');

    // Rute untuk Profil Pengguna
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::post('/ibadah-lain/track', [IbadahLainController::class, 'storeTrackedIbadah'])->name('ibadah-lain.track');
    Route::post('/ibadah-lain/log', [IbadahLainController::class, 'toggleLog'])->name('ibadah-lain.log');

    // Rute untuk menyimpan data ibadah
    Route::post('/shalat-log', [ShalatLogController::class, 'store'])->name('shalat-log.store');
    Route::post('/tilawah-log', [TilawahLogController::class, 'store'])->name('tilawah-log.store');

    // Rute untuk halaman Riwayat
    Route::get('/riwayat', [RiwayatController::class, 'index'])->name('riwayat.index');

    // routes/web.php
    Route::patch('/shalat-log/detail/{shalatLog}', [ShalatLogController::class, 'updateDetails'])->name('shalat-log.details.update');
});

require __DIR__ . '/auth.php';
