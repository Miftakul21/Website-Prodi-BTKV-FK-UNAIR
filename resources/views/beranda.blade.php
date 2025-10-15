@extends('layouts.layouts-users')

@push('css')
<!-- link css beranda  -->
{!! SEO::generate() !!}
<link rel="stylesheet" href="{{ asset('css/beranda.css') }}">
@endpush

@section('content')
<!-- hero banner section -->
<section class="hero-banner-section">
    <div id="carouselExampleDark" class="carousel carousel-dark slide" data-bs-ride="carousel">
        <div class="carousel-inner">
            <div class="carousel-item active" data-bs-interval="5000">
                <img src="{{ asset('img/hero-banner1.jpg') }}" class="d-block w-100 hero-img" alt="...">
                <div class="carousel-caption">
                    <h5>Selamat Datang</h5>
                    <p>Program Studi Dokter Spesialis <br> Bedah Toraks Kardaik Dan Vaskular</p>
                </div>
                <div class="overlay-full"></div>
            </div>
            <div class="carousel-item" data-bs-interval="5000">
                <img src="{{ asset('img/hero-banner2.jpg') }}" class="d-block w-100 hero-img" alt="...">
                <div class="carousel-caption">
                    <h5>Selamat Datang</h5>
                    <p>Program Studi Dokter Spesialis <br> Bedah Toraks Kardaik Dan Vaskular</p>
                </div>
                <div class="overlay-full"></div>
            </div>
            <div class="carousel-item">
                <img src="{{ asset('img/hero-banner3.jpg') }}" class="d-block w-100 hero-img" alt="...">
                <div class="carousel-caption">
                    <h5>Selamat Datang</h5>
                    <p>Program Studi Dokter Spesialis <br> Bedah Toraks Kardaik Dan Vaskular</p>
                </div>
                <div class="overlay-full"></div>
            </div>
        </div>
        <!-- tombol custom -->
        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleDark" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleDark" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
    </div>
</section>
<!-- end hero banner section -->

<!-- prodi section -->
<section class="prodi-section">
    <div class="container">
        <div class="d-flex justify-content-center align-items-center mb-2">
            <span class="info-section">Program Studi Spesialis</span>
        </div>
        <div class="d-flex justify-content-center align-items-center">
            <p class="title-section">Bedah Toraks, Kardiak, Dan Vaskular</p>
        </div>
        <div class="row my-md-5">
            <div class="col-md-6">
                <p class="description-section">Program Studi Dokter Spesialis Bedah Toraks, Kardiak, dan Vaskular
                    (BTKV) Fakultas Kedokteran Universitas Airlangga Surabaya merupakan program pendidikan dokter
                    spesialis yang berdiri pada tahun 2007. Program Studi BTKV FK UNAIR telah terakreditasi "A"
                    oleh LAM-PTKes berdasarkan Surat Keputusan Nomor: 001/LAM-PTKes/Akr/VI/2021, berlaku sejak
                    tanggal 30 Juni 2021 sampai dengan 30 Juni 2026.</p>
            </div>
            <div class="col-md-6">
                <img src="{{ asset('img/hero-banner1.jpg') }}" alt="gedung-prodi" class="img-fluid rounded">
            </div>
        </div>
    </div>
</section>
<!-- end prodi section -->

<!-- news & event section -->
<section class="news-section">
    <div class="container">
        <div class="d-flex justify-content-center align-items-center mb-2">
            <div class="title-section">Berita Kami</div>
        </div>
        <div class="d-flex justify-content-center align-items-center">
            <p class="description-section">Berita terbaru seputar kegiatan dan informasi kami</p>
        </div>
        <div class="row g-4">
            @forelse($berita as $data)
            <div class="col-12 col-md-6 col-lg-3">
                <a href="/detail-berita/{{$data->berita_slug}}">
                    <div class="card h-100 shadow-sm border-0">
                        <div class="overflow-hidden">
                            <img src="{{ asset('storage/'.$data->berita_thumbnail) }}" class="card-img-top img-zoom" alt="Berita 1">
                        </div>
                        <div class="card-body">
                            <div class="d-flex justify-content-between text-muted small mb-2">
                                <span><i class="bi bi-calendar"></i> {{\Carbon\Carbon::parse($data->berita_date)->format('M d')}}</span>
                                <span><i class="bi bi-eye"></i> {{$data->views_count}}</span>
                            </div>
                            <h5 class="card-title fw-bold text-dark">{{Str::limit($data->berita_title, 90)}}</h5>
                            <p class="card-text text-dark">{{Str::limit(strip_tags($data->berita_content), 200)}}</p>
                        </div>
                    </div>
                </a>
            </div>
            @empty
            <h4 class="text-center">Tidak ada berita terbaru</h4>
            @endforelse
        </div>
        @if($berita->isNotEmpty())
        <div class="d-flex justify-content-center align-items-center">
            <a href="/berita" class="btn btn-primary my-3"><i class="bi bi-newspaper"></i> Berita Lainnya</a>
        </div>
        @endif
    </div>
