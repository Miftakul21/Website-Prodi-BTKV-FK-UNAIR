@extends('layouts.layouts-users')
@push('css')
<link rel="stylesheet" href="{{asset('css/profil-akreditasi.css')}}">
@endpush

@section('content')
<section class="akreditasi-section">
    <div class="container">
        <a href="{{url()->previous()}}" class="text-muted button-back"><i class="bi bi-arrow-left me-2"></i> Kembali</a>

        <div class="d-flex justify-content-center align-items-center my-3">
            <span class="info-section">Akreditasi <br> Program Studi Spesialis I <br> Bedah Toraks, Kardiak, Dan Vaskular Fakultas Kedokteran Universitas Airlangga</span>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="container-akreditasi-1">
                    <img src="{{asset('img/akreditasi.png')}}" alt="">
                </div>
            </div>
        </div>
    </div>
</section>
@endsection