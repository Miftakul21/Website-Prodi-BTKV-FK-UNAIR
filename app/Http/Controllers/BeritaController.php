<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Artesaos\SEOTools\Facades\SEOTools;
use Illuminate\Support\Str;

class BeritaController extends Controller
{
    public function index()
    {
        return view('berita.berita');
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

    public function detailArtikel($slug, $viewName)
    {
        $artikel = Artikel::with('user')
            ->where('slug', $slug)
            // ->where('kategori', $kategori)
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
            'artikel_lainnya'   => $artikel_lainnya
        ];

        $this->setSeoArticel($artikel);
        return view($viewName, $data);
    }

    public function detailBerita($slug)
    {
        return $this->detailArtikel($slug, 'berita.detail-berita');
    }

    public function beritaAdminIndex()
    {
        return view('berita.berita-admin-index');
    }

    public function deleteBeritaAll()
    {
        return view('berita.berita-admin-sampah');
    }

    // upload image ckeditor
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

            // save file
            $file     = $request->file('upload');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/berita'), $filename);
            $url      = asset('uploads/berita/' . $filename);

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
