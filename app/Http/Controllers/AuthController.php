<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Http\Request;

use function PHPSTORM_META\map;

class AuthController extends Controller
{
    public function index()
    {
        return view('auth.login');
    }

    public function authentication(Request $request)
    {

        try {
            $request->validate([
                'email' => 'required|string|email',
                'password' => 'required|string|min:8'
            ]);

            $user = User::where('email', $request->email)->first();
            if (!$user) {
                return redirect()->back()->with('error', 'Email atau password salah');
            }

            // key berdasarkan email (bukan hanya IP)
            $key = 'login-lock:' . Str::lower($request->email);
            // jika sudah terkunci
            if (RateLimiter::tooManyAttempts($key, 5)) {
                $seconds = RateLimiter::availableIn($key);
                return redirect()->back()
                    ->with('error', "Akun terkunci. Silakan coba lagi dalam " . ceil($seconds / 60) . " menit."); // 5 menit
            }
            // cek password
            $password = env('SALT_PASSWORD') . $request->password . env('SALT_PASSWORD');

            if (!Hash::check($password, $user->password)) {
                // tambah attempt kalau gagal
                RateLimiter::hit($key, 300); // lock 5 menit (300 detik)
                $attempts = RateLimiter::attempts($key);
                Log::warning("Login gagal untuk {$request->email}, percobaan ke {$attempts}");

                return redirect()->back()->with('error', 'Email atau password salah');
            }
            // login sukses → reset limiter
            RateLimiter::clear($key);
            Auth::login($user);

            $request->session()->regenerate();
            return redirect('/dashboard')->with('success', 'Berhasil login');
        } catch (\Throwable $e) {
            Log::error('Error login: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Terjadi kesalahan server');
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login')->with('success', 'Berhasil logout');
    }
}
