@extends('layouts.layouts-users')
@push('css')
@endpush
@section('content')
<section class="galeri-detail-section">
    <div class="container">
        <a href="{{url()->previous()}}" class="text-muted button-back"><i class="bi bi-arrow-left me-2"></i> Kembali</a>
    </div>
</section>

@endsection