</section>
<!-- news & event section-->

<!-- pengajar -->
<section class="pengajar-section">
    <div class="container">
        <div class="d-flex justify-content-center align-items-center mb-2">
            <span class="title-section">Tenaga Pengajar Spesialis Kami</span>
        </div>
        <div class="d-flex justify-content-center align-items-center mb-2">
            <p class="description-section" style="text-align: center;">
                Pengajar ahli kami merupakan dokter spesialis dengan pengalaman klinis dan akademis yang luas, yang membimbing <br> Program Pendidikan Dokter Spesialis Bedah Toraks, Kardiak, dan Vaskular
            </p>
        </div>

        <!-- list Deskripsi -->
        <!-- <div class="row">
                <div class="col-md-4 col-12">
                    <div class="card card-pengajar-info mb-3">
                        <div class="card-body">
                            <h3>30+</h3>
                            <span>Pengalaman Spesialis Kedokteran</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 col-12">
                    <div class="card card-pengajar-info mb-3">
                        <div class="card-body">
                            <h3>200+</h3>
                            <span>Publikasi Penelitian</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 col-12">
                    <div class="card card-pengajar-info mb-3">
                        <div class="card-body">
                            <h3>20+</h3>
                            <span>Pengharagaan</span>
                        </div>
                    </div>
                </div>
            </div> -->

        <!-- list pengajar -->
        <div class="row py-3">
            <div class="col-md-3 col-12">
                <a href="">
                    <div class="card shadow-sm border-0 mb-3" style="min-height: 480px;">
                        <!-- Foto Dokter -->
                        <div class="container-image-pengajar">
                            <img src="{{ asset('img/doctor-1.jpeg') }}" class="card-img-top" alt="Profile Image">
                        </div>
                        <div class="card-body shadow-sm">
                            <!-- Nama & Jabatan -->
                            <h5 class="card-title mb-0 text-dark">dr. Imanuel Steven, Sp.BTKV, Subsp.VE</h5>
                            <p class="text-primary fw-semibold mb-2 text-primary">Kepala Program Studi</p>

                            <!-- Pendidikan -->
                            <p class="mb-1 text-dark"><strong>Pendidikan</strong></p>
                            <p class="text-muted">MD, PhD - Harvard Medical School</p>

                            <!-- Publikasi Karya Tulis Ilmiah  & Penghargaan -->
                            <!-- <p class="text-muted mb-0 " style="white-space: nowrap; font-size: 14px;">
                                <i class="bi bi-journal-text"></i> 150+ Karya tulis ilmiah<br>
                                <i class="bi bi-award"></i> 2 Penghargaan Spesialis
                            </p> -->
                        </div>
                    </div>
                </a>
            </div>
            @forelse($pengajar as $data)
            <div class="col-md-3 col-12">
                <a href="/detail-pengajar/{{$data->pengajar_slug}}">
                    <div class="card shadow-sm border-0 mb-3" style="min-height: 480px;">
                        <!-- Foto Dokter -->
                        <div class="container-image-pengajar">
                            <img src="{{ asset('storage/'. $data->pengajar_image) }}" class="card-img-top" alt="Profile Image">
                        </div>
                        <div class="card-body shadow-sm">
                            <!-- Nama & Jabatan -->
                            <h5 class="card-title mb-0 text-dark">{{$data->pengajar_name}}</h5>
                            <p class="text-primary fw-semibold mb-2 text-primary">{{$data->pengajar_posistion}}</p>
                            <!-- Pendidikan -->
                            <p class="mb-1 text-dark"><strong>Pendidikan</strong></p>
                            <p class="text-muted">{{$data->pengajar_pendidikan}}</p>
                            <!-- Publikasi Karya Tulis Ilmiah  & Penghargaan -->
                            <!-- <p class="text-muted mb-0 " style="white-space: nowrap; font-size: 14px;">
                                <i class="bi bi-journal-text"></i> 150+ Karya tulis ilmiah<br>
                                <i class="bi bi-award"></i> 2 Penghargaan Spesialis
                            </p> -->
                        </div>
                    </div>
                </a>
            </div>
            @empty
            <h4 class="text-center">Tidak ada berita terbaru</h4>
            @endforelse
        </div>
        <div class="d-flex justify-content-center align-items-center my-3">
            <a href="/pengajar" class="btn btn-primary"><i class="bi bi-person-workspace me-2"></i>Pengajar Lainnya</a>
        </div>
