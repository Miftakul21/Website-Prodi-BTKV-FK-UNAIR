@extends('layouts.layouts-users')
@push('css')
<!-- link css berita -->
<link rel="stylesheet" href="{{ asset('css/informasi-hasil-karya.css') }}">
@endpush

@section('content')
<!-- hasil-karya section -->
<section class="hasil-karya-section">
    <div class="container">
        <a href="{{ url()->previous() }}" class="text-mutated button-back"><i class="bi bi-arrow-left me-2"></i> Kembali</a>
        <div class="d-flex justify-content-center align-items-center mb-2">
            <div class="title-section">Hasil Karya</div>
        </div>

        <!-- komponen live wire -->
        <livewire:artikel-list category="Hasil Karya" />
    </div>
</section>
@endsection