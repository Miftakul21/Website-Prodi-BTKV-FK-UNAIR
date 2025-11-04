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


class YudisiumCrud extends Component
{
    use WithFileUploads;

    public $id_pages,
        $title,
        $content;

    public $isOpen = false;

    protected $listeners = [
        'updateKonten'   => 'updateKonten',
        'deleteYudisium' => 'delete'
    ];

    public function render()
    {
        $yudisium = Cache::remember('yudisium_page', 100, function () {
            return Pages::select(
                'id_pages as id_yudisium',
                'title',
                'content'
            )
                ->where('slug', 'Yudisium')
                ->get();
        });
        return view('livewire.yudisium-crud', [
            'yudisium' => $yudisium
        ]);
    }

    protected function clearYudisiumCache()
    {
        Cache::forget('yudisium_page');
    }

    public function create()
    {
        $this->resetFields();
        $this->title   = 'Yudisium';
        $this->content = null;
        $this->isOpen  = true;
        $this->dispatch('initEditor');
    }

    public function edit($id)
    {
        $pages = Pages::findOrFail($id);
        $this->id_pages = $id;
        $this->title    = 'Yudisium';
        $this->content  = $pages->content;
        $this->isOpen   = true;
        $this->dispatch('initEditor');
        $this->dispatch('loadKonten', $this->content);
    }

    // terima konten dari JS
    public function updateKonten($value = null)
    {
        $this->content = $value ?? '';
    }

    public function save()
    {
        DB::beginTransaction();
        try {
            $this->validate([
                'title'   => 'required|string|max:255',
                'content' => 'required|string',
            ]);

            Pages::create([
                'title'   => $this->title,
                'content' => Purifier::clean($this->content, 'custom'),
            ]);

            DB::commit();
            $this->clearYudisiumCache();
            $this->closeModal();
            $this->dispatch('yudisiumSaved', 'Berhasil ditambahkan!');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Yudisium Error: ' . $e->getMessage(), [
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
            ]);

            $yudisium = Pages::findOrFail($this->id_pages);
            $yudisium->update([
                'title'   => $this->title,
                'content' => Purifier::clean($this->content, 'custom')
            ]);

            DB::commit();
            $this->clearYidisiumCache();
            $this->closeModal();
            $this->dispatch('yudsiumUpdated', 'Berhasil diperbarui!');
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error("Yudisium error: " . $e->getMessage(), [
                'trace' => $e->getTraceAsString()
            ]);
            $this->dispatch('yudisiumError', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function delete($id)
    {
        try {
            $yudisium = Pages::findOrFail($id);
            $yudisium->delete();
            $this->clearYudisiumCache();
            $this->dispatch('yudisiumDeleted', 'Berhasil dihapus?');
        } catch (\Throwbla $e) {
            Log::error('Yudisium delete error: ' . $e->getMessage());
            $this->dispatch('yudisiumError', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function closeModal()
    {
        $this->id_pages = '';
        $this->title    = '';
        $this->content  = '';
        $this->isOpen   = false;
        $this->dispatch('resetEditor');
    }

    public function resetFields()
    {
        $this->id_pages = '';
        $this->title    = '';
        $this->content  = '';
    }
}
