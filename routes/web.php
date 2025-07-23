<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/dashboard', function () {
        return 'Halaman Admin';
    });
});

Route::middleware(['auth', 'role:pegawai'])->group(function () {
    Route::get('/pegawai/dashboard', function () {
        return 'Halaman Pegawai';
    });
});

Route::middleware(['auth', 'role:kepsek'])->group(function () {
    Route::get('/kepsek/dashboard', function () {
        return 'Halaman Kepala Sekolah';
    });
});


require __DIR__ . '/auth.php';
