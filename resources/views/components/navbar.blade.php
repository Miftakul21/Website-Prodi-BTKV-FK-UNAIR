 <!-- navbar -->
 <nav class="navbar navbar-expand-lg bg-primary">
     <div class="container">
         <a class="navbar-brand" href="/">
             <img src="{{ asset('img/lg-prodi.png') }}" alt="logo-prodi" class="image-logo">
         </a>
         <!-- Hanya tampil di mobile (<= lg) -->
         <button class="navbar-toggler d-lg-none" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar"
             aria-controls="offcanvasNavbar">
             <span class="navbar-toggler-icon"></span>
         </button>
         <!-- Offcanvas hanya untuk mobile -->
         <div class="offcanvas bg-dark offcanvas-end d-lg-none" tabindex="-1" id="offcanvasNavbar"
             aria-labelledby="offcanvasNavbarLabel">
             <div class="offcanvas-header d-flex justify-content-end">
                 <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="Close"></button>
             </div>
             <div class="offcanvas-body">
                 <ul class="navbar-nav justify-content-end flex-grow-1 pe-3">
                     <li class="nav-item">
                         <a class="nav-link active" aria-current="page" href="/">Beranda</a>
                     </li>

                     <li class="nav-item dropdown">
                         <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                             aria-expanded="false">
                             Profil
                         </a>
                         <ul class="dropdown-menu">
                             <li><a class="dropdown-item" href="#">Sejarah</a></li>
                             <li><a class="dropdown-item" href="{{route('visi-misi')}}">Visi Misi</a></li>
                             <li><a class="dropdown-item" href="{{route('fasilitas')}}">Fasilitas</a></li>
                             <li><a class="dropdown-item" href="{{route('akreditasi')}}">Akreditasi</a></li>
                         </ul>
                     </li>

                     <li class="nav-item dropdown">
                         <a href="#" class="nav-link dropdown-toggle" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                             Akademik
                         </a>
                         <ul class="dropdown-menu">
                             <li><a href="#" class="dropdown-item">Alumni</a></li>
                             <li><a href="https://unairsatu.unair.ac.id/site/login" class="dropdown-item">Cyber Campus</a></li>
                             <li><a href="{{route('kalender')}}" class="dropdown-item">Kalender Akademik</a></li>
                             <li><a href="#" class="dropdown-item">Kurikulum</a></li>
                             <li><a href="#" class="dropdown-item">Tugas Akhir Tesis</a></li>
                             <li><a href="#" class="dropdown-item">Yudisium Prodi BTKV</a></li>
                         </ul>
                     </li>

                     <li class="nav-item dropdown">
                         <a href="#" class="nav-link dropdown-toggle" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                             Informasi
                         </a>
                         <ul class="dropdown-menu">
                             <li><a href="#" class="dropdown-item">Brosur Prodi Spesialis BTKV</a></li>
                             <li><a href="#" class="dropdown-item">Penerimaan PPDS BTKV</a></li>
                             <li><a href="{{route('berita')}}" class="dropdown-item">Berita</a></li>
                             <li><a href="#" class="dropdown-item">Pengumuman</a></li>
                             <li><a href="#" class="dropdown-item">Prestasi</a></li>
                             <li><a href="#" class="dropdown-item">Site Staf dan Tenaga Pengajar</a></li>
                             <li><a href="#" class="dropdown-item">Publikasi</a></li>
                             <li><a href="#" class="dropdown-item">Hasil Karya</a></li>
                         </ul>
                     </li>

                     <li class="nav-item">
                         <a class="nav-link" href="#">Kontak</a>
                     </li>
                 </ul>
             </div>
         </div>
         <!-- Menu biasa, hanya tampil di desktop & iPad (>= lg) -->
         <div class="collapse navbar-collapse d-none d-lg-block" id="navbarNav">
             <ul class="navbar-nav ms-auto">
                 <li class="nav-item">
                     <a class="nav-link active" aria-current="page" href="/">Beranda</a>
                 </li>

                 <li class="nav-item dropdown">
                     <a href="#" class="nav-link dropdown-toggle" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                         Profil
                     </a>

                     <ul class="dropdown-menu">
                         <li><a href="#" class="dropdown-item">Sejarah</a></li>
                         <li><a href="{{route('visi-misi')}}" class="dropdown-item">Visi Misi</a></li>
                         <li><a href="{{route('fasilitas')}}" class="dropdown-item">Fasilitas</a></li>
                         <li><a href="{{route('akreditasi')}}" class="dropdown-item">Akreditasi</a></li>
                     </ul>
                 </li>

                 <li class="nav-item dropdown">
                     <a href="#" class="nav-link dropdown-toggle" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                         Akademik
                     </a>

                     <ul class="dropdown-menu">
                         <li><a href="#" class="dropdown-item">Alumni</a></li>
                         <li><a href="https://unairsatu.unair.ac.id/site/login" class="dropdown-item">Cyber Campus</a></li>
                         <li><a href="{{route('kalender')}}" class="dropdown-item">Kalender Akademik</a></li>
                         <li><a href="#" class="dropdown-item">Kurikulum Akademik</a></li>
                         <li><a href="#" class="dropdown-item">Tugas Akhir Tesis</a></li>
                         <li><a href="#" class="dropdown-item">Yudisium Prodi BTKV</a></li>
                     </ul>
                 </li>

                 <li class="nav-item dropdown">
                     <a href="#" class="nav-link dropdown-toggle" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                         Informasi
                     </a>
                     <ul class="dropdown-menu">
                         <li><a href="#" class="dropdown-item">Brosur Prodi Spesialis BTKV</a></li>
                         <li><a href="#" class="dropdown-item">Penerimaan PPDS BTKV</a></li>
                         <li><a href="{{route('berita')}}" class="dropdown-item">Berita</a></li>
                         <li><a href="#" class="dropdown-item">Pengumuman</a></li>
                         <li><a href="#" class="dropdown-item">Prestasi</a></li>
                         <li><a href="#" class="dropdown-item">Site Staf dan Tenaga Pengajar</a></li>
                         <li><a href="#" class="dropdown-item">Publikasi</a></li>
                         <li><a href="#" class="dropdown-item">Hasil Karya</a></li>
                     </ul>
                 </li>

                 <li class="nav-item">
                     <a class="nav-link" href="#">Kontak</a>
                 </li>
             </ul>
         </div>
     </div>
 </nav>
 <!-- end navbar -->