<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminAuthController;

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', [App\Http\Controllers\KomputerController::class, 'index']);

Route::get('/admin/login', [AdminAuthController::class, 'showLoginForm'])->name('admin.login');
Route::post('/admin/login', [AdminAuthController::class, 'login'])->name('admin.login.post');

Route::middleware('admin.auth')->group(function () {
    Route::get('/admin/dashboard', [AdminAuthController::class, 'dashboard'])->name('admin.dashboard');
    Route::post('/admin/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');
});

