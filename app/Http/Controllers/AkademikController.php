<?php

namespace App\Http\Controllers;

use App\Models\Pages;
use Illuminate\Http\Request;

class AkademikController extends Controller
{
    protected function showDataContent($slug)
    {
        return Pages::where('slug', $slug)->first();
    }

    // user atau pengunjung
    public function alumniAkademik()
    {
        $alumni = $this->showDataContent('Alumni');
        return view('akademik.alumni', [
            'alumni' => $alumni->content ?? null,
            'file'   => $alumni->file ?? null
        ]);
    }

    public function kalenderAkademik()
    {
        $kalender = $this->showDataContent('Kalender-Akademik');
        return view('akademik.kalender', [
            'kalender' => $kalender->content ?? null,
            'image'    => $kalender->image   ?? null,
            'file'     => $kalender->file    ?? null
        ]);
    }

    public function kurikulumAkademik()
    {
        $kurikulum = $this->showDataContent('Kurikulum-Akademik');
        return view('akademik.kurikulum', [
            'kurikulum' => $kurikulum->content ?? null,
            'file'      => $kurikulum->file    ?? null
        ]);
    }

    public function tugasAkhirAkademik()
    {
        $tugasAkhir = $this->showDataContent('Tugas-Akhir-Tesis');
        return view('akademik.tugas-akhir', [
            'tugasAkhir' => $tugasAkhir->content ?? null,
            'file'       => $tugasAkhir->file    ?? null,
            'image'      => $tugasAKhir->image   ?? null
        ]);
    }

    public function yudisiumAkademik()
    {
        $yudisium = $this->showDataContent('Yudisium');
        return view('akademik.yudisium', [
            'yudisium' => $yudisium->content ?? null,
            'file'     => $yudisium->file    ?? null,
            'image'    => $yudisium->image   ?? null
        ]);
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
