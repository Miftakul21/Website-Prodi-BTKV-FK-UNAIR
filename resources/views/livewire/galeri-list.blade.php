<div>
    <div class="row g-4">
        @forelse($galeri as $data)
        <a href="" style="color: unset;">
            <div class="col-12 col-sm-6 col-lg-3 gallery-item" data-cats="{{strtolower($data->galeri_category)}}">
                <div class="card h-100 shadow-sm">
                    <img src="{{asset('storage/'.$data->galeri_thumbnail)}}" alt="">
                    <div class="card-body text-center">
                        <h6 class="card-title mb-0 fw-bold">{{$data->galeri_title}}</h6>
                    </div>
                </div>
            </div>
        </a>
        @empty
        @endforelse
    </div>

    <!-- tombol muat lebih banyak -->
    @if($galeri->count() < $total)
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