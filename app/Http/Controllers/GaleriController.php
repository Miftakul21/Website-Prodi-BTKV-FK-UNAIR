<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GaleriController extends Controller
{
    public function galeriAdminIndex()
    {
        return view('galeri.galeri-admin-index');
    }
}
