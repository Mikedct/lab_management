<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\KomputerController;
// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', [App\Http\Controllers\AdminAuthController::class, 'showLoginForm']);

Route::get('/loginadmin', [AdminAuthController::class, 'showLoginForm'])->name('admin.auth.login');
Route::post('/loginadmin', [AdminAuthController::class, 'login'])->name('admin.login.post');

Route::middleware('admin.auth')->group(function () {
    Route::get('/admin/dashboard', [KomputerController::class, 'index'])->name('admin.dashboard');
    Route::post('/admin/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');
});

Route::get('/admin/dashboard', [AdminAuthController::class, 'dashboard'])->name('admin.dashboard');

Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminAuthController::class, 'dashboard'])->name('dashboard');
});