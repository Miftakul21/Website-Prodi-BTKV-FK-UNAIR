@extends('layouts.layouts-users')

@push('css')
<link rel="stylesheet" href="{{asset('css/profil-fasilitas.css')}}">
@endpush

@section('content')
<section class="fasilitas-section">
    <div class="container">
        <a href="{{url()->previous()}}" class="text-muted button-back"><i class="bi bi-arrow-left me-2"></i> Kembali</a>

        <div class="d-flex justify-content-center align-items-center my-3">
            <span class="info-section">Fasilitas <br> Program Studi Spesialis I <br> Bedah Toraks, Kardiak, Dan Vaskular Fakultas Kedokteran Universias Airlangga</span>
        </div>

        <div class="row">
            <div class="col-lg-8 col-md-8 col-12">
                <div class="container-content">
                    <p>Fasilitas yang tersedia dilingkungan Fakultas Kedokteran Universitas Airlangga mendukung terwujudnya interaksi sivitas akademik pada Program Studi Spesialis I Bedah Toraks, Kardiak, Dan Vaskular: </p>
                    <ol>
                        <li>Lorem ipsum dolor sit amet consectetur adipisicing elit. Illum nihil facere in impedit fugit odio atque fugiat expedita quam cupiditate.</li>
                        <li>Lorem ipsum dolor sit amet consectetur adipisicing elit. Illum nihil facere in impedit fugit odio atque fugiat expedita quam cupiditate.</li>
                        <li>Lorem ipsum dolor sit amet consectetur adipisicing elit. Illum nihil facere in impedit fugit odio atque fugiat expedita quam cupiditate.</li>
                        <li>Lorem ipsum dolor sit amet consectetur adipisicing elit. Illum nihil facere in impedit fugit odio atque fugiat expedita quam cupiditate.</li>
                        <li>Lorem ipsum dolor sit amet consectetur adipisicing elit. Illum nihil facere in impedit fugit odio atque fugiat expedita quam cupiditate.</li>
                        <li>Lorem ipsum dolor sit amet consectetur adipisicing elit. Illum nihil facere in impedit fugit odio atque fugiat expedita quam cupiditate.</li>
                    </ol>
                </div>
            </div>
        </div>

    </div>
</section>
@endsection