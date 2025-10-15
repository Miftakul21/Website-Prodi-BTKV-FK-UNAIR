<?php

namespace App\Http\Controllers;

use App\Models\Berita;
use App\Models\Pengajar;
use App\Models\Galeri;
use Illuminate\Support\Facades\Cache;
use Artesaos\SEOTools\Facades\SEOTools;

class BerandaController extends Controller
{
    public function index()
    {
        $berita = Cache::remember('beritas', '100', function () {
            return Berita::with('user:id_user')
                ->select(
                    'id_berita as berita_id',
                    'judul as berita_title',
                    'tgl_berita as berita_date',
                    'kategori as berita_category',
                    'thumbnail_image as berita_thumbnail',
                    'konten_berita as berita_content',
                    'viewers as views_count',
                    'slug as berita_slug'
                )
                ->latest()
                ->get(4);
        });

        $pengajar = Cache::remember('pengajars', '100', function () {
            return Pengajar::select(
                'id_pengajar as pengajar_id',
                'name as pengajar_name',
                'posisi as pengajar_posistion',
                'pendidikan as pengajar_pendidikan',
                'foto as pengajar_image',
                'slug as pengajar_slug'
            )
                ->latest()
                ->paginate(4);
        });

        $galeri = Cache::remember('galeris', '100', function () {
            return Galeri::select(
                'id_galeri as galeri_id',
                'judul_galeri as galeri_title',
                'image_utama as galeri_thumbnail',
                'kategori as galeri_category',
                'slug as galeri_slug',
            )
                ->latest()
                ->paginate(10);
        });

        SEOTools::setTitle('Spesalis Bedah Toraks, Kardiak, Vaskular - FK Universitas Airlangga');
        SEOTools::setDescription(
            'Program Studi Dokter Spesialis Bedah Toraks, Kardiak, dan Vaskular 
            (BTKV) Fakultas Kedokteran Universitas Airlangga Surabaya merupakan 
            program pendidikan dokter spesialis yang berdiri pada tahun 2007. 
            Program Studi BTKV FK UNAIR telah terakreditasi "A" oleh LAM-PTKes berdasarkan Surat Keputusan 
            Nomor: 001/LAM-PTKes/Akr/VI/2021, berlaku sejak tanggal 30 Juni 2021 sampai dengan 30 Juni 2026.'
        );
        SEOTools::setCanonical(url('/'));

        // Facebook, Whatsapp, Linkedin, Instagram
        SEOTools::opengraph()->setUrl(url('/'));
        SEOTools::opengraph()->addProperty('type', 'website');
        SEOTools::opengraph()->addImage(asset('img/lg-prodi.png'));

        // Twitter card
        SEOTools::twitter()->setTitle('BTKV FK UNAIR - Program Studi Spesialis Bedah Toraks, Kardiak, Vaskular');
        SEOTools::twitter()->setDescription(
            'Program Studi Dokter Spesialis Bedah Toraks, Kardiak, dan Vaskular 
            (BTKV) Fakultas Kedokteran Universitas Airlangga Surabaya merupakan 
            program pendidikan dokter spesialis yang berdiri pada tahun 2007. 
            Program Studi BTKV FK UNAIR telah terakreditasi "A" oleh LAM-PTKes berdasarkan Surat Keputusan 
            Nomor: 001/LAM-PTKes/Akr/VI/2021, berlaku sejak tanggal 30 Juni 2021 sampai dengan 30 Juni 2026.'
        );
        SEOTools::twitter()->setImage(asset('images/lg-prodi.png'));

        // Meta Keyword
        SEOTools::metatags()->setKeywords([
            'Bedah Toraks Kardiak Vaskular',
            'Universitas Airlangga',
            'Spesialis Bedah Toraks',
            'Spesialis Bedah Jantung',
            'Spesialis Bedah Vaskular',
            'Program Spesialis BTKV Surabaya'
        ]);

        return view('beranda', [
            'berita'   => $berita,
            'pengajar' => $pengajar,
            'galeri'   => $galeri
        ]);
    }
}
