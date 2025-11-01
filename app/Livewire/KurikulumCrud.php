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

class KurikulumCrud extends Component
{
    use WithFileUploads;

    public $id_pages,
        $title,
        $content,
        $image,
        $file;

    public $isOpen = false;

    protected $listeners = [
        'updateKonten'    => 'updateKonten', // menerima payload dari JS
        'deleteKurikulum' => 'delete'
    ];

    public function render()
    {
        $kurikulum = Cache::remember('kurikulum_page', 100, function () {
            return Pages::select(
                'id_pages as id_kurikulum',
                'title',
                'content',
                'image',
                'file'
            )
                ->where('slug', 'Kurikulum-Akademik')
                ->get();
        });

        return view('livewire.kurikulum-crud', [
            'kurikulum' => $kurikulum
        ]);
    }

    protected function clearKurikulumCache()
    {
        Cache::forget('kurikulum_page');
    }

    public function create()
    {
        $this->resetFields();
        $this->title   = 'Kurikulum Akademik';
        $this->image   = null;
        $this->file    = null;
        $this->isOpen  = true;
        $this->dispatch('initEditor');
    }

    public function edit($id)
    {
        $pages = Pages::findOrFail($id);
        $this->id_pages = $id;
        $this->title    = 'Kurikulum Akademik';
        $this->content  = $pages->content;
        $this->file     = null;
        $this->image    = null;
        $this->isOpen   = true;
        $this->dispatch('initEditor');
        $this->dispatch('loadKonten', $this->content);
    }

    // terima konten dari JS
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

            $kurikulum = Pages::create([
                'title'    => $this->title,
                'content'  => Purifier::clean($this->content, 'custom'),
                'file'     => null,
                'image'    => null
            ]);

            if ($this->file) {
                $fileBaru = $this->file;
                DB::afterCommit(function () use ($kurikulum, $fileBaru) {
                    $filename = Str::random(20) . '.' . $fileBaru->getClientOriginalExtension();
                    $path     = $fileBaru->storeAs('akademik', $filename, 'public');
                    $kurikulum->update(['file' => $path]);
                });
            }

            if ($this->image) {
                $imageBaru = $this->image;
                DB::afterCommit(function () use ($kurikulum, $imageBaru) {
                    $filename = Str::random(20) . '.'
                        . $imageBaru->getClientOriginalExtension();
                    $path     = $imageBaru->storeAs('akademik', $filename, 'public');
                    $kurikulum->update(['image' => $path]);
                });
            }

            DB::commit();
            $this->clearKurikulumCache();
            $this->closeModal();
            $this->dispatch('kurikulumSaved', 'Berhasil ditambahkan!');
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error("Kurikulum Akademik error: " . $e->getMessage(), [
                'trace' => $e->getTraceAsString()
            ]);
        }
    }

    public function update()
    {
        DB::beginTransaction();

        try {
            $this->validate([
                'title'   => 'nullable|string',
                'content' => 'nullable|string',
                'file'    => 'nullable|mimes:pdf|max:5120',
                'image'   => 'nullable|mimes:jpg,jpeg,png|max:5120'
            ]);

            $kurikulum = Pages::findOrFail($this->id_pages);
            $kurikulum->update([
                'title'   => $this->title,
                'content' => Purifier::clean($this->content, 'custom'),
            ]);

            if ($this->file) {
                $oldPath  = $kurikulum->file;
                $fileBaru = $this->file;
                DB::afterCommit(function () use ($kurikulum, $oldPath, $fileBaru) {
                    // delete file lama jika ada
                    if ($oldPath && Storage::disk('public')->exists(str_replace('storage/', '', $oldPath))) {
                        Storage::disk('public')->delete(str_replace('storage/', '', $oldPath));
                    }
                    $filename = Str::random(20) . '.' . $fileBaru->getClientOriginalExtension();
                    $path     = $fileBaru->storeAs('akademik', $filename, 'public');
                    $kurikulum->update(['file' => $path]);
                });
            }

            if ($this->image) {
                $oldPath   = $kurikulum->image;
                $imageBaru = $this->image;
                DB::afterCommit(function () use ($kurikulum, $oldPath, $imageBaru) {
                    // delete image lama jika ada
                    if ($oldPath && Storage::disk('public')->exists(str_replace('storage/', '', $oldPath))) {
                        Storage::disk('public')->delete(str_replace('storage/', '', $oldPath));
                    }
                    $filename = Str::random(20) . '.' . $imageBaru->getClientOriginalExtension();
                    $path     = $imageBaru->storeAs('akademik', $filename, 'public');
                    $kurikulum->update(['image' => $path]);
                });
            }

            DB::commit();
            $this->clearKurikulumCache();;
            $this->closeModal();
            $this->dispatch('kurikulumSaved', 'Berhasil diperbarui!');
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('kurikulum update error: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
            ]);
            $this->dispatch('kurikulumError', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function delete($id)
    {
        try {
            $kurikulum = Pages::findOrFail($id);
            $kurikulum->delete();
            $this->clearKurikulumCache();
            $this->dispatch('kurikulumDeleted');
        } catch (\Throwable $e) {
            Log::error("Kurikulum delete error: " . $e->getMessage());
            $this->dispatch('kurikulumError', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function closeModal()
    {
        $this->id_pages = '';
        $this->title    = '';
        $this->content  = '';
        $this->file     = null;
        $this->image    = null;
        $this->isOpen   = false;
        $this->dispatch('resetEditor');
    }


    public function resetFields()
    {
        $this->id_pages = '';
        $this->title    = '';
        $this->content  = '';
        $this->file     = null;
        $this->image    = null;
    }
}
