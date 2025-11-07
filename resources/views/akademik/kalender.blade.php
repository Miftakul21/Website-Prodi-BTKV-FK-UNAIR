@extends('layouts.layouts-users')
@push('css')
<link rel="stylesheet" href="{{asset('css/akademik-kalender.css')}}">
@endpush

@section('content')
<section class="kalender-section">
    <div class="container">
        <a href="{{url()->previous()}}" class="text-muted button-back"><i class="bi bi-arrow-left me-2"></i> Kembali</a>

        <div class="d-flex mb-3 mt-3">
            <span class="info-section">Kalender Akademik</span>
        </div>

        <div class="row">
            <div class="col-12">
                <!-- <h6>Kalender Akademik dapat diunduh pada link berikut:</h6> -->
                {!!$kalender!!}
                @if($file)
                <a href="">Download Kalender Akademik Unair</a>
                @endif
            </div>
            <div class="col-12">
                <div class="container-image-kalender">
                    @if($image)
                    <img src="{{asset('img/kalender.jpg')}}" alt="">
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>
@endsection