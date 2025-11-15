<?php

namespace App\Livewire;

use App\Models\Artikel;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithPagination;


class ArtikelDelete extends Component
{
    use WithPagination;

    public $selectedArtikels = [];
    public $selectAll = false;

    protected $paginationTheme = 'bootstrap';

    public function render()
    {
        $artikels = Artikel::onlyTrashed()
            ->with('user:id_user,name')
            ->latest()
            ->paginate(20);

        return view('livewire.artikel-delete', compact('artikels'));
    }

    public function updatedSelectedArtikels()
    {
        // auto update selectAll kalau semua baris dicentang
        $total = Artikel::onlyTrashed()->count();
        $this->selectAll = ($total > 0 && count($this->selectedArtikels) === $total);
    }

    public function toggleSelectAll()
    {
        if ($this->selectAll) {
            // kalau selectAll = true → uncheck semua
            $this->selectAll = false;
            $this->selectedArtikels = [];
        } else {
            // kalau selectAll = false → check semua
            $this->selectAll = true;
            $this->selectedArtikels = Artikel::onlyTrashed()->pluck('id_artikel')->toArray();
        }
    }

    public function restoreSelected()
    {
        if (!empty($this->selectedArtikels)) {
            Artikel::withTrashed()
                ->whereIn('id_artikel', $this->selectedArtikels)
                ->restore();
            $this->reset(['selectedArtikels', 'selectAll']);
        }
    }

    public function deleteSelected()
    {
        if (!empty($this->selectedArtikels)) {
            $artikels = Artikel::withTrashed()
                ->whereIn('id_artikel', $this->selectedArtikels)
                ->get();

            foreach ($artikels as $data) {
                if ($data->thumbnail_image && Storage::disk('public')->exists($data->thumbnail_image)) {
                    Storage::disk('public')->delete($data->thumbnail_image);
                }
            }

            Artikel::withTrashed()
                ->whereIn('id_artikel', $this->selectedArtikels)
                ->forceDelete();

            $this->reset(['selectedArtikels', 'selectAll']);
            $this->dispatch('ArtikelDeleted');
        }
    }
}
