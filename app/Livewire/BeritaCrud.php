<?php

namespace App\Livewire;

use App\Models\Berita;

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

class BeritaCrud extends Component
{
    /*
        Livewire ini tidak hanya mengangani berita saja kategorinya tetapi juga artikel, 
        event, dan hasil harya
    */

    use WithFileUploads, WithPagination;

    protected $paginationTheme = 'bootstrap';
    public $id_berita,
        $judul,
        $tgl_berita,
        $kategori = 'Berita',
        $konten_berita,
        $thumbnail_image;

    public $isOpen = false;

    protected $listeners = [
        'deleteBerita' => 'delete',
        'updateKonten' => 'updateKonten', // menerima payload dari JS
    ];

    public function render()
    {
        $page = $this->getPage();
        $beritas = Cache::remember("beritas_page_{$page}", 100, function () {
            return Berita::with('user:id_user,name')
                ->select(
                    'id_berita',
                    'user_id',
                    'judul',
                    'konten_berita',
                    'tgl_berita',
                    'kategori',
                    'slug',
                    'thumbnail_image',
                )
                ->latest()
                ->paginate(10);
        });

        return view('livewire.berita-crud', [
            'beritas' => $beritas
        ]);
    }

    protected function clearBeritaCache()
    {
        $total = Berita::count();
        $lastPage = ceil($total / 10);
        foreach (range(1, $lastPage) as $i) {
            Cache::forget("beritas_page_{$i}");
        }
    }

    public function create()
    {
        $this->resetFields();
        $this->tgl_berita = now()->format('Y-m-d');
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
        DB::beginTransaction();

        try {
            $this->validate([
                'judul'           => 'required|string|max:255',
                'tgl_berita'      => 'required|date',
                'kategori'        => 'required|string|max:50',
                'konten_berita'   => 'required|string',
                'thumbnail_image' => 'required|mimes:jpg,jpeg,png|max:5120'
            ]);

            $berita = Berita::create([
                'user_id'         => Auth::user()->id_user,
                'judul'           => Purifier::clean($this->judul, 'custom'),
                'tgl_berita'      => Purifier::clean($this->tgl_berita, 'custom'),
                'kategori'        => Purifier::clean($this->kategori, 'custom'),
                'thumbnail_image' => null,
                'konten_berita'   => Purifier::clean($this->konten_berita, 'custom'),
                'viewers'         => 0,
            ]);

            if ($this->thumbnail_image) {
                DB::afterCommit(function () use ($berita) {
                    $filename = Str::random(20) . '.'
                        . $this->thumbnail_image->getClientOriginalExtension();
                    $path     = $this->thumbnail_image->storeAs('thumbnails', $filename, 'public');

                    $berita->update(['thumbnail_image' => $path]);
                });
            }

            DB::commit();
            $this->clearBeritaCache();
            $this->closeModal();
            $this->dispatch('beritaSaved', 'Berhasil ditambahkan!');
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Berita store error: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString()
            ]);
            $this->dispatch('beritaError', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function update()
    {
        DB::beginTransaction();
        try {
            // Nanti dikasih slug ya
            $this->validate([
                'judul'           => 'required|string|max:255',
                'tgl_berita'      => 'required|date',
                'kategori'        => 'required|string|max:50',
                'konten_berita'   => 'required|string',
                'thumbnail_image' => 'nullable|mimes:jpg,jpeg,png|max:5120',
            ]);

            $berita = Berita::findOrFail($this->id_berita);
            $berita->update([
                'user_id'       => Auth::user()->id_user,
                'judul'         => Purifier::clean($this->judul, 'custom'),
                'tgl_berita'    => Purifier::clean($this->tgl_berita, 'custom'),
                'kategori'      => Purifier::clean($this->kategori, 'custom'),
                'konten_berita' => Purifier::clean($this->konten_berita, 'custom'),
            ]);

            if ($this->thumbnail_image) {
                $oldPath = $berita->thumbnail_image;
                DB::afterCommit(function () use ($berita, $oldPath) {
                    // delete file lama jika ada
                    if ($oldPath && Storage::disk('public')->exists(str_replace('storage/', '', $oldPath))) {
                        Storage::disk('public')->delete(str_replace('storage/', '', $oldPath));
                    }
                    $filename = Str::random(20) . '.' . $this->thumbnail_image->getClientOriginalExtension();
                    $path     = $this->thumbnail_image->storeAs('thumbnails', $filename, 'public');
                    $berita->update(['thumbnail_image' => $path]);
                });
            }

            DB::commit();
            $this->clearBeritaCache();
            $this->closeModal();
            $this->dispatch('beritaSaved', 'Berhasil diperbarui!');
        } catch (\Throwable $e) {
            DB::rollBack();
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
            $berita->delete();
            $this->clearBeritaCache();
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