</section>
<!-- end section pengajar -->

<!-- galeri section -->
<section class="galeri-section">
    <div class="container">
        <div class="d-flex justify-content-center align-items-center mb-2">
            <span class="info-section">Galeri</span>
        </div>
        <div class="d-flex justify-content-center align-items-center">
            <p class="title-section">Fasilitas dan Kegiatan Prodi</p>
        </div>

        <!-- Filter Tombol -->
        <div class="d-flex justify-content-center mt-3 mb-4 flex-wrap">
            <button class="btn btn-outline-primary me-2 mb-2 filter-btn active" data-filter="all" style="color: #fff !important;">
                Semua <span class="badge bg-secondary ms-1">0</span>
            </button>
            <button class="btn btn-outline-primary me-2 mb-2 filter-btn" data-filter="seminar">
                Seminar <span class="badge bg-secondary ms-1">0</span>
            </button>
            <button class="btn btn-outline-primary me-2 mb-2 filter-btn" data-filter="workshop">
                Workshop <span class="badge bg-secondary ms-1">0</span>
            </button>
            <button class="btn btn-outline-primary me-2 mb-2 filter-btn" data-filter="penelitian">
                Penelitian <span class="badge bg-secondary ms-1">0</span>
            </button>
        </div>

        <div class="row g-4 gallery">
            @forelse($galeri as $data)
            <a href="" style="color: unset;">
                <div class="col-12 col-sm-6 col-lg-3 gallery-item" data-cats="{{strtolower($data->galeri_category)}}">
                    <div class="card h-100 shadow-sm">
                        <img src="{{asset('storage/'.$data->galeri_thumbnail)}}" alt="">
                        <div class="card-body text-center">
                            <h6 class="card-title mb-0 fw-bold">{{$data->galeri_title}}</h6>
                        </div>
                    </div>
                </div>
            </a>
            @empty
            <h4 class="text-center">Tidak ada galeri terbaru</h4>
            @endforelse
        </div>
        <div class="d-flex justify-content-center align-items-center my-3">
            <a href="/galeri" class="btn btn-primary"><i class="bi bi-images me-2"></i> Galeri Lainnya</a>
        </div>
    </div>
</section>
<!-- end galeri section -->

<!-- rs section -->
<section class="rs-section">
    <div class="container">
        <div class="d-flex justify-content-center align-items-center mb-2">
            <span class="info-section">Rumah Sakit Jejaring</span>
        </div>
        <div class="d-flex justify-content-center align-items-center">
            <p class="description-section">
                Program kerja sama kami dengan beberapa rumah sakit di berbagai wilayah Indonesia
            </p>
        </div>

        <!-- Slider logo berjalan -->
        <div class="logo-slider">
            <div class="logo-track">
                <div class="logo-item">
                    <img src="{{ asset('img/lg-rsud-soetomo.png') }}" alt="RS Soetomo">
                    <p class="rs-name">RSUD Dr. Soetomo</p>
                    <span class="rs-location">Surabaya</span>
                </div>
                <div class="logo-item">
                    <img src="{{ asset('img/lg-rs-rsua.png') }}" alt="RS UNAIR">
                    <p class="rs-name">RS UNAIR</p>
                    <span class="rs-location">Surabaya</span>
                </div>
                <div class="logo-item">
                    <img src="{{ asset('img/lg-rs-rspal-dr.ramelan.png') }}" alt="RSAL dr. Ramelan">
                    <p class="rs-name">RSAL dr. Ramelan</p>
                    <span class="rs-location">Surabaya</span>
                </div>
                <div class="logo-item">
                    <img src="{{ asset('img/lg-rsd-soebandi.png') }}" alt="RSD dr. Soebandi">
                    <p class="rs-name">RSD dr. Soebandi</p>
                    <span class="rs-location">Jember</span>
                </div>
                <div class="logo-item">
                    <img src="{{ asset('img/lg-rsup-kariadi.png') }}" alt="RSUP Kariadi">
                    <p class="rs-name">RSUP Kariadi</p>
                    <span class="rs-location">Semarang</span>
                </div>
                <div class="logo-item">
                    <img src="{{ asset('img/lg-rsup-sanglah.png') }}" alt="RSUP Sanglah">
                    <p class="rs-name">RSUP Sanglah</p>
                    <span class="rs-location">Bali</span>
                </div>
                <div class="logo-item">
                    <img src="{{ asset('img/lg-rs-wahidin-sudirohusodo.png') }}" alt="RS Wahidin Sudirohusodo">
                    <p class="rs-name">RSUP Dr. Wahidin Sudirohusodo</p>
                    <span class="rs-location">Makassar</span>
                </div>
                <div class="logo-item">
                    <img src="{{ asset('img/lg-rsud-aws.png') }}" alt="RSUD Abdoel Wahab Sjahranie">
                    <p class="rs-name">RSUP Abdoel Wahab Sjahranie</p>
                    <span class="rs-location">Samarinda</span>
                </div>
                <div class="logo-item">
                    <img src="{{ asset('img/lg-rsud-ulin.png') }}" alt="RSUD Ulin Banjarmasin">
                    <p class="rs-name">RSUD Ulin Banjarmasin</p>
                    <span class="rs-location">Banjarmasin</span>
                </div>
                <div class="logo-item">
                    <img src="{{ asset('img/lg-rs-jhc.png') }}" alt="RS JHC">
                    <p class="rs-name">Rumah Sakit Jantung Jakarta</p>
                    <span class="rs-location">Jakarta</span>
                </div>
                <div class="logo-item">
                    <img src="{{ asset('img/lg-rsud-soetomo.png') }}" alt="RS Soetomo">
                    <p class="rs-name">RSUD Dr. Soetomo</p>
                    <span class="rs-location">Surabaya</span>
                </div>
                <div class="logo-item">
                    <img src="{{ asset('img/lg-rs-rsua.png') }}" alt="RS UNAIR">
                    <p class="rs-name">RS UNAIR</p>
                    <span class="rs-location">Surabaya</span>
                </div>
                <div class="logo-item">
                    <img src="{{ asset('img/lg-rs-rspal-dr.ramelan.png') }}" alt="RSAL dr. Ramelan">
                    <p class="rs-name">RSAL dr. Ramelan</p>
                    <span class="rs-location">Surabaya</span>
                </div>
                <div class="logo-item">
                    <img src="{{ asset('img/lg-rsd-soebandi.png') }}" alt="RSD dr. Soebandi">
                    <p class="rs-name">RSD dr. Soebandi</p>
                    <span class="rs-location">Jember</span>
                </div>
                <div class="logo-item">
                    <img src="{{ asset('img/lg-rsup-kariadi.png') }}" alt="RSUP Kariadi">
                    <p class="rs-name">RSUP Kariadi</p>
                    <span class="rs-location">Semarang</span>
                </div>
                <div class="logo-item">
                    <img src="{{ asset('img/lg-rsup-sanglah.png') }}" alt="RSUP Sanglah">
                    <p class="rs-name">RSUP Sanglah</p>
                    <span class="rs-location">Bali</span>
                </div>
                <div class="logo-item">
                    <img src="{{ asset('img/lg-rs-wahidin-sudirohusodo.png') }}" alt="RS Wahidin Sudirohusodo">
                    <p class="rs-name">RSUP Dr. Wahidin Sudirohusodo</p>
                    <span class="rs-location">Makassar</span>
                </div>
                <div class="logo-item">
                    <img src="{{ asset('img/lg-rsud-aws.png') }}" alt="RSUD Abdoel Wahab Sjahranie">
                    <p class="rs-name">RSUP Abdoel Wahab Sjahranie</p>
                    <span class="rs-location">Samarinda</span>
                </div>
                <div class="logo-item">
                    <img src="{{ asset('img/lg-rsud-ulin.png') }}" alt="RSUD Ulin Banjarmasin">
                    <p class="rs-name">RSUD Ulin Banjarmasin</p>
                    <span class="rs-location">Banjarmasin</span>
                </div>
                <div class="logo-item">
                    <img src="{{ asset('img/lg-rs-jhc.png') }}" alt="RS JHC">
                    <p class="rs-name">Rumah Sakit Jantung Jakarta</p>
                    <span class="rs-location">Jakarta</span>
                </div>
                <div class="logo-item">
                    <img src="{{ asset('img/lg-rsud-soetomo.png') }}" alt="RS Soetomo">
                    <p class="rs-name">RSUD Dr. Soetomo</p>
                    <span class="rs-location">Surabaya</span>
                </div>
                <div class="logo-item">
                    <img src="{{ asset('img/lg-rs-rsua.png') }}" alt="RS UNAIR">
                    <p class="rs-name">RS UNAIR</p>
                    <span class="rs-location">Surabaya</span>
                </div>
                <div class="logo-item">
                    <img src="{{ asset('img/lg-rs-rspal-dr.ramelan.png') }}" alt="RSAL dr. Ramelan">
                    <p class="rs-name">RSAL dr. Ramelan</p>
                    <span class="rs-location">Surabaya</span>
                </div>
                <div class="logo-item">
                    <img src="{{ asset('img/lg-rsd-soebandi.png') }}" alt="RSD dr. Soebandi">
                    <p class="rs-name">RSD dr. Soebandi</p>
                    <span class="rs-location">Jember</span>
                </div>
                <div class="logo-item">
                    <img src="{{ asset('img/lg-rsup-kariadi.png') }}" alt="RSUP Kariadi">
                    <p class="rs-name">RSUP Kariadi</p>
                    <span class="rs-location">Semarang</span>
                </div>
                <div class="logo-item">
                    <img src="{{ asset('img/lg-rsup-sanglah.png') }}" alt="RSUP Sanglah">
                    <p class="rs-name">RSUP Sanglah</p>
                    <span class="rs-location">Bali</span>
                </div>
                <div class="logo-item">
                    <img src="{{ asset('img/lg-rs-wahidin-sudirohusodo.png') }}" alt="RS Wahidin Sudirohusodo">
                    <p class="rs-name">RSUP Dr. Wahidin Sudirohusodo</p>
                    <span class="rs-location">Makassar</span>
                </div>
                <div class="logo-item">
                    <img src="{{ asset('img/lg-rsud-aws.png') }}" alt="RSUD Abdoel Wahab Sjahranie">
                    <p class="rs-name">RSUP Abdoel Wahab Sjahranie</p>
                    <span class="rs-location">Samarinda</span>
                </div>
                <div class="logo-item">
                    <img src="{{ asset('img/lg-rsud-ulin.png') }}" alt="RSUD Ulin Banjarmasin">
                    <p class="rs-name">RSUD Ulin Banjarmasin</p>
                    <span class="rs-location">Banjarmasin</span>
                </div>
                <div class="logo-item">
                    <img src="{{ asset('img/lg-rs-jhc.png') }}" alt="RS JHC">
                    <p class="rs-name">Rumah Sakit Jantung Jakarta</p>
                    <span class="rs-location">Jakarta</span>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- end rs section -->

