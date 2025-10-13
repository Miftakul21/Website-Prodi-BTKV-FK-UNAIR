@extends('layouts.layouts-users')
@push('css')
<link rel="stylesheet" href="{{asset('css/profil-visi-misi.css')}}">
@endpush

@section('content')
<section class="visi-misi-section">
    <div class="container">
        <div class="d-flex justify-content-center align-items-center mb-3">
            <span class="info-section">Visi Dan Misi <br> Program Studi Spesialis I <br> Bedah Toraks, Kardiak, Dan Vaskular Fakultas Universitas Airlangga</span>
        </div>

        <div class="container-visi">
            <h6>Visi Program Studi Spesialis I Bedah Toraks, Kardiak, dan Vaskular: </h6>
            <p>Menjadi program studi yang mampu bersaing ditingkat Nasional mampu international untuk menghasilkan Dokter Spesialis Bedah Toraks, Kardiak, dan Vaskular yang terampil dibidangnya secara profesional, inovatif, mandiri dan mempunyai jiwa enterpreneur serta memiliki integritas tinggi berdasarkan moral agama sampai tahun 2025.</p>
        </div>

        <span class="line"></span>

        <div class="container-misi">
            <h6>Misi Program Studi Spesialis I Bedah Toraks, Kardiak, dan Vaskular:</h6>
            <ol>
                <li>Menyelenggarakan dan mengembangkan pendidikan akademik dan spesialis kedokteran yang diakui ditingkat nasional dan internasional berdasakan bilai kenagsaan dan moral agama.</li>
                <li>Menyelenggarakan penelitian dasar dan terapan kedokteran di bidang bedah toraks, kardiak dan vaskular, khususnya mengenai jantung dewasa, jantung pediatrik dan kongenital, toraks serta vaskular dan endovaskular yang inovatif dan mandiri berdasarkan nilai kebangsaan dan moral agama untuk menunjang pengembangan pendidikan dan pengabdian kepada masyarakat.</li>
                <li>Mendarmabaktikan keahlian dalam bidang ilmu pengetahuan dan teknologi kedokteran spesialis Bedah toraks, kardiak, dan vaskular yang menjunjung nilai-nilai profesionalisme, berjiwa entrepereneurship serta humaniora untuk kesehatan masyarakat.</li>
                <li>Menyelenggarakan tata kelola program studi dokter spesialis secara mandiri dengan baik yang berorientasi pada mutu dan mampu bersaing di tingkat nasional dan internasional.</li>
            </ol>
        </div>

        <span class="line"></span>
    </div>
</section>
@endsection