<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ReportController;

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

// Callback Midtrans (tanpa auth)
Route::post('/midtrans/callback', [OrderController::class, 'callback'])->name('midtrans.callback');

// Route yang membutuhkan autentikasi
Route::middleware('auth')->group(function () {

    // DASHBOARD - Semua role bisa akses
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');

    // PRODUCT - Lihat stok untuk semua role yang diizinkan
    // Index + show untuk Administrator, Cashier, Leader
    Route::middleware('role:Administrator,Cashier,Leader')->group(function () {
        Route::get('/product', [ProductController::class, 'index'])->name('product.index');

        // Batasi parameter product menjadi angka agar /product/create
        // tidak tertangkap oleh route show.
        Route::get('/product/{product}', [ProductController::class, 'show'])
            ->whereNumber('product')
            ->name('product.show');
    });

    // MASTER DATA - Hanya Administrator
    Route::middleware('role:Administrator')->group(function () {
        // User, Category, Role - Full CRUD
        Route::resource('user', UserController::class);
        Route::resource('category', CategoryController::class);
        Route::resource('role', RoleController::class);

        // Product - create/store/edit/update/destroy
        // /product/create sekarang tidak akan bentrok dengan /product/{product}
        Route::resource('product', ProductController::class)->except(['index', 'show']);
    });

    // TRANSAKSI - Administrator & Kasir
    Route::middleware('role:Administrator,Cashier')->group(function () {
        Route::resource('order', OrderController::class);
        Route::get('/order/{id}/print', [OrderController::class, 'printReceipt'])->name('order.print');
    });

    // LAPORAN - Administrator & Pimpinan
    Route::middleware('role:Administrator,Leader')->group(function () {
        Route::get('/report/daily', [ReportController::class, 'daily'])->name('report.daily');
        Route::get('/report/weekly', [ReportController::class, 'weekly'])->name('report.weekly');
        Route::get('/report/monthly', [ReportController::class, 'monthly'])->name('report.monthly');
    });

    // Logout
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
});