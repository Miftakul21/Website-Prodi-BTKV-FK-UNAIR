@extends('layouts.layouts-authentication')
@section('content')

@if(session('error'))
<script>
    Swal.fire({
        icon: 'error',
        title: 'Email atau password salah',
        showConfirmButton: false,
        timer: 3000
    });
</script>
@endif

<div class="row h-100">
    <div class="col-lg-5 col-12">
        <div id="auth-left">
            <div class="auth-logo">
                <a href="index.html"><img src="{{ asset('img/lg-prodi-dark.png') }}" alt="Logo" style="width: 300px; height: auto;"></a>
            </div>
            <h1 class=" auth-title">Sign In.</h1>
            <p class="auth-subtitle mb-5">Silahkan login dengan akun yang sudah registrasi untuk mengakses Admin Panel.</p>
            <form action="/login-authentication" method="POST">
                @csrf
                <div class="form-group position-relative has-icon-left mb-2">
                    <input type="text" name="email" class="form-control form-control-xl" placeholder="Email">
                    <div class="form-control-icon">
                        <i class="bi bi-person"></i>
                    </div>
                </div>
                <div class="form-group position-relative has-icon-left mb-2">
                    <input type="password" name="password" class="form-control form-control-xl" placeholder="Password">
                    <div class="form-control-icon">
                        <i class="bi bi-shield-lock"></i>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary btn-block btn-lg shadow-lg mt-3">Sign in</button>
            </form>
        </div>
    </div>
    <div class="col-lg-7 d-none d-lg-block">
        <div id="auth-right" style="width: 100%; height: 100%; overflow: hidden;">
            <img src="{{asset('img/bg-fk-unair.webp')}}" alt="" style="width: 100%; height: 100%; object-fit: cover;">
        </div>
    </div>
</div>
@endsection