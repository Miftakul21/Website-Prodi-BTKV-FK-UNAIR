@extends('layouts.layouts-users')

@push('css')
<!-- link css profile  -->
<link rel="stylesheet" href="{{ asset('css/profile.css') }}">
@endpush

@section('content')
<section class="profile-section">
    <div class="container">
        <a href="{{ url()->previous() }}" class="text-muted button-back"><i class="bi bi-arrow-left me-2"></i> Kembali</a>

        <div class="card shadow-sm bg-transparent mt-3">
            <div class="card-body">
                <div class="row my-md-6 my-3">
                    <div class="col-xl-6 col-md-6 col-12 order-2 order-md-1 my-md-none my-3 py-xl-5">
                        <h1 class="profile-name">dr. Imanuel Steven, Sp.BTKV, Subsp.VE</h1>
                        <h3 class="profile-position text-primary">Kepala Program Studi</h3>
                        <h6 class="profile-long-experiance"><i class="bi bi-person-lines-fill"></i> 25+ Tahun Pengalaman</h6>
                        <div class="container-info-education">
                            <p><i class="bi bi-mortarboard"></i> Pendidikan</p>
                            <p>MD, PhD - Harvard Medical School</p>
                        </div>
                    </div>
                    <div class="col-xl-5 col-md-6 col-12 offset-xl-1 order-1 order-md-2">
                        <div class="container-image-profile">
                            <img src="{{ asset('img/doctor-1.jpeg') }}" alt="foto-dokter" class="image-profile">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- informasi lainnya -->
        <div class="row my-3">
            <div class="col-md-6 col-12">
                <div class="card card-hover border border-primary p-2 mb-3 border-opacity-50">
                    <div class="card-body">
                        <h6 class="fw-semibold biografi">Biografi</h6>
                        <p class="deskripsi-biografi">
                            Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-12">
                <div class="card card-hover border border-primary p-2 mb-3 border-opacity-50">
                    <div class="card-body">
                        <h6 class="fw-semibold biografi"><i class="fas fa-microscope me-1"></i> Minat Penelitian</h6>
                        <p class="deskripsi-biografi">
                            Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-12">
                <div class="card card-hover border border-primary p-2 mb-3 border-opacity-50">
                    <div class="card-body">
                        <h6 class="fw-semibold kepentingan-klinis"> Kepentingan Klinis</h6>

                        <ul class="list-kepentingan-klinis">
                            <li>Minimally Invasive Surgery</li>
                            <li>Complex Valve Repair</li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-12">
                <div class="card card-hover border border-primary p-2 mb-3 border-opacity-50">
                    <div class="card-body">
                        <h6 class="fw-semibold publikasi-penelitian"><i class="bi bi-book"></i> Publikasi Penelitian Terbaru</h6>
                        <div class="container-publikasi-penelitan mt-3">
                            <div class="container-publikasi mb-2">
                                <h5>Minimally Invasive Mitral Valve Repair: 10-Year Experience</h5>
                                <p class="text-muted">Journal of Cardiac Surgery, 2024</p>
                            </div>
                            <div class="container-publikasi mb-2">
                                <h5>Minimally Invasive Mitral Valve Repair: 10-Year Experience</h5>
                                <p class="text-muted">Journal of Cardiac Surgery, 2024</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12">
                <div class="card card-hover border border-primary p-2 mb-3 border-opacity-50">
                    <div class="card-body">
                        <h6 class="fw-semibold publikasi-penelitian"><i class="bi bi-award"></i> Prestasi dan Penghargaan</h6>
                        <div class="row mt-2">
                            <div class="col-md-6 col-12 mb-3">
                                <i class="bi bi-award"></i> American Heart Association Distinguished Scientist Award
                            </div>
                            <div class="col-md-6 col-12 mb-3">
                                <i class="bi bi-award"></i> American Heart Association Distinguished Scientist Award
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection