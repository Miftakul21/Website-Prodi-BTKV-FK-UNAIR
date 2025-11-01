@extends('layouts.layouts-users')
@push('css')
<link rel="stylesheet" href="{{asset('css/akademik-kurikulum.css')}}">
@endpush

@section('content')
<section class="kurikulum-section">
    <div class="container">
        <a href="{{url()->previous()}}" class="text-muted button-back"><i class="bi bi-arrow-left me-2"></i> Kembali</a>

        <div class="d-flex justify-content-center align-items-center mb-3">
            <span class="info-section">Kurikulum Akademik</span>
        </div>

        <div class="row">
            <div class="col-12">
                <!-- 
                    Konten Kurikulum Akademik Mungkin Diisi Dari Sini
                -->
            </div>

            <!-- Kayaknya gak ada sih image hanya konten aja -->
        </div>
    </div>
</section>
@endsection