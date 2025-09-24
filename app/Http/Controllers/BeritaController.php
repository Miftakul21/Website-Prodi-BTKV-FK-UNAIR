<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BeritaController extends Controller
{

    public function index()
    {
        return view('berita.berita');
    }

    public function detailBerita(Request $request)
    {
        return view('berita.detail-berita');
    }

    public function beritaAdminIndex()
    {
        return view('berita.berita-admin-index');
    }
}
