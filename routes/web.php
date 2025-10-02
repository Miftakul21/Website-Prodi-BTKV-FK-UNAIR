<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BerandaController;
use App\Http\Controllers\BeritaController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PengajarController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

// Public
Route::get('/', [BerandaController::class, 'index']);
Route::get('/berita', [BeritaController::class, 'index']);
Route::get('/detail-berita', [BeritaController::class, 'detailBerita']);
Route::get('/daftar-pengajar', [PengajarController::class, 'index']);
Route::get('/profile/pengajar/', [PengajarController::class, 'detailPengajar']);

// Halaman login (GET) — beri nama 'login' supaya middleware bisa redirect ke sini
Route::get('/login-btkv-fk-unair', [AuthController::class, 'index'])->name('login');

// Proses login (POST) — beri nama lain
Route::post('/login-authentication', [AuthController::class, 'authentication'])->name('login.process');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Protected routes
Route::middleware('auth.login')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/anggota', [UserController::class, 'index'])->name('anggota');
    Route::get('/berita-admin', [BeritaController::class, 'beritaAdminIndex'])->name('berita-admin');
    Route::get('/pengajar-admin', [PengajarController::class, 'pengajarAdminIndex'])->name('pengajar-admin');

    Route::get('/berita-terhapus', [BeritaController::class, 'deleteBeritaAll']);
    Route::get('/pengajar-terhapus', [PengajarController::class, 'deletePengajarAll']);

    Route::post('/upload-image-ckeditor', [BeritaController::class, 'uploadImageCKEditor'])
        ->name('ckeditor.upload');
});
