<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PengajarController extends Controller
{
    public function index()
    {
        return view('pengajar.pengajar');
    }

    // detail pengajar NANTI YA DIISI!!!
    public function detailPengajar(Request $request)
    {
        return view('pengajar.profile');
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
