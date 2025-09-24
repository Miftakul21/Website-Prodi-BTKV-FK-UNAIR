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


// Nanti Ya
Route::get('/berita', [BeritaController::class, 'index']);
Route::get('/detail-berita', [BeritaController::class, 'detailBerita']);
Route::get('/daftar-pengajar', [PengajarController::class, 'index']);
Route::get('/profile/pengajar/', [PengajarController::class, 'detailPengajar']);

Route::get('/login-admin-panel', [AuthController::class, 'index']);
// middleware authentication
Route::get('/dashboard', [DashboardController::class, 'index'])->name('anggota');
Route::get('/anggota', [UserController::class, 'index']);
Route::get('/berita-admin', [BeritaCOntroller::class, 'beritaAdminIndex']);
