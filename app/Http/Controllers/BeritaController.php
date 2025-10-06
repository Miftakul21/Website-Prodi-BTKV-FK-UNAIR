<?php

namespace App\Http\Controllers;

use App\Models\Berita;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class BeritaController extends Controller
{
    public function index()
    {
        return view('berita.berita');
    }

    public function detailBerita($slug)
    {
        $berita = Berita::with('user')->where('slug', $slug)->firstOrFail();

        // jumlah pembaca
        $sessionKey = 'berita_saved_' . $berita->id_berita;
        if (!Session::has($sessionKey)) {
            $berita->increment('viewers');
            Session::put($sessionKey, true);
        }

        // pagination berita
        $berita_lainnya = Berita::where('id_berita', '!=', $berita->id_berita)
            ->select('id_berita as berita_id', 'judul as berita_title', 'tgl_berita as berita_date')
            ->where('kategori', $berita->kategori)
            ->orderByDesc('tgl_berita')
            ->limit(3)
            ->get();

        $data = [
            'berita_id' => $berita->id_berita,
            'berita_title' => $berita->judul,
            'berita_date' => $berita->tgl_berita,
            'berita_category' => $berita->kategori,
            'berita_thumbnail'  => $berita->thumbnail_image,
            'berita_content' => $berita->konten_berita,
            'views_count' => $berita->viewers,
            'berita_editor' => $berita->user->name ?? '',
            'berita_lainnya' => $berita_lainnya,
        ];
        return view('berita.detail-berita', $data);
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
                    'error' => $validation->errors()->first()
                ], 422);
            }

            // save file
            $file = $request->file('upload');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/berita'), $filename);
            $url = asset('uploads/berita/' . $filename);

            return response()->json([
                'uploaded' => true,
                'url' => $url
            ]);
        } catch (\Throwable $e) {
            \Log::error('Terjadi kesalahan upload image: ' . $e->getMessage());
            return response()->json([
                'uploaded' => false,
                'message' => [
                    'error' => $e->getMessage()
                ],
            ], 500);
        }
    }
}
