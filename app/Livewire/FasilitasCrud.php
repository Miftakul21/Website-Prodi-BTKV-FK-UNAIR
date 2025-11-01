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

class FasilitasCrud extends Component
{
    use WithFileUploads;

    public $id_pages,
        $title,
        $content;

    public $isOpen = false;

    protected $listeners = [
        'updateKonten'     => 'updateKonten', // menerima payload dari JS
        'deleteFasilitas' => 'delete'
    ];

    public function render()
    {
        $fasilitas = Cache::remember('fasilitas_page', 100, function () {
            return Pages::select(
                'id_pages as id_fasilitas',
                'title',
                'content'
            )
                ->where('faslitias')
                ->get();
        });

        return view('livewire.fasilitas-crud', [
            'fasilitas' => $fasilitas
        ]);
    }

    public function clearFaslitasCache()
    {
        Cache::forget('fasilitas_page');
    }

    public function create()
    {
        $this->resetFields();
        $this->title   = 'Fasilitas';
        $this->isOpen  = true;
        $this->dispatch('initEditor');
    }

    public function edit($id)
    {
        $pages =  Pages::findOrFail($id);
        $this->id_pages = $id;
        $this->title    = 'Fasilitas';
        $this->content  = $pages->content;
        $this->isOpen   = true;
        $this->dispatch('initEditor');
        $this->dispatch('loadKonten', $this->content);
    }

    public function updateKonten($value = null)
    {
        $this->content = $value ?? '';
    }

    public function store()
    {
        DB::beginTransaction();
        try {
            $this->validate([
                'title'   => 'nullable|string',
                'content' => 'nullable|string',
            ]);

            Pages::create([
                'title'   => $this->title,
                'content' => Purifier::clean($this->content, 'custom')
            ]);

            DB::commit();
            $this->clearFaslitasCache();
            $this->closeModal();
            $this->dispatch('faslitias', 'Berhasil ditambahjan');
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Fasilitas error: ' . $e->getMessage(), [
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
                'content' => 'nullable|string'
            ]);

            $fasilitas = Pages::findOrFail($this->id_pages);
            $fasilitas->update([
                'title'   => $this->title,
                'content' => Purifier::clean($this->content, 'custom')
            ]);

            DB::commit();
            $this->clearFasilitasCache();
            $this->closeModal();
            $this->dispatch('fasilitascSaved', 'Berhasil diperbarui!');
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Fasilitas error: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString()
            ]);
        }
    }

    public function delete($id)
    {
        try {
            $fasilitas = Pages::findOrFail($id);
            $fasilitas->delete();

            $this->clearFasilitasCache();
            $this->dispatch('faslitasDeleted');
        } catch (\Throwable $e) {
            Log::error('Fasilitas error: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString()
            ]);
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
