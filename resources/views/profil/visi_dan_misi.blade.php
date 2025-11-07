@extends('layouts.layouts-users')
@push('css')
<link rel="stylesheet" href="{{asset('css/profil-visi-misi.css')}}">
@endpush

@section('content')
<section class="visi-misi-section">
    <div class="container">
        <a href="{{url()->previous()}}" class="text-muted button-back"><i class="bi bi-arrow-left me-2"></i> Kembali</a>
        <div class="d-flex  my-3">
            <span class="info-section">Visi Dan Misi Program Studi Spesialis I <br> Bedah Toraks, Kardiak, Dan Vaskular Fakultas Universitas Airlangga</span>
        </div>

        <div class="row">
            <div class="col-xl-8 col-md-8 col-12">
                <div class="container-content">
                    <div>
                        {!! $visi_dan_misi ?? '' !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection