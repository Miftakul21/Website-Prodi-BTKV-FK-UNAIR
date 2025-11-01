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

class TugasAkhirCrud extends Component
{
    use WithFileUploads;

    public $id_pages,
        $title,
        $content;

    public $isOpen = false;

    protected $listeners = [
        'updateKonten'     => 'updateKonten', // menerima payload dari JS
        'deleteTugasAkhir' => 'delete'
    ];

    public function render()
    {
        $tugas_akhir = Cache::remember('tugas_akhir_page', 100, function () {
            return Pages::select(
                'id_pages as id_tugas_akhir',
                'title',
                'content'
            )
                ->where('slug', 'Tugas-Akhir-Tesis')
                ->get();
        });

        return view('livewire.tugas-akhir-crud', [
            'tugas_akhir' => $tugas_akhir
        ]);
    }

    public function clearTugasAkhirCache()
    {
        Cache::forget('tugas_akhir_page');
    }

    public function create()
    {
        $this->resetFields();
        $this->title   = 'Tugas Akhir Tesis';
        $this->isOpen  = true;
        $this->dispatch('initEditor');
    }

    public function edit($id)
    {
        $pages =  Pages::findOrFail($id);
        $this->id_pages = $id;
        $this->title    = 'Tugas Akhir Tesis';
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

    public function store()
    {
        DB::beginTransaction();
        try {
            $this->validate([
                'title'    => 'nullable|string',
                'content'  => 'nullable|string',
            ]);

            Pages::create([
                'title'   => $this->title,
                'content' => Purifier::clean($this->content, 'custom')
            ]);

            DB::commit();
            $this->clearTugasAkhirCache();
            $this->closeModal();
            $this->dispatch('tugasAkhirSaved', 'Berhasil ditambahkan!');
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Tugas Akhir error: ' . $e->getMessage(), [
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

            $tugas_akhir = Pages::findOrFail($this->id_pages);
            $tugas_akhir->update([
                'title'   => $this->title,
                'content' => Purifier::clean($this->content, 'custom')
            ]);

            DB::commit();
            $this->clearTugasAkhirCache();
            $this->closeModal();
            $this->dispatch('tugasAkhirSaved', 'Berhasil diperbarui!');
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Tugas Akhir error: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString()
            ]);
        }
    }

    public function delete($id)
    {
        try {
            $tugas_akhir = Pages::findOrFail($id);
            $tugas_akhir->delete();

            $this->clearTugasAkhirCache();
            $this->dispatch('tugasAkhirDeleted');
        } catch (\Throwable $e) {
            Log::error('Tugas Akhir error: ' . $e->getMessage(), [
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
