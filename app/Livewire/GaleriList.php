<?php

namespace App\Livewire;

use App\Models\Galeri;
use Illuminate\Support\Facades\Cache;
use Livewire\Component;


class GaleriList extends Component
{
    public $limit = 8;
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
        $galeri_all = Cache::remember('galeri_all', now()->addMinutes(5), function () {
            return Galeri::orderByDesc('created_at')
                ->select(
                    'id_galeri as galeri_id',
                    'judul_galeri as galeri_title',
                    'image_utama as galeri_thumbnail',
                    'kategori as galeri_category',
                    'slug as galeri_slug ',
                )
                ->get();
        });
        $galeri = $galeri_all->take($this->limit);
        $total  = $galeri_all->count();

        return view('livewire.galeri-list', [
            'galeri' => $galeri,
            'total'  => $total
        ]);
    }
}
