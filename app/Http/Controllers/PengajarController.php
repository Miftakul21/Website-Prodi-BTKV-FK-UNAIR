<?php

namespace App\Http\Controllers;

use App\Models\Pengajar;
use Illuminate\Http\Request;
use Artesaos\SEOTools\Facades\SEOTools;
use Illuminate\Support\Str;

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

        // SEO setup
        SEOTools::setTitle($pengajar->name);
        SEOTools::setDescription(Str::limit(strip_tags($pengajar->biografi)));
        SEOTools::setCanonical(url()->current());
        SEOTools::opengraph()->setUrl(url()->current());
        SEOTools::opengraph()->setType('profile');
        SEOTools::opengraph()->addImage(asset('storage/' . $pengajar->foto));

        // Twitter card
        SEOTools::twitter()->setTitle($pengajar->name);
        SEOTools::twitter()->setDescription(Str::limit(strip_tags($pengajar->biografi), 160));
        SEOTools::twitter()->setImage(asset('storage/' . $pengajar->foto));
        SEOTools::twitter()->setType('summary_large_image');


        // meta
        SEOTools::metatags()->setKeywords([
            $pengajar->name,
            'Bedah Toraks',
            'Bedah Kardiak Dewasa',
            'Bedah Kardiak Kongenital',
            'Bedah Vaskular',
            'Bedah Jantung',
            'Ilmu Bedah',
            'Universitas Airlannga',
            'Fakultas Kedokteran',
            'Program Spesialis Bedah Toraks, Kardiak, Vaskular',
            'RSUD dr. SOETOMO',
            'RSUA',
            'Rumah Sakit Airlangga',
        ]);

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
