 <div></div>
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
                     <li class="nav-item dropdown ">
                         <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                             aria-expanded="false">
                             Profil
                         </a>
                         <ul class="dropdown-menu">
                             <li><a class="dropdown-item text-dark" href="#">Sejarah</a></li>
                             <li><a class="dropdown-item text-dark" href="/profil/visi-misi-spesialis1-btkv-fk-unair">Visi Misi</a></li>
                             <li><a class="dropdown-item text-dark" href="#">Fasilitas</a></li>
                             <li><a class="dropdown-item text-dark" href="/profil/akreditasi-spesialis1-btkv-fk-unair">Akreditasi</a></li>
                         </ul>
                     </li>
                     <li class="nav-item">
                         <a class="nav-link" href="/daftar-berita">Berita</a>
                     </li>
                     <li class="nav-item">
                         <a class="nav-link" href="#">Layanan</a>
                     </li>
                     <li class="nav-item">
                         <a class="nav-link" href="#">Galeri</a>
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
                     <a class="nav-link d-flex align-items-center" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                         Profil <i class="bi bi-chevron-down ms-1" style="font-size: 18px;"></i>
                     </a>
                     <ul class="dropdown-menu bg-white">
                         <li><a class="dropdown-item text-dark" href="#">Sejarah</a></li>
                         <li><a class="dropdown-item text-dark" href="/profil/visi-misi-spesialis1-btkv-fk-unair">Visi danMisi</a></li>
                         <li><a class="dropdown-item text-dark" href="#">Fasilitas</a></li>
                         <li><a class="dropdown-item text-dark" href="/profil/akreditasi-spesialis1-btkv-fk-unair">Akreditasi</a></li>
                     </ul>
                 </li>
                 <li class="nav-item">
                     <a class="nav-link" href="/daftar-berita">Berita</a>
                 </li>
                 <li class="nav-item">
                     <a class="nav-link" href="#">Layanan</a>
                 </li>
                 <li class="nav-item">
                     <a class="nav-link" href="#">Galeri</a>
                 </li>
             </ul>
         </div>
     </div>
 </nav>
 <!-- end navbar -->