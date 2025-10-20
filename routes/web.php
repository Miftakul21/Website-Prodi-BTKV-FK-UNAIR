<?php

use App\Http\Controllers\AkademikController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BerandaController;
use App\Http\Controllers\BeritaController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PengajarController;
use App\Http\Controllers\ProfilController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\GaleriController;
use Illuminate\Support\Facades\Route;

// public
Route::get('/', [BerandaController::class, 'index']);
Route::get('/berita', [BeritaController::class, 'index'])->name('berita');
Route::get('/detail-berita/{slug}', [BeritaController::class, 'detailBerita']);
Route::get('/pengajar', [PengajarController::class, 'index']);
Route::get('/detail-pengajar/{slug}', [PengajarController::class, 'detailPengajar']);
Route::get('/galeri', [GaleriController::class, 'index']);
Route::get('/detail-galeri/{slug}', [GaleriController::class, 'detailGaleri']);
// profil
Route::get('/profil/visi-misi-spesialis1-btkv-fk-unair', [ProfilController::class, 'visiDanMisi'])->name('visi-misi');
Route::get('/profil/fasilitas-spesialis1-btkv-fk-unair', [ProfilController::class, 'fasilitas'])->name('fasilitas');
Route::get('/profil/akreditasi-spesialis1-btkv-fk-unair', [ProfilController::class, 'akreditasi'])->name('akreditasi');
// akademik
Route::get('/akademik/kalender-akademik', [AkademikController::class, 'kalenderAkademik'])->name('kalender');
// Halaman login (GET) — beri nama 'login' supaya middleware bisa redirect ke sini
Route::get('/login-btkv-fk-unair', [AuthController::class, 'index'])->name('login');
Route::post('/login-authentication', [AuthController::class, 'authentication'])->name('login.process');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Protected routes
Route::middleware(['auth.login', 'user.online'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/anggota', [UserController::class, 'index'])->name('anggota')->middleware('permission:anggota');
    Route::get('/berita-admin', [BeritaController::class, 'beritaAdminIndex'])->name('berita-admin')->middleware('permission:berita');
    Route::get('/pengajar-admin', [PengajarController::class, 'pengajarAdminIndex'])->name('pengajar-admin')->middleware('permission:pengajar');
    Route::get('/galeri-admin', [GaleriController::class, 'galeriAdminIndex'])->name('galeri-admin')->middleware('permission:galeri');
    Route::get('/berita-terhapus', [BeritaController::class, 'deleteBeritaAll']);
    Route::get('/pengajar-terhapus', [PengajarController::class, 'deletePengajarAll']);

    Route::post('/upload-image-ckeditor', [BeritaController::class, 'uploadImageCKEditor'])
        ->name('ckeditor.upload');
});
