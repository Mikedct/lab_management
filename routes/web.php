<?php
// routes/web.php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\Auth\AdminLoginController;
use App\Http\Controllers\Admin\DashboardController as ADC;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\LabController;
use App\Http\Controllers\Admin\ComputerController;
use App\Http\Controllers\Admin\ScheduleController;

use App\Http\Controllers\user\Auth\UserAuthController;
use App\Http\Controllers\user\DashboardController as UDC;

// Redirect root ke user login
Route::get('/', function () {
    return redirect()->route('user.login');
});

// ============================================
// USER AUTH ROUTES
// ============================================
Route::prefix('user')->name('user.')->group(function () {
    Route::get('login', [UserAuthController::class, 'showLoginForm'])->name('login');
    Route::post('login', [UserAuthController::class, 'login'])->name('login.post');
});

// ============================================
// ADMIN AUTH ROUTES
// ============================================
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('login', [AdminLoginController::class, 'showLoginForm'])->name('auth.login');
    Route::post('login', [AdminLoginController::class, 'login'])->name('login.post');
});

// ============================================
// PROTECTED ADMIN ROUTES (Dengan Middleware)
// ============================================
Route::middleware(['admin.auth'])->prefix('admin')->name('admin.')->group(function () {

    // Dashboard
    Route::get('dashboard', [ADC::class, 'index'])->name('dashboard');

    // User Management - Resource Route (CRUD lengkap)
    Route::resource('users', UserController::class);

    // Schedule Management - Resource Route (CRUD lengkap)
    Route::resource('schedules', ScheduleController::class);

    Route::resource('lab', LabController::class);

    // Nested route untuk komputer dalam lab
    Route::prefix('lab/{labID}')->group(function () {
        Route::get('computer/create', [ComputerController::class, 'create'])->name('computer.create');
        Route::post('computer', [ComputerController::class, 'store'])->name('computer.store');
        Route::get('computer/{computerID}/edit', [ComputerController::class, 'edit'])->name('computer.edit');
        Route::put('computer/{computerID}', [ComputerController::class, 'update'])->name('computer.update');
        Route::delete('computer/{computerID}', [ComputerController::class, 'destroy'])->name('computer.destroy');
    });


    // Simpan komputer baru
    Route::post('lab/{lab}/computer', [LabController::class, 'storeComputer'])->name('admin.computer.store');

    // Logout
    Route::post('logout', [AdminLoginController::class, 'logout'])->name('logout');

    // User Management (uncomment when ready)
    // Route::resource('users', UserController::class);

    // Schedule Management (uncomment when ready)
    // Route::resource('schedules', ScheduleController::class);

    // Lab Monitoring (uncomment when ready)
    // Route::get('lab/status', [LabController::class, 'status'])->name('lab.status');

    // Route::get('lab', [LabController::class, 'index'])->name('lab.index');
});

Route::middleware(['user.auth'])->prefix('user')->name('user.')->group(function () {
    Route::get('dashboard', [UDC::class, 'index'])->name('dashboard');
    Route::post('logout', [UserAuthController::class, 'logout'])->name('logout');
});