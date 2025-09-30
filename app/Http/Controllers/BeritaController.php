<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BeritaController extends Controller
{

    public function index()
    {
        return view('berita.berita');
    }

    public function detailBerita(Request $request)
    {
        return view('berita.detail-berita');
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
