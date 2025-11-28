<?php

namespace App\Livewire;

use App\Models\Artikel;

use Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use Purifier;

class ArtikelCrud extends Component
{
    use WithFileUploads, WithPagination;

    protected $paginationTheme = 'bootstrap';
    public $id_artikel,
        $judul,
        $tgl_artikel,
        $kategori = 'Artikel',
        $konten_artikel,
        $thumbnail_image,
        $resource_image;

    public $isOpen         = false;
    public $filterKategori = '';

    protected $listeners = [
        'deleteArtikel' => 'delete',
        'updateKonten'  => 'updateKonten', // menerima payload dari JS
    ];

    public function render()
    {
        $page     = $this->getPage();
        $filter   = $this->filterKategori;
        $artikels = Cache::remember("artikels_page_{$page}_filter_{$filter}", 100, function () use ($filter) {
            return Artikel::with('user:id_user,name')
                ->when($filter !== '', function ($query) use ($filter) {
                    $query->where('kategori', $filter);
                })
                ->select(
                    'id_artikel',
                    'user_id',
                    'judul',
                    'konten_artikel',
                    'tgl_artikel',
                    'kategori',
                    'slug',
                    'thumbnail_image',
                )
                ->latest()
                ->paginate(10);
        });

        return view('livewire.artikel-crud', [
            'artikels' => $artikels
        ]);
    }

    protected function clearArtikelCache()
    {
        $filters  = ['', 'Berita', 'Event', 'Hasil Karya', 'Prestasi'];
        $total    = Artikel::count();
        $lastPage = ceil($total / 10);

        foreach ($filters as $filter) {
            foreach (range(1, $lastPage) as $i) {
                Cache::forget("artikels_page_{$i}_filter_{$filter}");
            }
        }
    }

    public function create()
    {
        $this->resetFields();
        $this->tgl_artikel     = now()->format('Y-m-d');
        $this->thumbnail_image = null;
        $this->resource_image  = null;
        $this->isOpen = true;
        $this->dispatch('initEditor');
    }

    public function edit($id)
    {
        $artikel = Artikel::findOrFail($id);
        $this->id_artikel      = $id;
        $this->judul           = $artikel->judul;
        $this->tgl_artikel     = $artikel->tgl_artikel;
        $this->kategori        = $artikel->kategori;
        $this->konten_artikel  = $artikel->konten_artikel;
        $this->thumbnail_image = null;
        $this->resource_image  = $artikel->resource_iamge;
        $this->isOpen          = true;
        $this->dispatch('initEditor');
        $this->dispatch('loadKonten', $this->konten_artikel);
    }

    public function updateKonten($value = null)
    {
        $this->konten_artikel = $value ?? '';
    }

    public function store()
    {
        DB::beginTransaction();

        try {
            $this->validate([
                'judul'           => 'required|string|max:255',
                'tgl_artikel'     => 'required|date',
                'kategori'        => 'required|string|max:50',
                'konten_artikel'  => 'required|string',
                'thumbnail_image' => 'required|mimes:jpg,jpeg,png|max:5120',
                'resource_image'  => 'nullable|string',
            ]);

            $artikel = Artikel::create([
                'user_id'         => Auth::user()->id_user,
                'judul'           => Purifier::clean($this->judul, 'custom'),
                'tgl_artikel'     => Purifier::clean($this->tgl_artikel, 'custom'),
                'kategori'        => Purifier::clean($this->kategori, 'custom'),
                'thumbnail_image' => null,
                'resource_image'  => Purifier::clean($this->resource_image, 'custom'),
                'konten_artikel'  => Purifier::clean($this->konten_artikel, 'custom'),
                'viewers'         => 0,
            ]);

            if ($this->thumbnail_image) {
                $thumbnail = $this->thumbnail_image;

                DB::afterCommit(function () use ($artikel, $thumbnail) {
                    $filename = Str::random(20) . '.' . $thumbnail->getClientOriginalExtension();
                    $path     = $thumbnail->storeAs('thumbnails', $filename, 'public');
                    $artikel->update(['thumbnail_image' => $path]);
                });
            }

            DB::commit();
            $this->clearArtikelCache();
            $this->closeModal();
            $this->dispatch('artikelSaved', 'Berhasil ditambahkan!');
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Artikel store error: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString()
            ]);
            $this->dispatch('artikelError', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function update()
    {
        DB::beginTransaction();
        try {
            $this->validate([
                'judul'           => 'required|string|max:255',
                'tgl_artikel'     => 'required|date',
                'kategori'        => 'required|string|max:50',
                'konten_artikel'  => 'required|string',
                'thumbnail_image' => 'nullable|mimes:jpg,jpeg,png|max:5120',
                'resource_image'  => 'nullable|string'
            ]);

            $artikel = Artikel::findOrFail($this->id_artikel);
            $artikel->update([
                'user_id'        => Auth::user()->id_user,
                'judul'          => Purifier::clean($this->judul, 'custom'),
                'tgl_artikel'    => Purifier::clean($this->tgl_artikel, 'custom'),
                'kategori'       => Purifier::clean($this->kategori, 'custom'),
                'konten_artikel' => Purifier::clean($this->konten_artikel, 'custom'),
                'resource_image' => Purifier::clean($this->resource_image, 'custom'),
            ]);

            if ($this->thumbnail_image) {
                $oldPath = $artikel->thumbnail_image;
                DB::afterCommit(function () use ($artikel, $oldPath) {
                    // delete file lama jika ada
                    if ($oldPath && Storage::disk('public')->exists(str_replace('storage/', '', $oldPath))) {
                        Storage::disk('public')->delete(str_replace('storage/', '', $oldPath));
                    }
                    $filename = Str::random(20) . '.' . $this->thumbnail_image->getClientOriginalExtension();
                    $path     = $this->thumbnail_image->storeAs('thumbnails', $filename, 'public');
                    $artikel->update(['thumbnail_image' => $path]);
                });
            }

            DB::commit();
            $this->clearArtikelCache();
            $this->closeModal();
            $this->dispatch('artikelSaved', 'Berhasil diperbarui!');
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Artikel update error: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
            ]);
            $this->dispatch('artikelError', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function delete($id)
    {
        try {
            $artikel = Artikel::findOrFail($id);
            $artikel->delete();
            $this->clearArtikelCache();
            $this->dispatch('artikelDeleted');
        } catch (\Throwable $e) {
            Log::error('Artikel delete error: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString()
            ]);
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
        $this->id_artikel      = '';
        $this->judul           = '';
        $this->tgl_artikel     = '';
        $this->kategori        = 'Artikel';
        $this->konten_artikel  = '';
        $this->thumbnail_image = null;
    }
}
