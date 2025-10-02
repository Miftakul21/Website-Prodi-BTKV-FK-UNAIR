@extends('layouts.layouts-users')
@push('css')
<!-- link css pengajar  -->
<link rel="stylesheet" href="{{ asset('css/pengajar.css') }}">
@endpush
@section('content')
<!-- pengajar -->
<section class="pengajar-section">
    <div class="container">
        <a href="{{ url()->previous() }}" class="text-muted button-back"><i class="bi bi-arrow-left me-2"></i> Kembali</a>

        <div class="d-flex justify-content-center align-items-center mb-2">
            <span class="title-section">Tenaga Pengajar Spesialis Kami</span>
        </div>
        <!-- <div class="d-flex justify-content-center align-items-center mb-2">
                <p class="description-section" style="text-align: center;">
                    Pengajar ahli kami merupakan dokter spesialis dengan pengalaman klinis dan akademis yang luas, yang membimbing <br> Program Pendidikan Dokter Spesialis Bedah Toraks, Kardiak, dan Vaskular
                </p>
            </div> -->

        <!-- list pengajar -->
        <div class="row py-3">
            <div class="col-md-3 col-12">
                <a href="/profile/pengajar">
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
                            <p class="text-muted mb-0 " style="white-space: nowrap; font-size: 14px;">
                                <i class="bi bi-journal-text"></i> 150+ Karya tulis ilmiah<br>
                                <i class="bi bi-award"></i> 2 Penghargaan Spesialis
                            </p>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-md-3 col-12">
                <a href="/profile/pengajar">
                    <div class="card shadow-sm border-0 mb-3" style="min-height: 480px;">
                        <!-- Foto Dokter -->
                        <div class="container-image-pengajar">
                            <img src="{{ asset('img/doctor-2.jpeg') }}" class="card-img-top" alt="Profile Image">
                        </div>
                        <div class="card-body shadow-sm">
                            <!-- Nama & Jabatan -->
                            <h5 class="card-title mb-0 text-dark">dr. Linda Permata Sari, Sp.BTKV, Subsp.VE</h5>
                            <p class="text-primary fw-semibold mb-2 text-primary">Kepala Program Studi</p>

                            <!-- Pendidikan -->
                            <p class="mb-1 text-dark"><strong>Pendidikan</strong></p>
                            <p class="text-muted">MD, PhD - Harvard Medical School</p>

                            <!-- Publikasi Karya Tulis Ilmiah  & Penghargaan -->
                            <p class="text-muted mb-0 " style="white-space: nowrap; font-size: 14px;">
                                <i class="bi bi-journal-text"></i> 150+ Karya tulis ilmiah<br>
                                <i class="bi bi-award"></i> 2 Penghargaan Spesialis
                            </p>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-md-3 col-12">
                <a href="/profile/pengajar">
                    <div class="card shadow-sm border-0 mb-3" style="min-height: 480px;">
                        <!-- Foto Dokter -->
                        <div class="container-image-pengajar">
                            <img src="{{ asset('img/doctor-3.jpeg') }}" class="card-img-top" alt="Profile Image">
                        </div>
                        <div class="card-body shadow-sm">
                            <!-- Nama & Jabatan -->
                            <h5 class="card-title mb-0 text-dark">dr. Miyamura Satoshi, Sp.BTKV, Subsp.VE</h5>
                            <p class="text-primary fw-semibold mb-2 text-primary">Kepala Program Studi</p>

                            <!-- Pendidikan -->
                            <p class="mb-1 text-dark"><strong>Pendidikan</strong></p>
                            <p class="text-muted">MD, PhD - Harvard Medical School</p>

                            <!-- Publikasi Karya Tulis Ilmiah  & Penghargaan -->
                            <p class="text-muted mb-0 " style="white-space: nowrap; font-size: 14px;">
                                <i class="bi bi-journal-text"></i> 150+ Karya tulis ilmiah<br>
                                <i class="bi bi-award"></i> 2 Penghargaan Spesialis
                            </p>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-md-3 col-12">
                <a href="/profile/pengajar">
                    <div class="card shadow-sm border-0 mb-3" style="min-height: 480px;">
                        <!-- Foto Dokter -->
                        <div class="container-image-pengajar">
                            <img src="{{ asset('img/doctor-4.jpeg') }}" class="card-img-top" alt="Profile Image">
                        </div>
                        <div class="card-body shadow-sm">
                            <!-- Nama & Jabatan -->
                            <h5 class="card-title mb-0 text-dark">dr. Jesika Karoline, Sp.BTKV, Subsp.VE</h5>
                            <p class="text-primary fw-semibold mb-2 text-primary">Kepala Program Studi</p>

                            <!-- Pendidikan -->
                            <p class="mb-1 text-dark"><strong>Pendidikan</strong></p>
                            <p class="text-muted">MD, PhD - Harvard Medical School</p>

                            <!-- Publikasi Karya Tulis Ilmiah  & Penghargaan -->
                            <p class="text-muted mb-0 " style="white-space: nowrap; font-size: 14px;">
                                <i class="bi bi-journal-text"></i> 150+ Karya tulis ilmiah<br>
                                <i class="bi bi-award"></i> 2 Penghargaan Spesialis
                            </p>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-md-3 col-12">
                <a href="/profile/pengajar">
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
                            <p class="text-muted mb-0 " style="white-space: nowrap; font-size: 14px;">
                                <i class="bi bi-journal-text"></i> 150+ Karya tulis ilmiah<br>
                                <i class="bi bi-award"></i> 2 Penghargaan Spesialis
                            </p>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-md-3 col-12">
                <a href="/profile/pengajar">
                    <div class="card shadow-sm border-0 mb-3" style="min-height: 480px;">
                        <!-- Foto Dokter -->
                        <div class="container-image-pengajar">
                            <img src="{{ asset('img/doctor-2.jpeg') }}" class="card-img-top" alt="Profile Image">
                        </div>
                        <div class="card-body shadow-sm">
                            <!-- Nama & Jabatan -->
                            <h5 class="card-title mb-0 text-dark">dr. Linda Permata Sari, Sp.BTKV, Subsp.VE</h5>
                            <p class="text-primary fw-semibold mb-2 text-primary">Kepala Program Studi</p>

                            <!-- Pendidikan -->
                            <p class="mb-1 text-dark"><strong>Pendidikan</strong></p>
                            <p class="text-muted">MD, PhD - Harvard Medical School</p>

                            <!-- Publikasi Karya Tulis Ilmiah  & Penghargaan -->
                            <p class="text-muted mb-0 " style="white-space: nowrap; font-size: 14px;">
                                <i class="bi bi-journal-text"></i> 150+ Karya tulis ilmiah<br>
                                <i class="bi bi-award"></i> 2 Penghargaan Spesialis
                            </p>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-md-3 col-12">
                <a href="/profile/pengajar">
                    <div class="card shadow-sm border-0 mb-3" style="min-height: 480px;">
                        <!-- Foto Dokter -->
                        <div class="container-image-pengajar">
                            <img src="{{ asset('img/doctor-3.jpeg') }}" class="card-img-top" alt="Profile Image">
                        </div>
                        <div class="card-body shadow-sm">
                            <!-- Nama & Jabatan -->
                            <h5 class="card-title mb-0 text-dark">dr. Miyamura Satoshi, Sp.BTKV, Subsp.VE</h5>
                            <p class="text-primary fw-semibold mb-2 text-primary">Kepala Program Studi</p>

                            <!-- Pendidikan -->
                            <p class="mb-1 text-dark"><strong>Pendidikan</strong></p>
                            <p class="text-muted">MD, PhD - Harvard Medical School</p>

                            <!-- Publikasi Karya Tulis Ilmiah  & Penghargaan -->
                            <p class="text-muted mb-0 " style="white-space: nowrap; font-size: 14px;">
                                <i class="bi bi-journal-text"></i> 150+ Karya tulis ilmiah<br>
                                <i class="bi bi-award"></i> 2 Penghargaan Spesialis
                            </p>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-md-3 col-12">
                <a href="/profile/pengajar">
                    <div class="card shadow-sm border-0 mb-3" style="min-height: 480px;">
                        <!-- Foto Dokter -->
                        <div class="container-image-pengajar">
                            <img src="{{ asset('img/doctor-4.jpeg') }}" class="card-img-top" alt="Profile Image">
                        </div>
                        <div class="card-body shadow-sm">
                            <!-- Nama & Jabatan -->
                            <h5 class="card-title mb-0 text-dark">dr. Jesika Karoline, Sp.BTKV, Subsp.VE</h5>
                            <p class="text-primary fw-semibold mb-2 text-primary">Kepala Program Studi</p>

                            <!-- Pendidikan -->
                            <p class="mb-1 text-dark"><strong>Pendidikan</strong></p>
                            <p class="text-muted">MD, PhD - Harvard Medical School</p>

                            <!-- Publikasi Karya Tulis Ilmiah  & Penghargaan -->
                            <p class="text-muted mb-0 " style="white-space: nowrap; font-size: 14px;">
                                <i class="bi bi-journal-text"></i> 150+ Karya tulis ilmiah<br>
                                <i class="bi bi-award"></i> 2 Penghargaan Spesialis
                            </p>
                        </div>
                    </div>
                </a>
            </div>
        </div>

        <div class="d-flex justify-content-center align-items-center my-3">
            <a href="" class="btn btn-primary text-priamry">Muat Lebih Banyak</a>
        </div>
</section>
<!-- end section pengajar -->
@endsection