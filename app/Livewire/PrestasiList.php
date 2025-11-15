<?php

namespace App\Livewire;

use App\Models\Artikel;
use Illuminate\Support\Facades\Cache;
use Livewire\Component;

class PrestasiList extends Component
{
    public $limit   = 8;
    public $loading = false;

    protected $listeners = ['loadMore'];

    public function loadMore()
    {
        $this->loading  = true;
        usleep(30000);
        $this->limit   += 8;
        $this->loading  = false;
    }

    public function render()
    {
        $prestasi_all = Cache::remember('prestasi_all', now()->addMinutes(5), function () {
            return Artikel::orderByDesc('tgl_artikel')
                ->select(
                    'id_artikel      as prestasi_id',
                    'judul           as prestasi_title',
                    'konten_artikel  as prestasi_content',
                    'slug            as prestasi_slug',
                    'tgl_artikel     as prestasi_date',
                    'kategori        as prestasi_category',
                    'thumbnail_image as prestasi_thumbnail',
                    'viewers         as prestasi_views_count',
                )
                ->where('kategori', 'Prestasi')
                ->get();
        });

        $prestasi = $prestasi_all->take($this->limit);
        $total    = $prestasi_all->count();

        return view('livewire.prestasi-list', [
            'prestasi' => $prestasi,
            'total'    => $total
        ]);
    }
}
