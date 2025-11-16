<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', "Spesialis Bedah Toraks, Kardiak, Vaskular FK UNAIR")</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">

    <!-- icon bootstrap -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <!-- link cdn font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">

    <!-- link css custom components -->
    <link rel="stylesheet" href="{{ asset('css/components.css') }}">

    @stack('css')
    @livewireStyles
</head>

<body class="d-flex flex-column min-vh-100">
    <!-- Tombol Back to Top -->
    <button id="backToTop" class="btn btn-primary rounded-circle shadow"
        style="position: fixed; bottom: 20px; right: 20px; display: none; z-index: 99;">
        <i class="bi bi-chevron-up fw-bold"></i>
    </button>

    <!-- information contact -->
    <section class="information-contact-section bg-dark text-white py-1 d-none d-md-block d-xl-block">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center">
                <div class="container-media-social d-flex align-items-center gap-2">
                    <a href="https://www.instagram.com/btkv.fkua?utm_source=ig_web_button_share_sheet&igsh=ZDNlZDc0MzIxNw==" class="text-white"><i class="bi bi-instagram"></i></a>
                    <a href="https://www.youtube.com/@btkvfkua917" class="text-white"><i class="bi bi-youtube"></i></a>
                </div>
                <div class="container-media-contact d-flex justify-between align-items-center gap-3">
                    <div class="email">
                        <i class="bi bi-envelope"></i>
                        <span> prodibtkvsby@gmail.com</span>
                    </div>
                    <div class="phone">
                        <i class="bi bi-telephone-fill"></i>
                        <span>031-5501324</span>
                    </div>
                </div>
            </div>
    </section>
    <!-- end information contact -->

    @include('components.navbar')

    <main class="flex-fill">
        @yield('content')
    </main>

    @livewireScripts

    @include('components.footer')

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // ambil tombol
            const backToTop = document.getElementById("backToTop");

            // pantau scroll
            window.onscroll = function() {
                if (document.body.scrollTop > 200 || document.documentElement.scrollTop > 200) {
                    backToTop.style.display = "block";
                } else {
                    backToTop.style.display = "none";
                }
            };

            // scroll ke atas saat diklik
            backToTop.addEventListener("click", function() {
                window.scrollTo({
                    top: 0,
                    behavior: 'smooth'
                });
            });
        });
    </script>
    @stack('js')
</body>

</html>