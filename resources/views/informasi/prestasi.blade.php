@extends('layouts.layouts-users')
@push('css')
<!-- link css berita -->
<link rel="stylesheet" href="{{ asset('css/informasi-prestasi.css') }}">
@endpush
@section('content')
<!-- prestasi section -->
<section class="prestasi-section">
    <div class="container">
        <a href="{{ url()->previous() }}" class="text-mutated button-back"><i class="bi bi-arrow-left me-2"></i> Kembali</a>
        <div class="d-flex justify-content-center align-items-center mb-2">
            <div class="title-section">Prestasi</div>
        </div>

        <!-- komponen live wire -->
        <livewire:prestasi-list />
    </div>
</section>
@endsection