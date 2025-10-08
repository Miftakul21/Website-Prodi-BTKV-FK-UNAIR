<div>
    <div class="row py-3">
        @forelse($pengajar as $data)
        <div class="col-md-3 col-12">
            <a href="/detail-pengajar/{{$data->pengajar_slug}}">
                <div class="card shadow-sm border-0 mb-3" style="min-height: 480px;">
                    <!-- Foto Dokter -->
                    <div class="container-image-pengajar">
                        <img src="{{ asset('storage/'.$data->pengajar_foto) }}" class="card-img-top" alt="{{$data->pengajar_name}}">
                    </div>
                    <div class="card-body shadow-sm">
                        <!-- Nama & Jabatan -->
                        <h5 class="card-title mb-0 text-dark">{{$data->pengajar_name}}</h5>
                        <p class="text-primary fw-semibold mb-2 text-primary">{{$data->pengajar_position}}</p>

                        <!-- Pendidikan -->
                        <p class="mb-1 text-dark"><strong>Pendidikan</strong></p>
                        <p class="text-muted">{{$data->pengajar_pendidikan}}</p>

                        <!-- Publikasi Karya Tulis Ilmiah  & Penghargaan -->
                        <!-- <p class="text-muted mb-0 " style="white-space: nowrap; font-size: 14px;">
                            <i class="bi bi-journal-text"></i> 150+ Karya tulis ilmiah<br>
                            <i class="bi bi-award"></i> 2 Penghargaan Spesialis
                        </p> -->
                    </div>
                </div>
            </a>
        </div>
        @empty
        @endforelse
    </div>
    @if($pengajar->count() < $total)
        <div class="d-flex justify-content-center align-items-center">
        <button wire:click="loadMore" class="btn btn-priamry my-5" wire:loading.attr="disabled">
            <span wire:loading.remove wire:target="loadMore">
                Muat Lebih Banya
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