<?php

namespace App\Livewire;

use App\Models\Pengajar;
use Illuminate\Support\Facades\Cache;
use Livewire\Component;

class PengajarList extends Component
{
    public $limit = 8;
    public $loading = false;

    protected $listeners = ['loadMore'];

    public function loadMore()
    {
        $this->loading = true;
        usleep(300000); // efek delay
        $this->limit += 8;
        $this->loading = false;
    }

    public function render()
    {
        $pengajar_all = Cache::remember('pengajar_all', now()->addMinutes(5), function () {
            return Pengajar::orderBy('created_at', 'asc')
                ->select(
                    'id_pengajar as pengajar_id',
                    'name as pengajar_name',
                    'posisi as pengajar_position',
                    'pendidikan as pengajar_pendidikan',
                    'foto as pengajar_foto',
                    'slug as pengajar_slug'
                )
                ->get();
        });

        $pengajar = $pengajar_all->take($this->limit);
        $total = $pengajar_all->count();

        return view('livewire.pengajar-list', [
            'pengajar' => $pengajar,
            'total' => $total,
        ]);
    }
}
