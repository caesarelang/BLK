<?php

use App\Http\Controllers\NewRegistrationController;
use App\Http\Controllers\ProgramController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\FaqController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ParticipantController;
use App\Http\Controllers\MateriController; 
use App\Http\Controllers\SoalController; 
use Illuminate\Support\Facades\Route;
use App\Models\User;
use App\Http\Middleware\AdminAuthMiddleware;

Route::get('/registration/check', [NewRegistrationController::class, 'check'])->name('registration.check');
Route::post('/registration/check', [NewRegistrationController::class, 'check'])->name('registration.check');
// New registration routes
Route::get('/daftar', [NewRegistrationController::class, 'index'])->name('registration.new');
Route::post('/daftar/submit', [NewRegistrationController::class, 'store'])->name('registration.submit');
Route::get('/daftar/success', [NewRegistrationController::class, 'success'])->name('registration.success'); // Add this line

// Other routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/kejuruan', [ProgramController::class, 'kejuruan'])->name('kejuruan');
Route::get('/faq', [FaqController::class, 'index'])->name('faq.index');

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

// Authentication routes
Route::get('/login', [AuthController::class, 'loginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Admin routes
Route::prefix('admin')->name('admin.')->middleware(['auth', AdminAuthMiddleware::class])->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::resource('programs', ProgramController::class);
  
Route::patch('/registrations/{registration}/status', [AdminController::class, 'updateStatus'])->name('registrations.update-status');
    Route::patch('/registrations/{registration}/retake-exam', [AdminController::class, 'retakeExam'])->name('registrations.retake-exam');
    Route::get('/verified-registrations', [AdminController::class, 'verifiedRegistrations'])->name('registrations.verified');
    Route::get('/verify-registrations', [AdminController::class, 'verifyRegistrations'])->name('registrations.verify');
    Route::patch('/verify-registrations/{registration}', [AdminController::class, 'updateRegistrationStatus'])->name('registrations.updateStatus');
    Route::resource('faq', FaqController::class)->except(['show']);
    Route::resource('soal', SoalController::class)->parameters([
    'soal' => 'materi'
]);

});
// Participant routes
Route::prefix('peserta')->name('peserta.')->middleware(['auth'])->group(function () {
    Route::get('/dashboard', [ParticipantController::class, 'dashboard'])->name('dashboard');
    // Add more participant routes as needed
    Route::get('/profile', [ParticipantController::class, 'profile'])->name('profile');
    Route::put('/profile', [ParticipantController::class, 'updateProfile'])->name('profile.update');
  Route::get('/program', [MateriController::class, 'index'])->name('program');
    Route::get('/program/{id}', [MateriController::class, 'show'])->name('program.show');
    Route::post('/program/{id}/submit', [MateriController::class, 'submitAnswers'])->name('program.submit');
    Route::get('/program/{id}/result', [MateriController::class, 'showResult'])->name('program.result');
});