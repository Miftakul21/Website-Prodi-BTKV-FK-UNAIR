<?php

namespace App\Livewire;

use App\Models\Pengajar;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithPagination;

class PengajarDelete extends Component
{
    use WithPagination;

    public $selectedPengajars = [];
    public $selectAll = false;

    protected $paginationTheme = 'bootstrap';

    public function render()
    {
        $pengajars = Pengajar::onlyTrashed()
            ->latest()
            ->paginate(20);

        return view('livewire.pengajar-delete', compact('pengajars'));
    }

    public function updatedSelectedPengajars()
    {
        // auto update selectAll kalau semua baris dicentang
        $total = Pengajar::onlyTrashed()->count();
        $this->selectAll = ($total > 0 && count($this->selectedPengajars) === $total);
    }

    public function toggleSelectAll()
    {
        if ($this->selectAll) {
            // kalau selectAll = true -> uncheck semua
            $this->selectAll = false;
            $this->selectedPengajars = [];
        } else {
            // kalau selectAll = false -> check semua
            $this->selectAll = true;
            $this->selectedPengajars = Pengajar::onlyTrashed()->pluck('id_pengajar')->toArray();
        }
    }

    public function restoreSelected()
    {
        if (!empty($this->selectedPengajars)) {
            Pengajar::withTrashed()
                ->whereIn('id_pengajar', $this->selectedPengajars)
                ->restore();
            $this->reset(['selectedPengajars', 'selectAll']);
        }
    }

    public function deleteSelected()
    {
        if (!empty($this->selectedPengajars)) {
            $pengajars = Pengajar::withTrashed()
                ->whereIn('id_pengajar', $this->selectedPengajars)
                ->get();

            foreach ($pengajars as $data) {
                if ($data->foto && Storage::disk('public')->exists($data->foto)) {
                    Storage::disk('public')->delete($data->foto);
                }
            }

            Pengajar::withTrashed()
                ->whereIn('id_pengajar', $this->selectedPengajars)
                ->forceDelete();

            $this->reset(['selectedPengajars', 'selectAll']);
            $this->dispatch('pengajarDeleted');
        }
    }
}
