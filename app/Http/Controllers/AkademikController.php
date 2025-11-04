<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AkademikController extends Controller
{
    // user atau pengunjung
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
        return view('akademik.kurikulum');
    }

    // admin
    public function alumniAdminIndex()
    {
        return view('akademik.alumni-admin-index');
    }

    public function kalenderAdminIndex()
    {
        return view('akademik.kalender-admin-index');
    }

    public function kurikulumAdminIndex()
    {
        return view('akademik.kurikulum-admin-index');
    }

    public function tugasAkhirAdminIndex()
    {
        return view('akademik.tugas-akhir-admin-index');
    }

    public function yudisiumAdminIndex()
    {
        return view('akademik.yudisium-admin-index');
    }
}
