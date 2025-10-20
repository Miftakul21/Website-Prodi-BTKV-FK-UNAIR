<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Berita;
use App\Models\Pengajar;

class DashboardController extends Controller
{
    public function index()
    {
        $user_count            = User::count();
        $tenaga_pengajar_count = Pengajar::count();
        $berita_count          = Berita::count();

        return view('dashboard.index', [
            'user_count'            => $user_count,
            'berita_count'          => $berita_count,
            'tenaga_pengajar_count' => $tenaga_pengajar_count,
        ]);
    }
}
