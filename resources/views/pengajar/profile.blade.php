@extends('layouts.layouts-users')
@section('title', $pengajar_name)
@push('css')
<!-- link css profile  -->
{!! SEO::generate() !!}
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
                        <h1 class="profile-name">{{ $pengajar_name }}</h1>
                        <h3 class="profile-position text-primary">{{$pengajar_position}}</h3>
                        <h6 class="profile-long-experiance"><i class="bi bi-person-lines-fill"></i> 25+ Tahun Pengalaman</h6>
                        <div class="container-info-education">
                            <p><i class="bi bi-mortarboard"></i> Pendidikan</p>
                            @forelse($pengajar_pendidikan as $pen)
                            <p>{{$pen['pendidikan'] ?? ''}}</p>
                            @empty
                            @endforelse
                        </div>
                    </div>
                    <div class="col-xl-5 col-md-6 col-12 offset-xl-1 order-1 order-md-2">
                        <div class="container-image-profile">
                            <img src="{{ asset('storage/'.$pengajar_image) }}" alt="foto-dokter" class="image-profile">
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
                            {!! $pengajar_biography !!}
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-12">
                <div class="card card-hover border border-primary p-2 mb-3 border-opacity-50">
                    <div class="card-body">
                        <h6 class="fw-semibold biografi"><i class="fas fa-microscope me-1"></i>Bidang Penelitian</h6>
                        <p class="deskripsi-biografi">
                            {!! $pengajar_bidang_penelitian !!}
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-12">
                <div class="card card-hover border border-primary p-2 mb-3 border-opacity-50">
                    <div class="card-body">
                        <h6 class="fw-semibold kepentingan-klinis"> Kepentingan Klinis</h6>
                        <ul class="list-kepentingan-klinis">
                            @forelse($pengajar_kepentingan_klinis as $ket_klinis)
                            <li>{{$ket_klinis['klinis']}}</li>
                            @empty
                            @endforelse
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-12">
                <div class="card card-hover border border-primary p-2 mb-3 border-opacity-50">
                    <div class="card-body">
                        <h6 class="fw-semibold publikasi-penelitian"><i class="bi bi-book"></i> Publikasi Penelitian Terbaru</h6>
                        <div class="container-publikasi-penelitan mt-3">
                            @forelse($pengajar_publikasi_penelitian as $pub)
                            <div class="container-publikasi mb-2">
                                <h5>{{$pub['judul'] ?? ''}}</h5>
                                <p class="text-muted">{{$pub['jurnal'] ?? ''}}</p>
                            </div>
                            @empty
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12">
                <div class="card card-hover border border-primary p-2 mb-3 border-opacity-50">
                    <div class="card-body">
                        <h6 class="fw-semibold publikasi-penelitian"><i class="bi bi-award"></i> Prestasi dan Penghargaan</h6>
                        <div class="row mt-2">
                            @forelse($pengajar_prestasi_dan_penghargaan as $pre)
                            <div class="col-md-6 col-12 mb-3">
                                <i class="bi bi-award"></i> {{$pre['prestasi']}}
                            </div>
                            @empty
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection