<?php

use App\Http\Controllers\ProgramController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\FaqController;
use App\Http\Controllers\HomeController; // Add this use statement
use Illuminate\Support\Facades\Route;
use App\Models\User;
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

// Corrected home route to use HomeController
Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/kejuruan', [ProgramController::class, 'kejuruan'])->name('kejuruan');

// Public FAQ routes
Route::get('/faq', [FaqController::class, 'index'])->name('faq.index');

// Registration routes
Route::prefix('pendaftaran')->name('registration.')->group(function () {
    // Step 1: Personal Data
    Route::get('/langkah-1', [RegistrationController::class, 'createStep1'])->name('create.step1');
    Route::post('/langkah-1', [RegistrationController::class, 'storeStep1'])->name('store.step1');

    // Step 2: Additional Info
    Route::get('/langkah-2', [RegistrationController::class, 'createStep2'])->name('create.step2');
    Route::post('/langkah-2', [RegistrationController::class, 'storeStep2'])->name('store.step2');

    // Step 3: Document Upload
    Route::get('/langkah-3', [RegistrationController::class, 'createStep3'])->name('create.step3');
    Route::post('/langkah-3', [RegistrationController::class, 'storeStep3'])->name('store.step3');
    
    // Step 4: Confirmation
    Route::get('/konfirmasi', [RegistrationController::class, 'confirmation'])->name('confirmation');
    
    // Final Store
    Route::post('/store', [RegistrationController::class, 'store'])->name('store');
    
    // Success Page
    Route::get('/sukses', [RegistrationController::class, 'success'])->name('success');
});

// Authentication routes
Route::get('/login', [AuthController::class, 'loginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Admin routes
Route::prefix('admin')->name('admin.')->middleware(['auth', AdminAuthMiddleware::class])->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

    // Program CRUD routes
    Route::resource('programs', ProgramController::class);

    // Registration verification routes
    Route::get('/verified-registrations', [AdminController::class, 'verifiedRegistrations'])->name('registrations.verified');
    Route::get('/verify-registrations', [AdminController::class, 'verifyRegistrations'])->name('registrations.verify');
    Route::patch('/verify-registrations/{registration}', [AdminController::class, 'updateRegistrationStatus'])->name('registrations.updateStatus');

    // FAQ CRUD routes for Admin
    Route::resource('faq', FaqController::class)->except(['show']);
});
