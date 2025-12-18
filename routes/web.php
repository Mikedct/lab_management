<?php
// routes/web.php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\Auth\AdminLoginController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Admin\LabController as AdminLabController;
use App\Http\Controllers\Admin\ComputerController as AdminComputerController;
use App\Http\Controllers\Admin\ScheduleController as AdminScheduleController;

use App\Http\Controllers\user\Auth\UserAuthController;
use App\Http\Controllers\user\DashboardController as UserDashboardController;
use App\Http\Controllers\user\ScheduleController as UserScheduleController;
use App\Http\Controllers\user\ReportController as UserReportController;

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
    Route::get('dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

    // User Management - Resource Route (CRUD lengkap)
    Route::resource('users', AdminUserController::class);

    // Schedule Management - Resource Route (CRUD lengkap)
    Route::resource('schedules', AdminScheduleController::class);

    Route::resource('lab', AdminLabController::class);

    // Nested route untuk komputer dalam lab
    Route::prefix('lab/{labID}')->group(function () {
        Route::get('computer/create', [AdminComputerController::class, 'create'])->name('computer.create');
        Route::post('computer', [AdminComputerController::class, 'store'])->name('computer.store');
        Route::get('computer/{computerID}/edit', [AdminComputerController::class, 'edit'])->name('computer.edit');
        Route::put('computer/{computerID}', [AdminComputerController::class, 'update'])->name('computer.update');
        Route::delete('computer/{computerID}', [AdminComputerController::class, 'destroy'])->name('computer.destroy');
    });


    // Simpan komputer baru
    Route::post('lab/{lab}/computer', [AdminLabController::class, 'storeComputer'])->name('admin.computer.store');

    // Logout
    Route::post('logout', [AdminLoginController::class, 'logout'])->name('logout');

    // User Management (uncomment when ready)
    // Route::resource('users', UserController::class);

    // Schedule Management (uncomment when ready)
    // Route::resource('schedules', ScheduleController::class);

    // Lab Monitoring (uncomment when ready)
    // Route::get('lab/status', [AdminLabController::class, 'status'])->name('lab.status');

    // Route::get('lab', [AdminLabController::class, 'index'])->name('lab.index');
});

Route::middleware(['user.auth'])->prefix('user')->name('user.')->group(function () {
    Route::get('dashboard', [UserDashboardController::class, 'index'])->name('dashboard');
    Route::get('schedule', [UserScheduleController::class, 'index'])->name('schedule.index');
    Route::post('logout', [UserAuthController::class, 'logout'])->name('logout');
    Route::get('reports', [UserReportController::class, 'index'])->name('reports.index');
    Route::get('reports/create', [UserReportController::class, 'create'])->name('reports.create');
    Route::post('reports', [UserReportController::class, 'store'])->name('reports.store');
    Route::get('reports/{id}', [UserReportController::class, 'show'])->name('reports.show');

});