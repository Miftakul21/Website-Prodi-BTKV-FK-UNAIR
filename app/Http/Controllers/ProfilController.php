<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProfilController extends Controller
{
    public function visiDanMisi()
    {
        return view('profil.visi_dan_misi');
    }

    public function sejarah()
    {
        return view('profil.sejarah');
    }

    public function fasilitas()
    {
        return view('profil.fasilitas');
    }

    public function akreditasi()
    {
        return view('profil.akreditasi');
    }

    // admin
    public function visiDanMisiAdminIndex()
    {
        return view('profil.visi_dan_misi_admin_index');
    }
}
