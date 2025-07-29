<?php

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
    });
});


require __DIR__ . '/auth.php';
