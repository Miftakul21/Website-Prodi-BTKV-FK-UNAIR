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
            <div class="col-lg-8 col-md-8 col-12">
                <div class="container-content">
                    {!! $kurikulum !!}
                </div>
            </div>
        </div>
</section>
@endsection