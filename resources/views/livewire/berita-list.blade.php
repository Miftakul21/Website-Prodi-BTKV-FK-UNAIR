<div>
    <div class="row g-4">
        @forelse($berita as $data)
        <div class="col-12 col-md-6 col-lg-3">
            <a href="/detail-berita/{{$data->berita_slug}}">
                <div class="card h-100 shadow-sm border-0">
                    <div class="overflow-hidden">
                        <img src="{{asset('storage/'. $data->berita_thumbnail)}}" alt="" class="card-img-top img-zoom" alt="{{$data->berita_title}}">
                    </div>
                    <div class="card-body">
                        <div class="d-flex justify-content-between text-muted small mb-2">
                            <span><i class="bi bi-calendar"></i> {{\Carbon\Carbon::parse($data->tgl_berita)->format('M, d Y')}}</span>
                            <span><i class="bi bi-eye"></i> {{$data->berita_views_count}}</span>
                        </div>
                        <h5 class="card-title fw-bold text-dark">{{Str::limit($data->berita_title, 90)}}</h5>
                        <p class="card-text text-dark">{{Str::limit(strip_tags($data->berita_content, 100))}}</p>
                    </div>
                </div>
            </a>
        </div>
        @empty
        @endforelse
    </div>

    <!-- tombol muat lebih banyak -->
    @if($berita->count() < $total)
        <div class="d-flex justify-content-center align-items-center">
        <button wire:click="loadMore" class="btn btn-primary my-5" wire:loading.attr="disabled">
            <span wire:loading.remove wire:target="loadMore">
                Muat Lebih Banyak
            </span>
            <span wire:loading wire:target="loadMore">
                <i class="bi bi-arrow-repeat spin me-2"></i> Memuat
            </span>
        </button>
</div>
@endif

<style>
    .spin {
        display: inline-block;
        animation: spin 0.6s linear infinite;
    }

    @keyframes spin {
        from {
            transform: rotate(0deg);
        }

        to {
            transform: rotate(360deg);
        }
    }
</style>
</div>