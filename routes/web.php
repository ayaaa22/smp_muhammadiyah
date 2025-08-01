<?php

use App\Http\Controllers\Admin\JabatanController;
use App\Http\Controllers\Admin\JenisCutiController;
use App\Http\Controllers\Admin\PegawaiController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Kepsek\PegawaiController as KepsekPegawaiController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::prefix('/admin')->group(function () {
        Route::get('/dashboard', function () {
            return view('pages.admin.index');
        });
        Route::get('/jabatan', [JabatanController::class, 'index'])->name('jabatan.index');
        Route::post('/jabatan/store', [JabatanController::class, 'store'])->name('jabatan.store');
        Route::put('/jabatan/{id}', [JabatanController::class, 'update'])->name('jabatan.update');
        Route::delete('/jabatan/{id}', [JabatanController::class, 'delete'])->name('jabatan.delete');

        Route::get('/pegawai', [PegawaiController::class, 'index'])->name('pegawai.index');
        Route::get('/pegawai/add', [PegawaiController::class, 'create'])->name('pegawai.add');
        Route::post('/pegawai', [PegawaiController::class, 'store'])->name('pegawai.store');
        Route::get('/pegawai/{id}/edit', [PegawaiController::class, 'edit'])->name('pegawai.edit');
        Route::put('/pegawai/{id}', [PegawaiController::class, 'update'])->name('pegawai.update');
        Route::delete('/pegawai/{id}', [PegawaiController::class, 'delete'])->name('pegawai.delete');

        Route::get('/jenis-cuti', [JenisCutiController::class, 'index'])->name('jenis-cuti.index');
        Route::post('/jenis-cuti', [JenisCutiController::class, 'store'])->name('jenis-cuti.store');
        Route::put('/jenis-cuti/{id}', [JenisCutiController::class, 'update'])->name('jenis-cuti.update');
        Route::delete('/jenis-cuti/{id}', [JenisCutiController::class, 'delete'])->name('jenis-cuti.delete');

        Route::get('users', [UserController::class, 'index'])->name('user.index');
        Route::post('/users/store', [UserController::class, 'store'])->name('user.store');
        Route::put('/user/{id}', [UserController::class, 'update'])->name('user.update');
        Route::delete('/user/{id}', [UserController::class, 'delete'])->name('user.delete');
    });
});

Route::middleware(['auth', 'role:pegawai'])->group(function () {
    Route::prefix('/pegawai')->group(function () {
        Route::get('/dashboard', function () {
            return view('pages.pegawai.index');
        });
    });
});

Route::middleware(['auth', 'role:kepsek'])->group(function () {
    Route::prefix('/kepsek')->group(function () {
        Route::get('/dashboard', function () {
            return view('pages.kepsek.index');
        });
        Route::get('/pegawai', [KepsekPegawaiController::class, 'index'])->name('kepsek-pegawai.index');
        Route::get('/pegawai/add', [KepsekPegawaiController::class, 'create'])->name('kepsek-pegawai.add');
        Route::post('/pegawai', [KepsekPegawaiController::class, 'store'])->name('kepsek-pegawai.store');
        Route::get('/pegawai/{id}/edit', [KepsekPegawaiController::class, 'edit'])->name('kepsek-pegawai.edit');
        Route::put('/pegawai/{id}', [KepsekPegawaiController::class, 'update'])->name('kepsek-pegawai.update');
        Route::delete('/pegawai/{id}', [KepsekPegawaiController::class, 'delete'])->name('kepsek-pegawai.delete');
    });
});


require __DIR__ . '/auth.php';
