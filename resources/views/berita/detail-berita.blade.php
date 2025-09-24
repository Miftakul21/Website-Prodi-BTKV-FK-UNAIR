@extends('layouts.layouts-users')
@push('css')
<!-- link css -->
<link rel="stylesheet" href="{{ asset('css/berita.css') }}">
@endpush

@section('content')
<section class="news-detail-section">
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
                                    <div><i class="bi bi-person"></i> Administrator</div>
                                    <div><i class="bi bi-calendar"></i> September, 12 2025</div>
                                </div>
                                <div>
                                    <div><i class="bi bi-clock"></i> 5 menit</div>
                                    <div><i class="bi bi-eye"></i> 20 dilihat</div>
                                </div>
                            </div>
                        </div>
                        <h1 class="title-news">Breakthrough Research in Heart Valve Regeneration Published</h1>
                        <div class="d-flex justify-content-between align-items-center gap-2" style="width: 160px;">
                            <span class="category">Berita</span>
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
                                        <a href="https://twitter.com/intent/tweet?url={{ urlencode(request()->fullUrl()) }}&text={{ urlencode($article->title ?? '') }}" target="_blank" class="btn btn-outline-info btn-sm text-info" title="Twitter">
                                            <i class="bi bi-twitter"></i>
                                        </a>
                                        <!-- WhatsApp -->
                                        <a href="https://wa.me/?text={{ urlencode(($article->title ?? '') . ' ' . request()->fullUrl()) }}" target="_blank" class="btn btn-outline-success btn-sm text-success" title="WhatsApp">
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
                            <img src="{{ asset('img/hero-banner1.jpg') }}" alt="gambar-berita" class="image-news img-fluid">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="content-news col-12">
            <b>Where does it come from?</b>
            <br>
            Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of "de Finibus Bonorum et Malorum" (The Extremes of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very popular during the Renaissance. The first line of Lorem Ipsum, "Lorem ipsum dolor sit amet..", comes from a line in section 1.10.32.
            <img src="{{ asset('img/hero-banner1.jpg') }}" alt="">
            The standard chunk of Lorem Ipsum used since the 1500s is reproduced below for those interested. Sections 1.10.32 and 1.10.33 from "de Finibus Bonorum et Malorum" by Cicero are also reproduced in their exact original form, accompanied by English versions from the 1914 translation by H. Rackham.
        </div>
    </div>
</section>

<!-- pagination section -->
<section class="pagination-news-detail mb-3">
    <div class="container">
        <div class="d-flex justify-content-center align-items-center mb-3">
            <span class="text-muted text-center fw-bold" style="font-size: 12px;">Berita Lainnya</span>
        </div>
        <div class="d-flex flex-column flex-md-row justify-content-center flex-wrap gap-1">
            <div class="card card-hover">
                <div class="card-body p-3">
                    <h6 class="date-news-pagination">September, 22 2025</h6>
                    <h3 class="title-news-pagination">
                        Breakthrough Research in Heart Valve Regeneration Published
                    </h3>
                </div>
            </div>
            <div class="card card-hover">
                <div class="card-body p-3">
                    <h6 class="date-news-pagination">September, 22 2025</h6>
                    <h3 class="title-news-pagination">
                        Breakthrough Research in Heart Valve Regeneration Published
                    </h3>
                </div>
            </div>
            <div class="card card-hover">
                <div class="card-body p-3">
                    <h6 class="date-news-pagination">September, 22 2025</h6>
                    <h3 class="title-news-pagination">
                        Breakthrough Research in Heart Valve Regeneration Published
                    </h3>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- end pagination section -->
@endsection