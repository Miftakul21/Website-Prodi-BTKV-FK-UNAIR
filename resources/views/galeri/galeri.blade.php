@extends('layouts.layouts-users')
@push('css')
<!-- link css galeri -->
<link rel="stylesheet" href="{{ asset('css/galeri.css') }}">
@endpush
@section('content')
<!-- galeri section -->
<section class="galeri-section">
    <div class="container">
        <a href="{{url()->previous()}}" class="text-muted button-back"><i class="bi bi-arrow-left me-2"></i> Kembali</a>

        <div class="d-flex justify-content-center align-items-center mb-2">
            <div class="title-section">Galeri Kami</div>
        </div>

        <!-- komponen livewire  -->
        <livewire:galeri-list />

    </div>
</section>
@endsection