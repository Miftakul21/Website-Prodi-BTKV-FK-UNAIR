<?php

namespace App\Livewire;

use App\Models\Berita;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithFileUploads;
use Purifier;

class BeritaCrud extends Component
{
    use WithFileUploads;

    public $beritas;
    public $id_berita, $judul, $tgl_berita, $kategori = 'Berita', $konten_berita, $thumbnail_image;
    public $isOpen = false;

    protected $listeners = [
        'deleteBerita' => 'delete',
        'updateKonten' => 'updateKonten', // menerima payload dari JS
    ];

    public function render()
    {
        $this->beritas = Cache::remember('beritas_all', 100, function () {
            return Berita::with('user:id_user,name')
                ->select('id_berita', 'user_id', 'judul', 'tgl_berita', 'kategori', 'thumbnail_image', 'konten_berita')
                ->latest()
                ->get();
        });

        return view('livewire.berita-crud');
    }

    public function create()
    {
        $this->resetFields();
        $this->thumbnail_image = null;
        $this->isOpen = true;
        $this->dispatch('initEditor');
    }

    public function edit($id)
    {
        $berita = Berita::findOrFail($id);
        $this->id_berita = $id;
        $this->judul = $berita->judul;
        $this->tgl_berita = $berita->tgl_berita;
        $this->kategori = $berita->kategori;
        $this->konten_berita = $berita->konten_berita;

        // reset file input setiap kali modal dibuka
        // $this->reset('thumbnail_image');
        $this->thumbnail_image = null;

        $this->isOpen = true;
        $this->dispatch('initEditor');
        $this->dispatch('loadKonten', $this->konten_berita);
    }

    // terima konten dari JS
    public function updateKonten($value = null)
    {
        $this->konten_berita = $value ?? '';
    }

    public function store()
    {
        try {
            $this->validate([
                'judul' => 'required|string|max:255',
                'tgl_berita' => 'required|date',
                'kategori' => 'required|string|max:50',
                'konten_berita' => 'required|string',
                'thumbnail_image' => 'required|mimes:jpg,jpeg,png|max:5120'
            ]);

            $filename = Str::random(20) . '.' . $this->thumbnail_image->getClientOriginalExtension();
            $path = $this->thumbnail_image->storeAs('thumbnails', $filename, 'public');

            Berita::create([
                'user_id' => 'd5994e2f-5c37-4364-9266-7031f65bc094',
                'judul' => $this->judul,
                'tgl_berita' => $this->tgl_berita,
                'kategori' => $this->kategori,
                'thumbnail_image' => 'storage/' . $path,
                'konten_berita' => Purifier::clean($this->konten_berita, 'custom'),
                'viewers' => 0,
            ]);

            Cache::forget('beritas_all');
            $this->closeModal();
            $this->dispatch('beritaSaved', 'Berhasil ditambahkan!');
        } catch (\Throwable $e) {
            Log::error('Berita store error: ' . $e->getMessage());
            $this->dispatch('beritaError', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function update()
    {
        try {
            $this->validate([
                'judul'           => 'required|string|max:255',
                'tgl_berita'      => 'required|date',
                'kategori'        => 'required|string|max:50',
                'konten_berita'   => 'required|string',
                'thumbnail_image' => 'nullable|mimes:jpg,jpeg,png|max:5120',
            ]);

            // Ambil data lama
            $berita = Berita::findOrFail($this->id_berita);

            $oldPath = $berita->thumbnail_image;
            $newPath = $oldPath;

            // Debug cek apakah file masuk
            if ($this->thumbnail_image) {
                \Log::info('[Update] File baru terdeteksi: ' . $this->thumbnail_image->getClientOriginalName());

                // Hapus file lama kalau ada
                $oldFullPath = storage_path('app/public/' . str_replace('storage/', '', $oldPath));
                if ($oldPath && file_exists($oldFullPath)) {
                    @unlink($oldFullPath);
                    \Log::info("[Update] File lama dihapus: $oldFullPath");
                }

                // Simpan file baru
                $filename = Str::random(20) . '.' . $this->thumbnail_image->getClientOriginalExtension();
                $stored   = $this->thumbnail_image->storeAs('thumbnails', $filename, 'public');
                $newPath  = 'storage/' . $stored;

                \Log::info("[Update] File baru disimpan: $newPath");
            } else {
                \Log::info('[Update] Tidak ada file baru, pakai thumbnail lama.');
            }

            // Update data ke DB
            $berita->update([
                'judul'           => $this->judul,
                'tgl_berita'      => $this->tgl_berita,
                'kategori'        => $this->kategori,
                'thumbnail_image' => $newPath,
                'konten_berita'   => Purifier::clean($this->konten_berita, 'custom'),
            ]);

            Cache::forget('beritas_all');
            $this->closeModal();
            $this->dispatch('beritaSaved', 'Berhasil diperbarui!');
        } catch (\Throwable $e) {
            \Log::error('Berita update error: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
            ]);
            $this->dispatch('beritaError', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function delete($id)
    {
        try {
            $berita = Berita::findOrFail($id);

            if ($berita->thumbnail_image && file_exists(public_path($berita->thumbnail_image))) {
                @unlink(public_path($berita->thumbnail_image));
            }

            $berita->delete();
            Cache::forget('beritas_all');
            $this->dispatch('beritaDeleted');
        } catch (\Throwable $e) {
            Log::error('Berita delete error: ' . $e->getMessage());
            $this->dispatch('beritaError', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function closeModal()
    {
        $this->isOpen = false;
        $this->resetFields();
        $this->dispatch('resetEditor');
    }

    public function resetFields()
    {
        $this->id_berita = '';
        $this->judul = '';
        $this->tgl_berita = '';
        $this->kategori = 'Berita';
        $this->konten_berita = '';
        $this->thumbnail_image = null;
    }
}
