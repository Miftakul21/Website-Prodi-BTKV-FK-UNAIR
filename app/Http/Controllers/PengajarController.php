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
}
