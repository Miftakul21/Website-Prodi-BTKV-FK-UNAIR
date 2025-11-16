<?php

use App\Http\Controllers\AkademikController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BerandaController;
use App\Http\Controllers\ArtikelController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PengajarController;
use App\Http\Controllers\ProfilController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\GaleriController;
use App\Http\Controllers\InformasiController;
use Illuminate\Support\Facades\Route;

// public
Route::get('/', [BerandaController::class, 'index']);
Route::get('/berita', [ArtikelController::class, 'index'])->name('berita');
Route::get('/detail-berita/{slug}', [ArtikelController::class, 'detailArtikel']);
Route::get('/pengajar', [PengajarController::class, 'index']);
Route::get('/detail-pengajar/{slug}', [PengajarController::class, 'detailPengajar']);
// profil
Route::get('/profil/visi-misi-spesialis1-btkv-fk-unair', [ProfilController::class, 'visiDanMisi'])->name('visi-misi');
Route::get('/profil/fasilitas-spesialis1-btkv-fk-unair', [ProfilController::class, 'fasilitas'])->name('fasilitas');
Route::get('/profil/akreditasi-spesialis1-btkv-fk-unair', [ProfilController::class, 'akreditasi'])->name('akreditasi');
// akademik
Route::get('/akademik/kalender-akademik', [AkademikController::class, 'kalenderAkademik'])->name('kalender');
Route::get('/akademik/kurikulum-akademik', [AkademikController::class, 'kurikulumAkademik'])->name('kurikulum');
Route::get('/akademik/alumni', [AkademikController::class, 'alumniAkademik'])->name('alumni');
Route::get('/akademik/tugas-akhir', [AkademikController::class, 'tugasAkhirAkademik'])->name("tugas-akhir");
Route::get('/akademik/yudsium', [AkademikController::class, 'yudisiumAkademik'])->name('yudisium');
// informasi
Route::get('/informasi/prestasi', [InformasiController::class, 'prestasiInformasi'])->name('prestasi');
Route::get('/detail-prestasi/{slug}', [InformasiController::class, 'detailPrestasi']);
Route::get('informasi/hasil-karya', [InformasiController::class, 'hasilKaryaInformasi'])->name('hasil-karya');
Route::get('/detail-hasil-harya/{slug}', [InformasiController::class, 'detailHasilKarya']);
// Halaman login (GET) — beri nama 'login' supaya middleware bisa redirect ke sini
Route::get('/login-btkv-fk-unair', [AuthController::class, 'index'])->name('login');
Route::post('/login-authentication', [AuthController::class, 'authentication'])->name('login.process');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Protected routes
Route::middleware(['auth.login', 'user.online'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/anggota', [UserController::class, 'index'])->name('anggota')->middleware('permission:anggota');
    Route::get('/artikel-admin', [ArtikelController::class, 'artikelAdminIndex'])->name('artikel-admin')->middleware('permission:artikel'); // nanti diganti yang berita menjadi admin :permissionnya
    Route::get('/pengajar-admin', [PengajarController::class, 'pengajarAdminIndex'])->name('pengajar-admin')->middleware('permission:pengajar');
    Route::get('/galeri-admin', [GaleriController::class, 'galeriAdminIndex'])->name('galeri-admin')->middleware('permission:galeri');
    Route::get('/artikel-terhapus', [ArtikelController::class, 'deleteArtikelAll']);
    Route::get('/pengajar-terhapus', [PengajarController::class, 'deletePengajarAll']);

    // profil
    Route::get('/visi-misi-admin', [ProfilController::class, 'visiDanMisiAdminIndex'])->name('visi-misi-admin');
    Route::get('/fasilitas-admin', [ProfilController::class, 'fasilitasAdminIndex'])->name('fasilitas-admin');

    // akademik
    Route::get('/alumni-admin', [AkademikController::class, 'alumniAdminIndex'])->name('alumni-admin');
    Route::get('/kalender-admin', [AkademikController::class, 'kalenderAdminIndex'])->name('kalender-admin');
    Route::get('/kurikulum-admin', [AkademikController::class, 'kurikulumAdminIndex'])->name('kurikulum-admin');
    Route::get('/tugas-akhir-admin', [AkademikController::class, 'tugasAkhirAdminIndex'])->name('tugas-akhir-admin');
    Route::get('/yudisium-admin', [AkademikController::class, 'yudisiumAdminIndex'])->name('yudisium-admin');

    Route::post('/upload-image-ckeditor', [ArtikelController::class, 'uploadImageCKEditor'])
        ->name('ckeditor.upload');
});
