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

    public function hasilKaryaInformasi()
    {
        return view('informasi.hasil-karya');
    }

    private function setSeoArticel($artikel)
    {
        SEOTools::setTitle($artikel->judul);
        SEOTOols::setDescription(Str::limit(strip_tags($artikel->konten_artikel), 100));
        SEOTools::opengraph()->setUrl(url()->current());
        SEOTOols::opengraph()->addImage(asset('storage/' . $artikel->thumbnail_image));
        SEOTools::setCanonical(url()->current());

        SEOTools::opengraph()->setType('article');
        SEOTools::opengraph()->addProperty('locale', 'id_ID');
        SEOTools::opengraph()->addProperty('article:published_time', $artikel->tgl_artikel);
        SEOTools::opengraph()->addProperty('article:author', $artikel->user->name ?? 'Administrator');
        SEOTools::metatags()->addMeta('robots', 'index, follow');

        SEOTools::twitter()->setTitle($artikel->judul);
        SEOTOols::twitter()->setDescription(Str::limit(strip_tags($artikel->konten_artikel), 100));
        SEOTools::twitter()->setImage(asset('storage/' . $artikel->thumbnail_image));

        SEOTools::jsonLd()->setTYpe('Article');
        SEOTools::jsonLd()->setTitle($artikel->judul);

        SEOTools::jsonLd()->setDescription(Str::limit(strip_tags($artikel->konten_artikel), 160));
        SEOTools::jsonLd()->setUrl(url()->current());
        SEOTools::jsonLd()->addImage(asset('storage/' . $artikel->thumbnail_image));
        SEOTools::jsonLd()->addValue('author', $artikel->user->name ?? 'Administrator');
        SEOTools::jsonLd()->addValue('datePublished', $artikel->tgl_artikel);
    }

    public function detailArtikel($slug, $kategori, $viewName)
    {
        $artikel = Artikel::with('user')
            ->where('slug', $slug)
            ->where('kategori', $kategori)
            ->firstOrFail();

        // hitung viewer
        $sessionKey = $kategori . '_saved_' . $artikel->id_artikel;
        if (!Session::has($sessionKey)) {
            Artikel::where('id_artikel', $artikel->id_artikel)
                ->increment('viewers');
            Session::put($ssesionKey, true);
        }

        // artikel lainnya
        $artikel_lainnya = Artikel::where('id_artikel', '!=', $artikel->id_artikel)
            ->where('kategori', $kategori)
            ->select(
                'id_artikel  as artikel_id',
                'judul       as artikel_title',
                'tgl_artikel as artikel_date'
            )
            ->orderByDesc('tgl_artikel')
            ->limit(3)
            ->get();

        // data array 
        $data = [
            'artikel_id'        => $artikel->id_artikel,
            'artikel_title'     => $artikel->judul,
            'artikel_date'      => $artikel->tgl_artikel,
            'artikel_category'  => $artikel->kategori,
            'artikel_thumbnail' => $artikel->thumbnail_image,
            'artikel_content'   => $artikel->konten_artikel,
            'artikel_editor'    => $artikel->user->name ?? '',
            'artikel_lainnya'   => $artikel->lainnya
        ];

        $this->setSeoArticel($artikel);
        return view($viewName, $data);
    }

    public function detailPrestasi($slug)
    {
        return $this->detailArtikel($slug, 'Prestasi', 'informasi.detail-prestasi');
    }

    public function detailHasilKarya($slug)
    {
        return $this->detailArtikel($slug, 'Hasil Karya', 'informasi.detail-hasil-karya');
    }
}
