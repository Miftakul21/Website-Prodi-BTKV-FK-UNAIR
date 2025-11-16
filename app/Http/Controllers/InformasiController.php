<?php

namespace App\Http\Controllers;

use App\Models\Artikel;
use Illuminate\Support\Facades\Session;
use Artesaos\SEOTools\Facades\SEOTools;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class InformasiController extends Controller
{
    // Informasi
    public function prestasiInformasi()
    {
        return view('informasi.prestasi');
    }

    public function detailPrestasi($slug)
    {
        $prestasi = Artikel::with('user')->where('slug', $slug)->firstOrFail();

        // jumlah pembaca
        $sessionKey = 'prestasi_saved_' . $prestasi->id_artikel;
        if (!Session::has($sessionKey)) {
            Artikel::where('id_artikel', $prestasi->id_artikel)->increment('viewers');
            Session::put($sessionKey, true);
        }

        // pagination prestasi
        $prestasi_lainnya = artikel::where('id_artikel', '!=', $prestasi->id_artikel)
            ->select('id_artikel as prestasi_id', 'judul as prestasi_title', 'tgl_artikel as prestasi_date')
            ->where('kategori', $prestasi->kategori)
            ->orderByDesc('tgl_artikel')
            ->limit(3)
            ->get();

        $data = [
            'prestasi_id'         => $prestasi->id_artikel,
            'prestasi_title'      => $prestasi->judul,
            'prestasi_date'       => $prestasi->tgl_artikel,
            'prestasi_category'   => $prestasi->kategori,
            'prestasi_thumbnail'  => $prestasi->thumbnail_image,
            'prestasi_content'    => $prestasi->konten_artikel,
            'views_count'         => $prestasi->viewers,
            'prestasi_editor'     => $prestasi->user->name ?? '',
            'prestasi_lainnya'    => $prestasi_lainnya,
        ];

        // SEO setup
        SEOTools::setTitle($prestasi->judul);
        SEOTools::setDescription(Str::limit(strip_tags($prestasi->konten_artikel), 160));
        SEOTools::opengraph()->setUrl(url()->current());
        SEOTools::opengraph()->addImage(asset('storage/' . $prestasi->thumbnail_image));
        SEOTools::setCanonical(url()->current());

        // Whatsapp, Instagram, Facebook, Linkedin
        SEOTools::opengraph()->setType('article');
        SEOTools::opengraph()->addProperty('locale', 'id_ID');
        SEOTools::opengraph()->addProperty('article:published_time', $prestasi->tgl_artikel);
        SEOTools::opengraph()->addProperty('article:author', $prestasi->user->name ?? 'Administrator');
        SEOTools::metatags()->addMeta('robots', 'index, follow');

        // Twitter card
        SEOTools::twitter()->setTitle($prestasi->judul);
        SEOTools::twitter()->setDescription(Str::limit(strip_tags($prestasi->konten_artikel), 160));
        SEOTools::twitter()->setImage(asset('storage/' . $prestasi->thumbnail_image));

        // JSON-LD
        SEOTools::jsonLd()->setType('Article');
        SEOTools::jsonLd()->setTitle($prestasi->judul);
        SEOTools::jsonLd()->setDescription(Str::limit(strip_tags($prestasi->konten_artikel), 160));
        SEOTools::jsonLd()->setUrl(url()->current());
        SEOTools::jsonLd()->addImage(asset('storage/' . $prestasi->thumbnail_image));
        SEOTools::jsonLd()->addValue('author', $prestasi->user->name ?? 'Administrator');
        SEOTools::jsonLd()->addValue('datePublished', $prestasi->tgl_artikel);

        return view('informasi.detail-prestasi', $data);
    }
}
