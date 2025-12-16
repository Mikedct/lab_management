<?php
// routes/web.php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\Auth\AdminLoginController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\LabController;
use App\Http\Controllers\Admin\ComputerController;
use App\Http\Controllers\Admin\ScheduleController;

// Redirect root ke login
Route::get('/', function () {
    return redirect()->route('admin.auth.login');
});

// ============================================
// AUTH ROUTES (Tanpa Middleware)
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
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');

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