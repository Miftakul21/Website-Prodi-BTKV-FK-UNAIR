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

class KalenderCrud extends Component
{
    use WithFileUploads;

    public $id_pages,
        $title,
        $content,
        $image,
        $file;

    public $isOpen = false;
    protected $listeners = [
        'updateKonten'    => 'updateKonten',
        'deleteKalender'  => 'delete'
    ];

    public function render()
    {
        $kalender = Cache::remember('kalender_page', 100, function () {
            return Pages::select(
                'id_pages as id_kalender',
                'title',
                'content',
                'image',
                'file'
            )
                ->where('slug', 'Kalender-Akademik')
                ->get();
        });

        return view('livewire.kalender-crud', [
            'kalender' => $kalender
        ]);
    }

    protected function clearKalenderCache()
    {
        Cache::forget('kalender_page');
    }

    public function create()
    {
        $this->resetFields();
        $this->title   = 'Kalender Akademik';
        $this->content = null;
        $this->image   = null;
        $this->file    = null;
        $this->isOpen  = true;
        $this->dispatch('initEditor');
    }

    public function edit($id)
    {
        $pages = Pages::findOrFail($id);
        $this->id_pages = $id;
        $this->title    = 'Kalender Akademik';
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
                'title'    => 'required|string',
                'content'  => 'nullable|string',
                'file'     => 'nullable|mimes:pdf|max:5120',
                'image'    => 'nullable|mimes:jpg,jpeg,png|max:5120'
            ]);

            $kalender = Pages::create([
                'title'    => $this->title,
                'content'  => Purifier::clean($this->content, 'custom'),
                'file'     => null,
                'image'    => null
            ]);

            if ($this->file) {
                DB::afterCommit(function () use ($kalender) {
                    $filename = Str::random(20) . '.'
                        . $this->file->getClientOriginalExtension();
                    $path     = $this->file->storeAs('akademik', $filename, 'public');
                    $kalender->update(['file' => $path]);
                });
            }

            if ($this->image) {
                DB::afterCommit(function () use ($kalender) {
                    $filename = Str::random(20) . '.'
                        . $this->image->getClientOriginalExtension();
                    $path     = $this->image->storeAs('akademik', $filename, 'public');
                    $kalender->update(['image' => $path]);
                });
            }

            DB::commit();
            $this->clearKalenderCache();
            $this->closeModal();
            $this->dispatch('kalenderSaved', 'Berhasil ditambahkan!');
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Kalender Akademik error: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString()
            ]);
        }
    }

    public function update()
    {
        DB::beginTransaction();

        try {
            $this->validate([
                'title'   => 'required|string',
                'content' => 'nullable|string',
                'file'    => 'nullable|mimes:pdf|max:5120',
                'image'   => 'nullable|mimes:jpg,jpeg,png|max:5120'
            ]);

            $kalender = Pages::findOrFail($this->id_pages);
            $kalender->update([
                'title'   => $this->title,
                'content' => Purifier::clean($this->content, 'custom'),
            ]);

            if ($this->file) {
                $oldPath  = $kalender->file;
                $fileBaru = $this->file;
                DB::afterCommit(function () use ($kalender, $oldPath, $fileBaru) {
                    // delete file lama jika ada
                    if ($oldPath && Storage::disk('public')->exists(str_replace('storage/', '', $oldPath))) {
                        Storage::disk('public')->delete(str_replace('storage/', '', $oldPath));
                    }
                    $filename = Str::random(20) . '.' . $this->file->getClientOriginalExtension();
                    $path     = $fileBaru->storeAs('akademik', $filename, 'public');
                    $kalender->update(['file' => $path]);
                });
            }

            if ($this->image) {
                $oldPath   = $kalender->image;
                $imageBaru = $this->image;
                DB::afterCommit(function () use ($kalender, $oldPath, $imageBaru) {
                    // delete image lama jika ada
                    if ($oldPath && Storage::disk('public')->exists(str_replace('storage/', '', $oldPath))) {
                        Storage::disk('public')->delete(str_replace('storage/', '', $oldPath));
                    }
                    $filename = Str::random(20) . '.' . $this->image->getClientOriginalExtension();
                    $path     = $imageBaru->storeAs('akademik', $filename, 'public');
                    $kalender->update(['image' => $path]);
                });
            }

            DB::commit();
            $this->clearKalenderCache();;
            $this->closeModal();
            $this->dispatch('kalenderSaved', 'Berhasil diperbarui!');
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Kalender update error: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
            ]);
            $this->dispatch('kalenderError', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function delete($id)
    {
        try {
            $kalender = Pages::findOrFail($id);
            $kalender->delete();
            $this->clearKalenderCache();
            $this->dispatch('kalenderDeleted');
        } catch (\Throwable $e) {
            Log::error('Kalender delete error: ' . $e->getMessage());
            $this->dispatch('kalenderError', 'Terjadi kesalahan: ' . $e->getMessage());
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
        $this->id_pages = '';
        $this->title    = '';
        $this->content  = '';
        $this->file     = null;
        $this->image    = null;
    }
}
