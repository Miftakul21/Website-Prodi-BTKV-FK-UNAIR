@extends('layouts.layouts-users')
@push('css')
<link rel="stylesheet" href="{{asset('css/akademik-yudisium.css')}}">
@endpush

@section('content')
<section class="yudisium-section">
    <div class="container">
        <a href="{{url()->previous()}}" class="text-muted button-back"><i class="bi bi-arrow-left me-2">Kembalid</i></a>
        <div class="d-felex my-3">
            <span class="info-section">Informasi Yudisium</span>
        </div>

        <div class="row">
            <div class="col-xl-8 col-md-8 col-12">
                <div class="container-content">
                    <div>
                        {!! $yudisium ?? '' !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection