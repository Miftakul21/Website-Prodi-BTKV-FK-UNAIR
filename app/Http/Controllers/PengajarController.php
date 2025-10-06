<?php

namespace App\Http\Controllers;

use App\Models\Pengajar;
use Illuminate\Http\Request;

class PengajarController extends Controller
{
    public function index()
    {
        return view('pengajar.pengajar');
    }

    public function detailPengajar($slug)
    {
        $pengajar = Pengajar::where('slug', $slug)->firstOrFail();

        $data = [
            'pengajar_name' => $pengajar->name,
            'pengajar_position' => $pengajar->posisi,
            'pengajar_pendidikan' => $pengajar->pendidikan,
            'pengajar_image' => $pengajar->foto,
            'pengajar_biography' => $pengajar->biografi,
            'pengajar_bidang_penelitian' => $pengajar->pakar_penelitian,
            'pengajar_publikasi_penelitian' => $pengajar->publikasi_penelitian ?? [],
            'pengajar_prestasi_dan_penghargaan' => $pengajar->prestasi_dan_penghargaan ?? []
        ];
        return view('pengajar.profile', $data);
    }

    public function pengajarAdminIndex()
    {
        return view('pengajar.pengajar-admin-index');
    }

    public function deletePengajarAll()
    {
        return view('pengajar.pengajar-admin-sampah');
    }
}
