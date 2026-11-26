<?php

use App\Http\Controllers\PasienController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('pasien.index');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Semua role yang login pakai URL yang sama: /pasien
// Pasien melihat form tambah, role lain melihat daftar
Route::middleware('auth')->group(function () {
    Route::get('/pasien', [PasienController::class, 'index'])->name('pasien.index');
    Route::post('/pasien', [PasienController::class, 'store'])->name('pasien.store');
});

// Admin, dokter, dan perawat boleh melihat detail dan mengubah data
Route::middleware(['auth', 'role:admin,doctor,nurse'])->group(function () {
    Route::get('/pasien/{pasien}', [PasienController::class, 'show'])->name('pasien.show');
    Route::get('/pasien/{pasien}/edit', [PasienController::class, 'edit'])->name('pasien.edit');
    Route::put('/pasien/{pasien}', [PasienController::class, 'update'])->name('pasien.update');
    Route::patch('/pasien/{pasien}', [PasienController::class, 'update']);
});

// Hanya admin yang boleh menghapus pasien
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::delete('/pasien/{pasien}', [PasienController::class, 'destroy'])->name('pasien.destroy');
});

require __DIR__.'/auth.php';