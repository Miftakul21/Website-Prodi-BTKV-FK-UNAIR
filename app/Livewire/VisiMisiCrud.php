<?php

namespace App\Livewire;

use App\Models\Pages;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Livewire\WithFileUploads;
use Livewire\Component;
use Purifier;

class VisiMisiCrud extends Component
{
    use WithFileUploads;

    public $id_pages,
        $title,
        $content,
        $image,
        $file;

    public $isOpen = false;

    protected $listeners = [
        'updateKonten'   => 'updateKonten', // menerima payload dari JS
        'deleteVisiMisi' => 'deleteVisiMisi'
    ];

    public function render()
    {
        $visiMisi = Cache::remember('visi_misi_page', 100, function () {
            return Pages::select(
                'id_pages as id_visi_misi',
                'title',
                'content',
                'image',
                'file'
            )
                ->where('slug', 'Visi-Dan-Misi')
                ->get();
        });
        return view('livewire.visi-misi-crud', [
            'visiMisi' => $visiMisi
        ]);
    }

    protected function clearVisiMisiCache()
    {
        Cache::forget('visi_misi_page');
    }

    public function create()
    {
        $this->resetFields();
        $this->title  = 'Visi Dan Misi';
        $this->image  = null;
        $this->file   = null;
        $this->isOpen = true;
        $this->dispatch('initEditor');
    }

    public function edit($id)
    {
        $visiMisi = Pages::findOrFail($id);
        $this->id_pages = $id;
        $this->title    = 'Visi Dan Misi';
        $this->content  = $visiMisi->content;
        $this->image    = null;
        $this->file     = null;
        $this->isOpen   = true;
        $this->dispatch('initEditor');
        $this->dispatch('loadKonten', $this->content);
    }

    // terima konte dari JS
    public function updateKonten($value = null)
    {
        $this->content = $value ?? '';
    }

    public function store()
    {
        DB::beginTransaction();
        try {
            $this->validate([
                'title'    => 'nullable|string',
                'content'  => 'nullable|string',
                'file'     => 'nullable|mimes:pdf|max:5120',
                'image'    => 'nullable|mimes:jpg,jpeg,png|max:5120'
            ]);

            $visiMisi = Pages::create([
                'title'    => $this->title,
                'content'  => Purifier::clean($this->content, 'custom'),
                'file'     => null,
                'image'    => null
            ]);

            if ($this->file) {
                $fileBaru = $this->file;
                DB::afterCommit(function () use ($visiMisi, $fileBaru) {
                    $filename = Str::random(20) . '.' . $fileBaru->getClientOriginalExtension();
                    $path     = $fileBaru->storeAs('profil', $filename, 'public');
                    $visiMisi->update(['file' => $path]);
                });
            }

            if ($this->image) {
                $imageBaru = $this->image;
                DB::afterCommit(function () use ($visiMisi, $imageBaru) {
                    $filename = Str::random(20) . '.'
                        . $imageBaru->getClientOriginalExtension();
                    $path     = $imageBaru->storeAs('profil', $filename, 'public');
                    $visiMisi->update(['image' => $path]);
                });
            }

            DB::commit();
            $this->clearVisiMisiCache();
            $this->closeModal();
            $this->dispatch('visiMisiSaved', 'Berhasil ditambahkan!');
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Visi Dan Misi error: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString()
            ]);
            $this->dispatch('visiMisiError', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function update()
    {
        DB::beginTransaction();
        try {
            $this->validate([
                'title'    => 'nullable|string',
                'content'  => 'nullable|string',
                'file'     => 'nullable|mimes:pdf|max:5120',
                'image'    => 'nullable|mimes:jpg,jpeg,png|max:5120'
            ]);

            $visiMisi = Pages::findOrFail($this->id_pages);
            $visiMisi->update([
                'title'    => $this->title,
                'content'  => Purifier::clean($this->content, 'custom'),
            ]);

            if ($this->file) {
                $oldPath  = $visiMisi->file;
                $fileBaru = $this->file;

                DB::afterCommit(function () use ($visiMisi, $oldPath, $fileBaru) {
                    // delete file lama jika ada
                    if ($oldPath && Storage::disk('public')->exists(str_replace('storage/', '', $oldPath))) {
                        Storage::disk('public')->delete(str_replace('storage/', '', $oldPath));
                    }
                    $filename = Str::random(20) . '.' . $fileBaru->getClientOriginalExtension();
                    $path     = $fileBaru->storeAs('profil', $filename, 'public');
                    $visiMisi->update(['file' => $path]);
                });
            }

            if ($this->image) {
                $oldPath   = $visiMisi->image;
                $imageBaru = $this->image;
                DB::afterCommit(function () use ($visiMisi, $oldPath, $imageBaru) {
                    // delete image lama jika ada
                    if ($oldPath && Storage::disk('public')->exists(str_replace('storage/', '', $oldPath))) {
                        Storage::disk('public')->delete(str_replace('storage/', '', $oldPath));
                    }
                    $filename = Str::random(20) . '.' . $imageBaru->getClientOriginalExtension();
                    $path     = $imageBaru->storeAs('profil', $filename, 'public');
                    $visiMisi->update(['image' => $path]);
                });
            }

            DB::commit();
            $this->clearVisiMisiCache();
            $this->closeModal();
            $this->dispatch('visiMisiSaved', 'Berhasil diperbarui!');
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Visi Dan Misi error: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString()
            ]);
            $this->dispatch('visiMisiError', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function delete($id)
    {
        try {
            $visiMisi = Pages::findOrFail($id);
            $visiMisi->delete();
            $this->clearVisiMisiCache();
            $this->dispatch('visiMisiDeleted', 'Berhasil dihapus!');
        } catch (\Throwable $e) {
            Log::error('Visi Dan Misi delete error: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString()
            ]);
            $this->dispatch('visiMisiError', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function closeModal()
    {
        $this->id_pages = '';
        $this->title    = '';
        $this->content  = '';
        $this->image    = null;
        $this->file     = null;
        $this->isOpen   = false;
        $this->dispatch('resetEditor');
    }

    public function resetFields()
    {
        $this->id_pages = '';
        $this->title    = '';
        $this->content  = '';
        $this->image    = null;
        $this->file     = null;
    }
}
