<?php

namespace App\Http\Controllers;

use App\Models\Berita;
use App\Models\Pengajar;
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
                    'tgl_berita as berita_date',
                    'kategori as berita_category',
                    'thumbnail_image as berita_thumbnail',
                    'konten_berita as berita_content',
                    'viewers as views_count',
                    'slug as berita_slug'
                )
                ->latest()
                ->get(4);
        });

        $pengajar = Cache::remember('pengajars', '100', function () {
            return Pengajar::select(
                'id_pengajar as pengajar_id',
                'name as pengajar_name',
                'posisi as pengajar_posistion',
                'pendidikan as pengajar_pendidikan',
                'foto as pengajar_image'
            )
                ->latest()
                ->paginate(4);
        });

        return view('beranda', [
            'berita' => $berita,
            'pengajar' => $pengajar
        ]);
    }
}
