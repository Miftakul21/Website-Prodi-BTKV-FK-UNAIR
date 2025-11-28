<div>
    <div class="row g-4">
        @forelse($artikel as $data)
        <div class="col-12 col-md-6 col-lg-3">
            @php
            $url = '';
            switch($data->artikel_category){
            case 'Berita':
            $url = '/detail-artikel/'.$data->artikel_slug;
            break;
            case 'Prestasi':
            $url = '/detail-prestasi/'.$data->artikel_slug;
            break;
            case 'Hasil Karya':
            $url = '/detail-hasil-karya/'.$data->artikel_slug;
            break;
            case 'Event':
            $url = '/detail-event/'.$data->artikel_slug;
            break;
            default:
            break;
            }
            @endphp
            <a href="{{ $url }}">
                <div class="card h-100 shadow-sm border-0">
                    <div class="overflow-hidden">
                        <img src="{{asset('storage/'. $data->artikel_thumbnail)}}" alt="" class="card-img-top img-zoom" alt="{{$data->artikel_title}}">
                    </div>
                    <div class="card-body">
                        <div class="d-flex justify-content-between text-muted small mb-2">
                            <span><i class="bi bi-calendar"></i> {{\Carbon\Carbon::parse($data->tgl_artikel)->format('M, d Y')}}</span>
                            <span><i class="bi bi-eye"></i> {{$data->artikel_views_count}}</span>
                        </div>
                        <h5 class="card-title fw-bold text-dark">{{Str::limit($data->artikel_title, 90)}}</h5>
                        <p class="card-text text-dark">{{Str::limit(strip_tags($data->artikel_content, 100))}}</p>
                    </div>
                </div>
            </a>
        </div>
        @empty
        @endforelse
    </div>

    <!-- tombol muat lebih banyak -->
    @if($artikel->count() < $total)
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