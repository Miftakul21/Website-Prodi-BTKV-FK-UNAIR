<?php

namespace App\Http\Controllers;

use App\Models\Artikel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Artesaos\SEOTools\Facades\SEOTools;
use Illuminate\Support\Str;

class ArtikelController extends Controller
{
    public function index()
    {
        return view('artikel.artikel');
    }

    public function detailArtikel($slug)
    {
        $artikel = Artikel::with('user')->where('slug', $slug)->firstOrFail();

        // jumlah pembaca
        $sessionKey = 'artikel_saved_' . $artikel->id_artikel;
        if (!Session::has($sessionKey)) {
            artikel::where('id_artikel', $artikel->id_artikel)->increment('viewers');
            Session::put($sessionKey, true);
        }

        // pagination artikel
        $artikel_lainnya = Artkel::where('id_artikel', '!=', $artikel->id_artikel)
            ->select('id_artikel as artikel_id', 'judul as artikel_title', 'tgl_artikel as artikel_date')
            ->where('kategori', $artikel->kategori)
            ->orderByDesc('tgl_artikel')
            ->limit(3)
            ->get();

        $data = [
            'artikel_id'         => $artikel->id_artikel,
            'artikel_title'      => $artikel->judul,
            'artikel_date'       => $artikel->tgl_artikel,
            'artikel_category'   => $artikel->kategori,
            'artikel_thumbnail'  => $artikel->thumbnail_image,
            'artikel_content'    => $artikel->konten_artikel,
            'views_count'       => $artikel->viewers,
            'artikel_editor'     => $artikel->user->name ?? '',
            'artikel_lainnya'    => $artikel_lainnya,
        ];

        // SEO setup
        SEOTools::setTitle($artikel->judul);
        SEOTools::setDescription(Str::limit(strip_tags($artikel->konten_artikel), 160));
        SEOTools::opengraph()->setUrl(url()->current());
        SEOTools::opengraph()->addImage(asset('storage/' . $artikel->thumbnail_image));
        SEOTools::setCanonical(url()->current());

        // Whatsapp, Instagram, Facebook, Linkedin
        SEOTools::opengraph()->setType('article');
        SEOTools::opengraph()->addProperty('locale', 'id_ID');
        SEOTools::opengraph()->addProperty('article:published_time', $artikel->tgl_artikel);
        SEOTools::opengraph()->addProperty('article:author', $artikel->user->name ?? 'Administrator');
        SEOTools::metatags()->addMeta('robots', 'index, follow');

        // Twitter card
        SEOTools::twitter()->setTitle($artikel->judul);
        SEOTools::twitter()->setDescription(Str::limit(strip_tags($artikel->konten_artikel), 160));
        SEOTools::twitter()->setImage(asset('storage/' . $artikel->thumbnail_image));

        // JSON-LD
        SEOTools::jsonLd()->setType('Article');
        SEOTools::jsonLd()->setTitle($artikel->judul);
        SEOTools::jsonLd()->setDescription(Str::limit(strip_tags($artikel->konten_artikel), 160));
        SEOTools::jsonLd()->setUrl(url()->current());
        SEOTools::jsonLd()->addImage(asset('storage/' . $artikel->thumbnail_image));
        SEOTools::jsonLd()->addValue('author', $artikel->user->name ?? 'Administrator');
        SEOTools::jsonLd()->addValue('datePublished', $artikel->tgl_artikel);

        return view('artikel.detail-artikel', $data);
    }

    public function artikelAdminIndex()
    {
        return view('artikel.artikel-admin-index');
    }

    public function deleteArtikelAll()
    {
        return view('artikel.artikel-admin-sampah');
    }

    public function uploadImageCKEditor(Request $request)
    {
        try {
            $validation = Validator::make($request->all(), [
                'upload' => 'mimes:jpg,jpeg,png|max:5120'
            ]);

            if ($validation->fails()) {
                return response()->json([
                    'uploaded' => false,
                    'error'    => $validation->errors()->first()
                ], 422);
            }

            $file     = $request->file('upload');
            $filename =  time() . '_' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/artikel'), $filename);
            $url      = asset('uploads/artikel/' . $filename);

            return response()->json([
                'uploaded' => true,
                'url'      => $url
            ]);
        } catch (\Throwable $e) {
            \Log::error('Terjadi kesalahan upload image: ' . $e->getMessage());
            return response()->json([
                'uploaded' => false,
                'message'  => [
                    'error' => $e->getMessage()
                ],
            ], 500);
        }
    }
}
