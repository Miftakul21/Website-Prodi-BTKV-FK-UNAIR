<?php

namespace App\Livewire;

use App\Models\Artikel;
use Illuminate\Support\Facades\Cache;
use Livewire\Component;

class ArtikelList extends Component
{
    public $limit   = 8;
    public $loading = false;
    protected $listeners = ['loadMore'];

    public function loadMore()
    {
        $this->loading = true;
        usleep(300000);
        $this->limit  += 8;
        $this->loading = false;
    }

    public function render()
    {
        $artikel_all = Cache::remember('artikel_all', now()->addMinutes(5), function () {
            return Artikel::orderByDesc('tgl_artikel')
                ->select(
                    'id_artikel      as artikel_id',
                    'judul           as artikel_title',
                    'konten_artikel   as artikel_content',
                    'slug            as artikel_slug',
                    'tgl_artikel      as artikel_date',
                    'kategori        as artikel_category',
                    'thumbnail_image as artikel_thumbnail',
                    'viewers         as artikel_views_count',
                )
                ->where('kategori', 'Berita')
                ->get();
        });

        $artikel = $artikel_all->take($this->limit);
        $total   = $artikel_all->count();

        return view('livewire.artikel-list', [
            'artikel' => $artikel,
            'total'   => $total
        ]);
    }
}
