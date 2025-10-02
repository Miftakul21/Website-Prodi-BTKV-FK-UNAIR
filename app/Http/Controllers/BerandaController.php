<?php

namespace App\Http\Controllers;

use App\Models\Berita;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class BerandaController extends Controller
{
    public function index()
    {
        $berita = Cache::remember('beritas', '100', function () {
            return Berita::with('user:id_user')
                ->select(
                    'id_berita as berita_id',
                    'judul as berita_title',
                    'tgL_berita as berita_date',
                    'kategori as berita_category',
                    'thumbnail_image as berita_thumbnail',
                    'konten_berita as berita_content',
                    'viewers as views_count',
                )
                ->latest()
                ->get(4);
        });

        return view('beranda', [
            'berita' => $berita
        ]);
    }
}
