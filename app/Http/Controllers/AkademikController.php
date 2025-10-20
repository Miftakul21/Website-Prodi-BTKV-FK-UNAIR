<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AkademikController extends Controller
{
    public function alumni()
    {
        return null;
    }

    public function kalenderAkademik()
    {
        return view('akademik.kalender');
    }

    public function kurikulumAkademik()
    {
        return null;
    }
}