@endsection

@push('js')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // scroll ke atas saat diklik
        backToTop.addEventListener("click", function() {
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        });

        const filters = document.querySelectorAll('.filter-btn');
        const cards = document.querySelectorAll('.gallery-item');

        // Helper: ambil kategori dari card (array)
        const cardHasCategory = (card, filter) => {
            const cats = (card.dataset.cats || '').trim().split(/\s+/).filter(Boolean);
            return cats.includes(filter);
        };

        // Update badge counts pada tombol berdasarkan jumlah kartu
        function updateCounts() {
            filters.forEach(btn => {
                const filter = btn.dataset.filter;
                const badge = btn.querySelector('.badge');
                if (!badge) return;
                if (filter === 'all') {
                    badge.textContent = cards.length;
                } else {
                    const count = Array.from(cards).filter(c => cardHasCategory(c, filter)).length;
                    badge.textContent = count;
                }
            });
        }

        // Set behavior click pada tombol filter
        filters.forEach(btn => {
            btn.addEventListener('click', function() {
                // ubah visual aktif
                filters.forEach(b => {
                    b.classList.remove('btn-primary');
                    b.classList.add('btn-outline-primary');
                    b.setAttribute('aria-pressed', 'false');
                });
                this.classList.remove('btn-outline-primary');
                this.classList.add('btn-primary');
                this.setAttribute('aria-pressed', 'true');

                const filter = this.dataset.filter;

                // lakukan filtering: tampilkan / sembunyikan kartu
                if (filter === 'all') {
                    cards.forEach(c => c.classList.remove('d-none'));
                } else {
                    cards.forEach(c => {
                        if (cardHasCategory(c, filter)) {
                            c.classList.remove('d-none');
                        } else {
                            c.classList.add('d-none');
                        }
                    });
                }
            });
        });

        // Inisialisasi: hitung badge counts
        updateCounts();
    });
</script>
@endpush