@extends('layouts.layouts-users')
@push('css')
<link rel="stylesheet" href="{{asset('css/akademik-kalender.css')}}">
@endpush

@section('content')
<section class="kalender-section">
    <div class="container">
        <a href="{{url()->previous()}}" class="text-muted button-back"><i class="bi bi-arrow-left me-2"></i> Kembali</a>

        <div class="d-flex justify-content-center align-items-center mb-3">
            <span class="info-section">Kalender Akademik</span>
        </div>

        <div class="row">
            <div class="col-12">
                <h6>Kalender Akademik dapat diunduh pada link berikut:</h6>
                <a href="">Download Kalender Akademik Unair 2025 / 2026</a>
            </div>
            <div class="col-12">
                <div class="container-image-kalender">
                    <img src="{{asset('img/kalender.jpg')}}" alt="">
                </div>
            </div>
        </div>
    </div>
</section>
@endsection