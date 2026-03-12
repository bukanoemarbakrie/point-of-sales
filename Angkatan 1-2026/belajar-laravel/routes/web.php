<?php


use App\Http\Controllers\PerhitunganController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;


//get = melihat data atau menampilkannya
//post = mengirim data
//put/patch = merubah atau mengedit data
//delete = menghapus data
Route::get('navbar', function () {
    return view('inc.navbar');
});
//Tampilan form perhitungan
Route::get('perhitungan', function () {
    return view('perhitungan.index');
})->name('perhitungan.index');
//Aksi perhitungannya
Route::post('perhitungan ', [PerhitunganController::class, 'store'])->name('perhitungan.store');

//Tampilan Luas Permukaan Kubus
Route::get(
    'luaspermukaankubus',
    [PerhitunganController::class, 'indexLPkubus']
)->name('luaspermukaankubus.index');
//Aksi perhitungan LP kubus
Route::post('luaspermukaankubus', [PerhitunganController::class, 'storeLPkubus'])->name('luaspermukaankubus.store');

//Tampilan Volume Kubus
Route::get(
    'volumekubus',
    [PerhitunganController::class, 'indexVkubus']
)->name('volumekubus.index');
//Aksi perhitungan V kubus
Route::post('volumekubus', [PerhitunganController::class, 'storeVkubus'])->name('volumekubus.store');


//Tampilan Luas Permukaan Tabung
Route::get(
    'luaspermukaantabung',
    [PerhitunganController::class, 'indexLPtabung']
)->name('luaspermukaantabung.index');
//Aksi perhitungan LP tabung
Route::post('luaspermukaantabung', [PerhitunganController::class, 'storeLPtabung'])->name('luaspermukaantabung.store');

//Tampilan Volume Tabung
Route::get('volumetabung',[PerhitunganController::class, 'indexVtabung'])->name('volumetabung.index');
//Aksi perhitungan V tabung
Route::post('volumetabung', [PerhitunganController::class, 'storeVtabung'])->name('volumetabung.store');


// Route::get('volumelimas', [VolumeLimasController::class,'index'])->name('volumelimas.index');

// Route::get('volumelimas/create', [VolumeLimasController::class,'create'])->name('volumelimas.create');

// Route::post('volumelimas', [VolumeLimasController::class, 'store'])->name('volumelimas.store');

// Route::get('volumelimas/edit/{id}', [VolumeLimasController::class,'edit'])->name('volumelimas.edit');

// Route::put('volumelimas/update/{id}', [VolumeLimasController::class,'update'])->name('volumelimas.update');

// Route::delete('volumelimas/delete/{id}', [VolumeLimasController::class,'destroy'])->name('volumelimas.destroy');

Route::resource('volumelimas', App\Http\Controllers\VolumeLimasController::class);

Route::resource('pesertapelatihan', App\Http\Controllers\PesertaPelatihanController::class);

Route::get('belajar-laravel', [\App\Http\Controllers\BelajarController::class, 'index']);
Route::get('siswa', [\App\Http\Controllers\BelajarController::class, 'getSiswa']);

Route::get('create', [\App\Http\Controllers\BelajarController::class, 'create'])->name('siswa.create');
Route::post('store', [\App\Http\Controllers\BelajarController::class, 'store'])->name('siswa.store');

Route::get('/', [\App\Http\Controllers\LoginController::class, 'index']);
Route::post('action-login', [\App\Http\Controllers\LoginController::class, 'actionLogin'])->name('action-login');
Route::post('logout', [\App\Http\Controllers\LoginController::class, 'logout'])->name('logout');


Route::resource('user', UserController::class);
Route::resource('role', RoleController::class);
Route::resource('student', \App\Http\Controllers\StudentController::class);

Route::resource('attendance', \App\Http\Controllers\AttendanceController::class);

Route::get('dashboard', [\App\Http\Controllers\DashboardController::class, 'index']);
