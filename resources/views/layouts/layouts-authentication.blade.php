<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('Login ADmin Webstie BTKV FK UNAIR')</title>

    <!-- meta data nanti ya -->
    <link rel="icon" href="{{asset('img/logo-btkv-unair.png')}}" type="image/png">

    <link rel="stylesheet" href="{{asset('compiled/css/app.css')}}">
    <link rel="stylesheet" href="{{asset('compiled/css/app-dark.css')}}">
    <link rel="stylesheet" href="{{asset('compiled/css/auth.css')}}">
</head>

<body>
    <script src="{{asset('assets/static/js/initTheme.js')}}"></script>
    <div id="auth">
        @yield('content')


    </div>
</body>

</html>