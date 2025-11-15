@extends('layouts.layouts-users')
@push('css')
<!-- link css berita -->
<link rel="stylesheet" href="{{ asset('css/berita.css') }}">
@endpush
@section('content')
<!-- news & event section -->
<section class="news-section">
    <div class="container">
        <a href="{{ url()->previous() }}" class="text-muted button-back"><i class="bi bi-arrow-left me-2"></i> Kembali</a>

        <div class="d-flex justify-content-center align-items-center mb-2">
            <div class="title-section">Berita Kami</div>
        </div>
        <div class="d-flex justify-content-center align-items-center">
            <p class="description-section">Berita terbaru seputar kegiatan dan informasi kami</p>
        </div>

        <!-- komponen live wire -->
        <livewire:berita-list />
    </div>
</section>
<!-- news & event section-->
@endsection