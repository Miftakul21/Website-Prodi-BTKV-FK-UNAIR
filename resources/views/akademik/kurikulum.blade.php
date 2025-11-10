@extends('layouts.layouts-users')
@push('css')
<link rel="stylesheet" href="{{asset('css/akademik-kurikulum.css')}}">
@endpush
@section('content')
<section class="kurikulum-section">
    <div class="container">
        <a href="{{url()->previous()}}" class="text-muted button-back"><i class="bi bi-arrow-left me-2"></i> Kembali</a>
        <div class="d-flex mb-3 mt-3">
            <span class="info-section">Kurikulum Akademik</span>
        </div>
        <div class="row">
            <span class="my-3">Kurikulum dapat dilihat pada link berikut ini: <a href="https://docs.google.com/spreadsheets/d/1Rwdjc3Puer4yFfepcdDDjbzrSIaWdotCL8CBt2gAocs/edit?usp=sharing">Kurikulum Akademik</a></span>
            <div class="col-lg-8 col-md-8 col-12">
                <!-- Halaman Kurikulum Ini Harus Image Sih -->
                <div style="width: 100%;">
                    <img src="{{asset('img/kurikulum.jpg')}}" alt="">
                </div>
            </div>
        </div>
</section>
@endsection