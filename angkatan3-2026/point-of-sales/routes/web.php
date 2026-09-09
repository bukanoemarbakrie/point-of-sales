<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\MenuController;

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Route untuk login (tanpa auth)
Route::prefix('admin')->group(function () {
    Route::get("/", [LoginController::class, 'login'])->name('login');
    Route::get("/login", [LoginController::class, 'login'])->name('login');
    Route::post('/action-login', [LoginController::class, 'actionLogin'])->name('action-login');
});

// Route yang membutuhkan autentikasi
Route::middleware('auth')->group(function () {
    Route::resource('dashboard', DashboardController::class);
    Route::resource('user', UserController::class);  // ← Sudah ada
    Route::resource('category', CategoryController::class);
    Route::resource('role', RoleController::class);
    Route::resource('product', ProductController::class);

    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
});
