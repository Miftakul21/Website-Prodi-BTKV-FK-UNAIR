<?php

namespace App\Livewire;

use App\Models\Galeri;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Cache;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use Purifier;

class GaleriCrud extends Component
{
    use WithFileUploads, WithPagination;

    protected $paginationTheme = 'bootstrap';
    public $id_galeri,
        $judul_galeri,
        $deskripsi,
        $image_utama,
        $image_first,
        $image_second,
        $image_third,
        $image_fourth,
        $slug,
        $kategori;

    public $isOpen = false;

    protected $listeners = [
        'deleteGaleri'    => 'delete',
        'updateDeskripsi' => 'updateDeskripsi', // menerima payload dari JS
    ];

    public function render()
    {
        $page = $this->getPage();
        $galeris = Cache::remember("galeris_page_${page}", 100, function () {
            return Galeri::select(
                'id_galeri',
                'judul_galeri',
                'deskripsi',
                'image_utama',
                'image_first',
                'image_second',
                'image_third',
                'image_fourth',
                'slug',
                'kategori',
            )
                ->latest()
                ->paginate(10);
        });
        return view('livewire.galeri-crud', [
            'galeris' => $galeris
        ]);
    }

    protected function clearGaleriCache()
    {
        $total = Galeri::count();
        $lastPage = ceil($total / 10);
        foreach (range(1, $lastPage) as $i) {
            Cache::forget("galeris_page_${i}");
        }
    }

    public function create()
    {
        $this->resetFields();
        $this->judul_galeri = null;
        $this->deskripsi    = null;
        $this->image_utama  = null;
        $this->image_first  = null;
        $this->image_second = null;
        $this->image_third  = null;
        $this->image_fourth = null;
        $this->kategori     = null;
        $this->isOpen       = true;
        $this->dispatch('initEditor');
    }

    public function edit($id)
    {
        $galeri             = Galeri::findOrFail($id);
        $this->id_galeri    = $id;
        $this->judul_galeri = $galeri->judul_galeri;
        $this->deskripsi    = $galeri->deskripsi;
        $this->kategori     = $galeri->kategori;
        $this->image_utama  = null;
        $this->image_first  = null;
        $this->image_second = null;
        $this->image_third  = null;
        $this->image_fourth = null;
        $this->isOpen = true;
        $this->dispatch('initEditor');
    }

    // terima konten dari JS
    public function updateDeskripsi($value = null)
    {
        $this->deskripsi = $value ?? '';
    }

    public function store()
    {
        DB::beginTransaction();

        try {
            $this->validate([
                'judul_galeri' => 'required|string|max:255',
                'deskripsi'    => 'nullable|string',
                'image_utama'  => 'required|mimes:jpg,jpeg,png|max:5120',
                'image_first'  => 'nullable|mimes:jpg,jpeg,png|max:5120',
                'image_second' => 'nullable|mimes:jpg,jpeg,png|max:5120',
                'image_third'  => 'nullable|mimes:jpg,jpeg,png|max:5120',
                'image_fourth' => 'nullable|mimes:jpg,jpeg,png|max:5120',
            ]);

            $galeri = Galeri::create([
                'judul_galeri' => Purifier::clean($this->judul_galeri, 'custom'),
                'deskripsi'    => Purifier::clean($this->deskripsi, 'custom'),
                'kategori'     => Purifier::clean($this->kategori, 'custom'),
            ]);

            $imageFields = [
                'image_utama',
                'image_first',
                'image_second',
                'image_third',
                'image_fourth'
            ];

            foreach ($imageFields as $field) {
                if ($this->$field) {
                    DB::afterCommit(function () use ($galeri, $field) {
                        $file     = $this->$field;
                        $filename = Str::random(20) . '.' .
                            $file->getClientOriginalExtension();
                        $path     = $file->storeAs('galeris', $filename, 'public');
                        $galeri->update([$field => $path]);
                    });
                }
            }

            DB::commit();
            $this->clearGaleriCache();
            $this->closeModal();
            $this->dispatch('galeriSaved', 'Berhasil ditambahkan!');
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Galeri store error: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString()
            ]);
            $this->dispatch('galeriError', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function update()
    {
        DB::beginTransaction();
        try {
            $this->validate([
                'judul_galeri' => 'required|string|max:255',
                'deskripsi'    => 'nullable|string',
                'kategori'     => 'required|string',
                'image_utama'  => 'nullable|mimes:jpg,jpeg,png|max:5120',
                'image_first'  => 'nullable|mimes:jpg,jpeg,png|max:5120',
                'image_second' => 'nullable|mimes:jpg,jpeg,png|max:5120',
                'image_third'  => 'nullable|mimes:jpg,jpeg,png|max:5120',
                'image_fourth' => 'nullable|mimes:jpg,jpeg,png|max:5120',
            ]);

            $galeri = Galeri::findOrFail($this->id_galeri);
            $galeri->update([
                'judul_galeri' => Purifier::clean($this->judul_galeri, 'custom'),
                'deskripsi'    => Purifier::clean($this->deskripsi, 'custom'),
                'kategori'     => Purifier::clean($this->kategori, 'custom'),
            ]);

            $imageFields = [
                'image_utama',
                'image_first',
                'image_second',
                'image_third',
                'image_fourth',
            ];

            foreach ($imageFields as $field) {
                if ($this->$field) {
                    DB::afterCommit(function () use ($galeri, $field) {
                        $file = $this->$field;

                        if ($galeri->$field && Storage::disk('public')->exists($galeri->$field)) {
                            Storage::disk('public')->delete($galeri->$field);
                        }

                        // new upload
                        $filename = Str::random(20) . '.'
                            . $file->getClientOriginalExtension();
                        $path     = $file->storeAs('galeris', $filename, 'public');

                        $galeri->update([$field => $path]);
                    });
                }
            }

            DB::commit();
            $this->clearGaleriCache();
            $this->closeModal();
            $this->dispatch('galeriSaved', 'Berhasil diperbarui!');
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Galeri update error: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString()
            ]);
            $this->dispatch('galeriError', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function delete($id)
    {
        try {
            $galeri = Galeri::findOrFail($id);
            $galeri->delete();
            $this->clearGaleriCache();
            $this->dispatch('galeriDeleted');
        } catch (\Throwable $e) {
            \Log::error('Galeri delete error: ' . $e->getMessage());
            $this->dispatch('galeriError', 'Terjadi kesalahan: ' . $e->getMessage());
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
        $this->id_galeri    = '';
        $this->judul_galeri = '';
        $this->deskripsi    = '';
        $this->kategori     = '';
        $this->image_utama  = null;
        $this->image_first  = null;
        $this->image_second = null;
        $this->image_third  = null;
        $this->image_fourth = null;
    }
}
