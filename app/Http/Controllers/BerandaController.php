<?php

namespace App\Http\Controllers;

use App\Models\Artikel;
use App\Models\Pengajar;
use App\Models\Galeri;
use Illuminate\Support\Facades\Cache;
use Artesaos\SEOTools\Facades\SEOTools;

class BerandaController extends Controller
{
    public function index()
    {
        $artikel = Cache::remember('artikels', '100', function () {
            return Artikel::with('user:id_user')
                ->select(
                    'id_artikel      as artikel_id',
                    'judul           as artikel_title',
                    'tgl_artikel     as artikel_date',
                    'kategori        as artikel_category',
                    'thumbnail_image as artikel_thumbnail',
                    'konten_artikel  as artikel_content',
                    'viewers         as views_count',
                    'slug            as artikel_slug'
                )
                // ->where('kategori', 'Berita')
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
                ->paginate(4)
                ->through(function ($item) {
                    $decoded = json_decode($item->pengajar_pendidikan, true);
                    $item->pengajar_pendidikan = $decoded[0]['pendidikan'] ?? '-';
                    return $item;
                });
        });

        $galeri = Cache::remember('galeris', '100', function () {
            return Galeri::select(
                'id_galeri as galeri_id',
                'judul_galeri as galeri_title',
                'image_utama as galeri_thumbnail',
                'image_first',
                'image_second',
                'image_third',
                'image_fourth',
                'deskripsi',
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
            'artikel'  => $artikel,
            'pengajar' => $pengajar,
            'galeri'   => $galeri
        ]);
    }
}
