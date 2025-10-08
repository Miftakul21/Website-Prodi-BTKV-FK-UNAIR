@extends('layouts.layouts-users')
@push('css')
<!-- link css pengajar  -->
<link rel="stylesheet" href="{{ asset('css/pengajar.css') }}">
@endpush
@section('content')
<!-- pengajar -->
<section class="pengajar-section">
    <div class="container">
        <a href="{{ url()->previous() }}" class="text-muted button-back"><i class="bi bi-arrow-left me-2"></i> Kembali</a>

        <div class="d-flex justify-content-center align-items-center mb-2">
            <span class="title-section">Tenaga Pengajar Spesialis Kami</span>
        </div>
        <!-- <div class="d-flex justify-content-center align-items-center mb-2">
                <p class="description-section" style="text-align: center;">
                    Pengajar ahli kami merupakan dokter spesialis dengan pengalaman klinis dan akademis yang luas, yang membimbing <br> Program Pendidikan Dokter Spesialis Bedah Toraks, Kardiak, dan Vaskular
                </p>
            </div> -->

        <!-- komponen live wire -->
        <livewire:pengajar-list />
    </div>
</section>
<!-- end section pengajar -->
@endsection