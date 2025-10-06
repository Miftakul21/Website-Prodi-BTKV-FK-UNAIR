<?php

namespace App\Livewire;

use App\Models\Berita;
use Illuminate\Support\Facades\Cache;
use Livewire\Component;

class BeritaList extends Component
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
        $berita_all = Cache::remember('berita_all', now()->addMinutes(5), function () {
            return Berita::orderByDesc('tgl_berita')
                ->select(
                    'id_berita as berita_id',
                    'judul as berita_title',
                    'konten_berita as berita_content',
                    'slug as berita_slug',
                    'tgl_berita as berita_date',
                    'kategori as berita_category',
                    'thumbnail_image as berita_thumbnail',
                    'viewers as berita_views_count',
                )
                ->get();
        });

        $berita = $berita_all->take($this->limit);
        $total = $berita_all->count();

        return view('livewire.berita-list', [
            'berita' => $berita,
            'total' => $total,
        ]);
    }
}
