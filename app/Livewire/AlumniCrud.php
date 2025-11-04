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

class AlumniCrud extends Component
{
    use WithFileUploads;

    public $id_pages,
        $title,
        $content,
        $file,
        $image;


    public $isOpen = false;

    protected $listeners = [
        'updateKonten' => 'updateKonten',
        'deleteAlumni' => 'delete'
    ];

    public function render()
    {
        $alumni = Cache::remember('alumni_page', 100, function () {
            return Pages::select(
                'id_pages as id_alumni',
                'title',
                'content',
                'file'
            )
                ->where('slug', 'Alumni')
                ->get();
        });

        return view('livewire.alumni-crud', [
            'alumni' => $alumni
        ]);
    }

    protected function clearAlumniCache()
    {
        Cache::forget('alumni_page');
    }

    public function create()
    {
        $this->resetFields();
        $this->title   = 'Alumni';
        $this->content = null;
        $this->file    = null;
        $this->isOpen  = true;
        $this->dispatch('initEditor');
    }

    public function edit($id)
    {
        $pages = Pages::findOrFail($id);
        $this->id_pages = $id;
        $this->title    = 'Alumni';
        $this->content  = $pages->content;
        $this->file     = null;
        $this->image    = null;
        $this->isOpen   = true;
        $this->dispatch('initEditor');
        $this->dispatch('loadKonten', $this->content);
    }

    // rerima konten dari JS
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

            $alumni = Pages::create([
                'title'   => $this->title,
                'content' => Purifier::clean($this->content, 'custom'),
                'file'    => null,
                'image'   => null
            ]);

            if ($this->file) {
                $fileBaru = $this->file;
                DB::afterCommit(function () use ($alumni, $fileBaru) {
                    $filename = Str::random(20) . '.' . $fileBaru->getClientOriginalExtension();
                    $path     = $fileBaru->storeAs('akademik', $filename, 'public');
                    $alumni->update(['file' => $path]);
                });
            }

            if ($this->image) {
                $imageBaru = $this->image;
                DB::afterCommit(function () use ($alumni, $imageBaru) {
                    $filename = Str::random(20) . '.' . $imageBaru->getClientOriginalExtension();
                    $path     = $imageBaru->storeAs('akademik', $filename, 'public');
                    $alumni->update(['image' => $path]);
                });
            }

            DB::commit();
            $this->clearAlumniCache();
            $this->closeModal();
            $this->dispatch('alumniSaved', 'Berhasil ditambahkan!');
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Error menyimpan data alumni: ' . $e->getMessage(), [
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

            $alumni = Pages::findOrFail($this->id_pages);
            $alumni->update([
                'title'   => $this->title,
                'content' => Purifier::clean($this->content, 'custom'),
            ]);

            if ($this->file) {
                $oldPath  = $alumni->file;
                $fileBaru = $this->file;
                DB::afterCommit(function () use ($alumni, $oldPath, $fileBaru) {
                    if ($oldPath && Storage::disk('public')->exists(str_replace('storage/', '', $oldPath))) {
                        Storage::disk('public')->delete(str_replace('storage/', '', $oldPath));
                    }
                    $filename = Str::random(20) . '.' . $fileBaru->getClientOriginalExtension();
                    $path     = $fileBaru->storeAs('akademik', $filename, 'public');
                    $alumni->update(['file' => $path]);
                });
            }

            if ($this->image) {
                $oldPath  = $alumni->image;
                $imageBaru = $this->image;
                DB::afterCommit(function () use ($alumni, $oldPath, $imageBaru) {
                    // delete image lama jika ada
                    if ($oldPath && Storage::disk('public')->exists(str_replace('storage/', '', $oldPath))) {
                        Storage::disk('public')->delete(str_replace('storage/', '', $oldPath));
                    }
                    $filename = Str::random(20) . '.' . $imageBaru->getClientOriginalExtension();
                    $path     = $imageBaru->storeAs('akademik', $filename, 'public');
                    $alumni->update(['image' => $path]);
                });
            }

            DB::commit();
            $this->clearAlumniCache();
            $this->closeModal();
            $this->dispatch('alumniSaved', 'Berhasil diperbarui!');
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('alumni update error: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
            ]);
            $this->dispatch('alumniError', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function delete($id)
    {
        try {
            $alumni = Pages::findOrFail($id);
            $alumni->delete();
            $this->clearAlumniCache();
            $this->dispatch('alumniDeleted');
        } catch (\Throwable $e) {
            Log::error('Alumni delete error: ' . $e->getMessage());
            $this->dispatch('alumniError', 'Terjadi kesalahan: ' . $e->getMessage());
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
