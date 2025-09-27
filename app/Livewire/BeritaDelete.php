<?php

namespace App\Livewire;

use App\Models\Berita;
use Livewire\Component;
use Livewire\WithPagination;

class BeritaDelete extends Component
{
    use WithPagination;

    public $selectedBeritas = [];
    public $selectAll = false;

    protected $paginationTheme = 'bootstrap';

    public function render()
    {
        $beritas = Berita::onlyTrashed()
            ->with('user:id_user,name')
            ->latest()
            ->paginate(20);

        return view('livewire.berita-delete', compact('beritas'));
    }

    public function updatedSelectedBeritas()
    {
        // auto update selectAll kalau semua baris dicentang
        $total = Berita::onlyTrashed()->count();
        $this->selectAll = ($total > 0 && count($this->selectedBeritas) === $total);
    }

    public function toggleSelectAll()
    {
        if ($this->selectAll) {
            // kalau selectAll = true → uncheck semua
            $this->selectAll = false;
            $this->selectedBeritas = [];
        } else {
            // kalau selectAll = false → check semua
            $this->selectAll = true;
            $this->selectedBeritas = Berita::onlyTrashed()->pluck('id_berita')->toArray();
        }
    }

    public function restoreSelected()
    {
        if (!empty($this->selectedBeritas)) {
            Berita::withTrashed()
                ->whereIn('id_berita', $this->selectedBeritas)
                ->restore();
            $this->reset(['selectedBeritas', 'selectAll']);
        }
    }

    public function deleteSelected()
    {
        if (!empty($this->selectedBeritas)) {
            Berita::withTrashed()
                ->whereIn('id_berita', $this->selectedBeritas)
                ->forceDelete();
            $this->reset(['selectedBeritas', 'selectAll']);
        }
    }
}
