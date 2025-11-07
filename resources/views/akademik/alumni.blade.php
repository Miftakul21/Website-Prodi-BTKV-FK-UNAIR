@extends('layouts.layouts-users')
@push('css')
<link rel="stylesheet" href="{{asset('css/akademik-alumni.css')}}">
@endpush

@section('content')
<section class="alumni-section">
    <div class="container">
        <a href="{{url()->previous()}}" class="text-muted button-back"><i class="bi bi-arrow-left me-2"></i> Kembali</a>

        <div class="d-flex  my-3">
            <span class="info-section">Alumni Program Studi Spesialis I <br> Bedah Toraks, Kardiak, Dan Vaskular Fakultas Kedokteran Universias Airlangga</span>
        </div>

        <div class="row">
            <div class="col-lg-8 col-md-12 col-12">
                <div class="container-content">
                    {!! $alumni !!}
                    @if($file) {
                    <a href="" class="text-primary mt-3">Link Kelulusan Alumni Program Studi Spesialis Bedah Toraks, Kardiak, Dan Vaskular FK Unair</a>
                    }
                    @endif
                </div>
            </div>
        </div>

    </div>
</section>
@endsection