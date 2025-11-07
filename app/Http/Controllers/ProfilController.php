<?php

namespace App\Http\Controllers;

use App\Models\Pages;
use Illuminate\Http\Request;

class ProfilController extends Controller
{

    protected function showDataContent($slug)
    {
        return Pages::where('slug', $slug)->first();
    }

    public function visiDanMisi()
    {
        $pages = $this->showDataContent('visi-dan-misi');
        return view('profil.visi_dan_misi', [
            'visi_dan_misi' => $pages->content ?? null,
        ]);
    }

    public function sejarah()
    {
        return view('profil.sejarah');
    }

    public function fasilitas()
    {
        $pages = $this->showDataContent('Fasilitas');
        return view('profil.fasilitas', [
            'fasilitas' => $pages->content ?? null
        ]);
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

    public function fasilitasAdminIndex()
    {
        return view('profil.fasilitas_admin_index');
    }
}
