@extends('layouts.layouts-users')
@section('title', $artikel_title)
@push('css')
<!-- link css -->
{!! SEO::generate() !!}
<link rel="stylesheet" href="{{ asset('css/informasi-prestasi.css') }}">
@endpush

@section('content')
<section class="prestasi-section">
    <div class="container">
        <a href="{{ url()->previous() }}" class="text-muted button-back"><i class="bi bi-arrow-left me-2"></i> Kembali</a>
        <div class="card shadow-sm my-md-3 my-3">
            <div class="card-body">
                <div class="row">
                    <!-- information -->
                    <div class="col-md-6 order-1 col-12 mb-3">
                        <div class="container-informasi">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <div class="artikel-editor"><i class="bi bi-person"></i> {{$artikel_editor }}</div>
                                    <div class="artikel-date"><i class="bi bi-calendar"></i> {{\Carbon\Carbon::parse($artikel_date)->format('M, d Y')}}</div>
                                </div>
                                <div>
                                    <div class="artikel-views"><i class="bi bi-eye"></i> {{$views_count}} dibaca</div>
                                </div>
                            </div>
                        </div>
                        <h1 class="title-prestasi">{{$artikel_title}}</h1>
                        <div class="d-flex justify-content-between align-items-center gap-2" style="width: 160px;">
                            <span class="category">{{$artikel_category}}</span>
                            <!-- Share Button Horizontal -->
                            <div class="dropdown d-inline-block">
                                <button class="btn btn-capsule btn-outline-primary btn-sm dropdown-toggle no-caret" type="button" id="shareDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="bi bi-share me-1"></i> Share
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end p-2" aria-labelledby="shareDropdown" style="min-width: auto;">
                                    <div class="d-flex gap-2 px-2">
                                        <!-- Facebook -->
                                        <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(request()->fullUrl()) }}" target="_blank" class="btn btn-outline-primary btn-sm" title="Facebook">
                                            <i class="bi bi-facebook"></i>
                                        </a>
                                        <!-- Twitter / X -->
                                        <a href="https://twitter.com/intent/tweet?url={{ urlencode(request()->fullUrl()) }}&text={{ urlencode($prestasi_title ?? '') }}" target="_blank" class="btn btn-outline-info btn-sm text-info" title="Twitter">
                                            <i class="bi bi-twitter"></i>
                                        </a>
                                        <!-- WhatsApp -->
                                        <a href="https://wa.me/?text={{ urlencode(($prestasi_title ?? '') . ' ' . request()->fullUrl()) }}" target="_blank" class="btn btn-outline-success btn-sm text-success" title="WhatsApp">
                                            <i class="bi bi-whatsapp"></i>
                                        </a>
                                        <!-- Instagram -->
                                        <a href="https://www.instagram.com/?url={{ urlencode(request()->fullUrl()) }}" target="_blank" class="btn btn-outline-danger btn-sm text-danger" title="Instagram">
                                            <i class="bi bi-instagram"></i>
                                        </a>
                                    </div>
                                </ul>
                            </div>
                        </div>

                    </div>
                    <!-- thubmnail -->
                    <div class="col-md-6 order-2 col-12 mt-md-none mt-xl-none">
                        <div class="container-thubmnail-image">
                            <img src="{{ asset('storage/'.$artikel_thumbnail) }}" alt="gambar-artikel" class="image-pretasi img-fluid">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="content-prestasi col-12">
            {!! $artikel_content !!}
        </div>
    </div>
</section>

<!-- pagination section -->
<section class="pagination-prestasi mb-3">
    <div class="container">
        <div class="d-flex justify-content-center align-items-center mb-3">
            <span class="text-muted text-center fw-bold" style="font-size: 12px;">Artikel Prestasi Lainnya</span>
        </div>
        <div class="d-flex flex-column flex-md-row justify-content-center flex-wrap gap-1">
            @forelse($artikel_lainnya as $artikel)
            <div class="card card-hover">
                <div class="card-body p-3">
                    <h6 class="date-artikel-pagination">{{\Carbon\Carbon::parse($artkel->artikel_date)->format('M, d Y')}}</h6>
                    <h3 class="title-artikel-pagination">
                        {{Str::limit($artikel->artikel_title), 90}}
                    </h3>
                </div>
            </div>
            @empty
            @endforelse
        </div>
    </div>
</section>
<!-- end pagination section -->
@endsection