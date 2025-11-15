<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Artikel;
use App\Models\Pengajar;
use App\Models\Galeri;

class DashboardController extends Controller
{
    public function index()
    {
        $user_count            = User::count();
        $tenaga_pengajar_count = Pengajar::count();
        $artikel_count         = Artikel::count();
        $galeri_count          = Galeri::count();

        return view('dashboard.index', [
            'user_count'            => $user_count,
            'artikel_count'         => $artikel_count,
            'tenaga_pengajar_count' => $tenaga_pengajar_count,
            'galeri_count'          => $galeri_count
        ]);
    }
}
