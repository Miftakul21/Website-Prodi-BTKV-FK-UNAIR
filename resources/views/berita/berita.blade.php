@extends('layouts.layouts-users')
@push('css')
<!-- link css berita -->
<link rel="stylesheet" href="{{ asset('css/berita.css') }}">
@endpush

@section('content')
<!-- news & event section -->
<section class="news-section">
    <div class="container">
        <a href="{{ url()->previous() }}" class="text-muted button-back"><i class="bi bi-arrow-left me-2"></i> Kembali</a>

        <div class="d-flex justify-content-center align-items-center mb-2">
            <div class="title-section">Berita Kami</div>
        </div>
        <div class="d-flex justify-content-center align-items-center">
            <p class="description-section">Berita terbaru seputar kegiatan dan informasi kami</p>
        </div>

        <div class="row g-4">
            <!-- Card 1 -->
            <div class="col-12 col-md-6 col-lg-3">
                <a href="">
                    <div class="card h-100 shadow-sm border-0">
                        <div class="overflow-hidden">
                            <img src="{{ asset('img/hero-banner1.jpg') }}" class="card-img-top img-zoom" alt="Berita 1">
                        </div>
                        <div class="card-body">
                            <div class="d-flex justify-content-between text-muted small mb-2">
                                <span><i class="bi bi-calendar"></i> Mar 10</span>
                                <span><i class="bi bi-clock"></i> 3 min read</span>
                                <span><i class="bi bi-eye"></i> 1.5k</span>
                            </div>
                            <h5 class="card-title fw-bold text-dark">International CTVS Conference 2024: Innovation in Surgery</h5>
                            <p class="card-text text-dark">Join world-renowned surgeons and researchers for three days of cutting-edge presentations, live surgical demonstrations, and networking opportunities.</p>
                        </div>
                    </div>
                </a>
            </div>

            <!-- Card 2 -->
            <div class="col-12 col-md-6 col-lg-3">
                <a href="">
                    <div class="card h-100 shadow-sm border-0">
                        <div class="overflow-hidden">
                            <img src="{{ asset('img/hero-banner2.jpg') }}" class="card-img-top img-zoom" alt="Berita 2">
                        </div>
                        <div class="card-body">
                            <div class="d-flex justify-content-between text-muted small mb-2">
                                <span><i class="bi bi-calendar"></i> Feb 22</span>
                                <span><i class="bi bi-clock"></i> 4 min read</span>
                                <span><i class="bi bi-eye"></i> 980</span>
                            </div>
                            <h5 class="card-title fw-bold text-dark">Workshop Bedah Kardiak Nasional 2024</h5>
                            <p class="card-text text-dark">Pelatihan intensif untuk dokter spesialis dengan simulasi langsung teknik operasi terbaru di bidang bedah kardiak.</p>
                        </div>
                    </div>
                </a>
            </div>

            <!-- Card 3 -->
            <div class="col-12 col-md-6 col-lg-3">
                <a href="">
                    <div class="card h-100 shadow-sm border-0">
                        <div class="overflow-hidden">
                            <img src="{{ asset('img/hero-banner1.jpg') }}" class="card-img-top img-zoom" alt="Berita 3">
                        </div>
                        <div class="card-body">
                            <div class="d-flex justify-content-between text-muted small mb-2">
                                <span><i class="bi bi-calendar"></i> Jan 15</span>
                                <span><i class="bi bi-clock"></i> 2 min read</span>
                                <span><i class="bi bi-eye"></i> 720</span>
                            </div>
                            <h5 class="card-title fw-bold text-dark">Kolaborasi BTKV Unair dengan Rumah Sakit Jejaring</h5>
                            <p class="card-text text-dark">Kerja sama strategis untuk memperluas akses layanan dan pengembangan kompetensi dalam bidang bedah toraks, kardiak, dan vaskular.</p>
                        </div>
                    </div>
                </a>
            </div>

            <!-- Card 4 -->
            <div class="col-12 col-md-6 col-lg-3">
                <a href="">
                    <div class="card h-100 shadow-sm border-0">
                        <div class="overflow-hidden">
                            <img src="{{ asset('img/hero-banner2.jpg') }}" class="card-img-top img-zoom" alt="Berita 4">
                        </div>
                        <div class="card-body">
                            <div class="d-flex justify-content-between text-muted small mb-2">
                                <span><i class="bi bi-calendar"></i> Dec 05</span>
                                <span><i class="bi bi-clock"></i> 5 min read</span>
                                <span><i class="bi bi-eye"></i> 2.1k</span>
                            </div>
                            <h5 class="card-title fw-bold text-dark">Seminar Internasional: Advances in Thoracic Surgery</h5>
                            <p class="card-text text-dark">Diskusi akademik dengan pembicara internasional mengenai perkembangan terbaru dalam prosedur bedah toraks.</p>
                        </div>
                    </div>
                </a>
            </div>
            <!-- Card 1 -->
            <div class="col-12 col-md-6 col-lg-3">
                <a href="">
                    <div class="card h-100 shadow-sm border-0">
                        <div class="overflow-hidden">
                            <img src="{{ asset('img/hero-banner1.jpg') }}" class="card-img-top img-zoom" alt="Berita 1">
                        </div>
                        <div class="card-body">
                            <div class="d-flex justify-content-between text-muted small mb-2">
                                <span><i class="bi bi-calendar"></i> Mar 10</span>
                                <span><i class="bi bi-clock"></i> 3 min read</span>
                                <span><i class="bi bi-eye"></i> 1.5k</span>
                            </div>
                            <h5 class="card-title fw-bold text-dark">International CTVS Conference 2024: Innovation in Surgery</h5>
                            <p class="card-text text-dark">Join world-renowned surgeons and researchers for three days of cutting-edge presentations, live surgical demonstrations, and networking opportunities.</p>
                        </div>
                    </div>
                </a>
            </div>

            <!-- Card 2 -->
            <div class="col-12 col-md-6 col-lg-3">
                <a href="">
                    <div class="card h-100 shadow-sm border-0">
                        <div class="overflow-hidden">
                            <img src="{{ asset('img/hero-banner2.jpg') }}" class="card-img-top img-zoom" alt="Berita 2">
                        </div>
                        <div class="card-body">
                            <div class="d-flex justify-content-between text-muted small mb-2">
                                <span><i class="bi bi-calendar"></i> Feb 22</span>
                                <span><i class="bi bi-clock"></i> 4 min read</span>
                                <span><i class="bi bi-eye"></i> 980</span>
                            </div>
                            <h5 class="card-title fw-bold text-dark">Workshop Bedah Kardiak Nasional 2024</h5>
                            <p class="card-text text-dark">Pelatihan intensif untuk dokter spesialis dengan simulasi langsung teknik operasi terbaru di bidang bedah kardiak.</p>
                        </div>
                    </div>
                </a>
            </div>

            <!-- Card 3 -->
            <div class="col-12 col-md-6 col-lg-3">
                <a href="">
                    <div class="card h-100 shadow-sm border-0">
                        <div class="overflow-hidden">
                            <img src="{{ asset('img/hero-banner1.jpg') }}" class="card-img-top img-zoom" alt="Berita 3">
                        </div>
                        <div class="card-body">
                            <div class="d-flex justify-content-between text-muted small mb-2">
                                <span><i class="bi bi-calendar"></i> Jan 15</span>
                                <span><i class="bi bi-clock"></i> 2 min read</span>
                                <span><i class="bi bi-eye"></i> 720</span>
                            </div>
                            <h5 class="card-title fw-bold text-dark">Kolaborasi BTKV Unair dengan Rumah Sakit Jejaring</h5>
                            <p class="card-text text-dark">Kerja sama strategis untuk memperluas akses layanan dan pengembangan kompetensi dalam bidang bedah toraks, kardiak, dan vaskular.</p>
                        </div>
                    </div>
                </a>
            </div>

            <!-- Card 4 -->
            <div class="col-12 col-md-6 col-lg-3">
                <a href="">
                    <div class="card h-100 shadow-sm border-0">
                        <div class="overflow-hidden">
                            <img src="{{ asset('img/hero-banner2.jpg') }}" class="card-img-top img-zoom" alt="Berita 4">
                        </div>
                        <div class="card-body">
                            <div class="d-flex justify-content-between text-muted small mb-2">
                                <span><i class="bi bi-calendar"></i> Dec 05</span>
                                <span><i class="bi bi-clock"></i> 5 min read</span>
                                <span><i class="bi bi-eye"></i> 2.1k</span>
                            </div>
                            <h5 class="card-title fw-bold text-dark">Seminar Internasional: Advances in Thoracic Surgery</h5>
                            <p class="card-text text-dark">Diskusi akademik dengan pembicara internasional mengenai perkembangan terbaru dalam prosedur bedah toraks.</p>
                        </div>
                    </div>
                </a>
            </div>
        </div>

        <div class="d-flex justify-content-center align-items-center">
            <a href="" class="btn btn-primary my-5 text-priamry">Muat Lebih Banyak</a>
        </div>
    </div>
</section>
<!-- news & event section-->
@endsection