<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BeritaController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PengajarController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('beranda');
});

// nanti ya
Route::get('/berita', [BeritaController::class, 'index']);
Route::get('/detail-berita', [BeritaController::class, 'detailBerita']);
Route::get('/daftar-pengajar', [PengajarController::class, 'index']);
Route::get('/profile/pengajar/', [PengajarController::class, 'detailPengajar']);

Route::get('/login-admin-panel', [AuthController::class, 'index']);
Route::post('/login-authentication', [AuthController::class, 'authentication'])->name('login');

// middleware authentication
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
Route::get('/anggota', [UserController::class, 'index'])->name('anggota');
Route::get('/berita-admin', [BeritaController::class, 'beritaAdminIndex'])->name('berita-admin');
Route::get('/pengajar-admin', [PengajarController::class, 'pengajarAdminIndex'])->name('pengajar-admin');

// delete all
Route::get('/berita-terhapus', [BeritaController::class, 'deleteBeritaAll']);

// upload iamge ckeditor
Route::post('/upload-image-ckeditor', [BeritaController::class, 'uploadImageCKEditor'])->name('ckeditor.upload');
