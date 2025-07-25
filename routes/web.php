<?php

use App\Http\Controllers\PelatihanController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PendaftaranController;
use Illuminate\Support\Facades\Route;
use App\Models\User;
use App\Models\Pengumuman;
use App\Http\Middleware\AdminAuthMiddleware;

Route::get('/make-alip-admin', function () {
    $user = User::where('name', 'Alip User')->first();
    if ($user) {
        $user->role = 'admin';
        $user->is_admin = 1;
        $user->save();
        return "User 'Alip User' is now an admin.";
    }
    return "User 'Alip User' not found.";
});

Route::get('/', function () {
    return view('home');
});

Route::get('/kejuruan', [PelatihanController::class, 'kejuruan'])->name('kejuruan');

Route::get('/pengumuman', function () {
    $pengumumans = Pengumuman::where('is_published', true)
                                ->latest() // Mengurutkan dari yang terbaru
                                ->get();
    return view('pengumuman', compact('pengumumans'));
})->name('pengumuman');


// Route untuk halaman cek NIK dan Nama
Route::get('/pendaftaran/cek', [PendaftaranController::class, 'checkForm'])->name('pendaftaran.checkForm');
Route::post('/pendaftaran/cek', [PendaftaranController::class, 'checkRegistration'])->name('pendaftaran.check');

// Route untuk pendaftaran lengkap (hanya bisa diakses setelah cek NIK/Nama)
Route::get('/pendaftaran/lengkap/{nik}/{nama_lengkap}', [PendaftaranController::class, 'create'])->name('pendaftaran.create');
Route::post('/pendaftaran', [PendaftaranController::class, 'store'])->name('pendaftaran.store');

// Route setelah pendaftaran sukses
Route::get('/pendaftaran/sukses', function () {
    return view('pendaftaran.sukses');
})->name('pendaftaran.sukses');

// Authentication routes
Route::get('/login', [AuthController::class, 'loginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Admin routes
Route::prefix('admin')->middleware(['auth', AdminAuthMiddleware::class])->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/pelatihan', [AdminController::class, 'pelatihan'])->name('admin.pelatihan.index');

    // Pelatihan CRUD routes
    Route::post('/pelatihan', [PelatihanController::class, 'store'])->name('admin.pelatihan.store');
    Route::put('/pelatihan/{id_pelatihan}', [PelatihanController::class, 'update'])->name('admin.pelatihan.update');
    Route::delete('/pelatihan/{id_pelatihan}', [PelatihanController::class, 'destroy'])->name('admin.pelatihan.destroy');

    Route::get('/data-peserta', [AdminController::class, 'verifiedParticipants'])->name('admin.data.peserta');
    Route::get('/verifikasi-peserta', [AdminController::class, 'verifyParticipants'])->name('admin.verifikasi.peserta');
    Route::patch('/verifikasi-peserta/{pendaftaran}', [AdminController::class, 'updateVerification'])->name('admin.verifikasi.peserta.update');
});
