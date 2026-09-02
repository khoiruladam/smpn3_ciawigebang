<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;

class LoginController extends Controller
{
    /**
     * Tampilkan halaman form login.
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }

    /**
     * Proses autentikasi login.
     */
    public function login(Request $request)
    {
        // Validasi input
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ], [
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'password.required' => 'Kata sandi wajib diisi.',
        ]);

        $throttleKey = $this->throttleKey($request);

        // Cek apakah sudah terlalu banyak percobaan gagal
        if (RateLimiter::tooManyAttempts($throttleKey, 5)) {
            $seconds = RateLimiter::availableIn($throttleKey);
            $minutes = ceil($seconds / 60);

            return back()->withErrors([
                'email' => "Terlalu banyak percobaan gagal. Coba lagi dalam {$minutes} menit.",
            ])->onlyInput('email');
        }

        // Coba autentikasi
        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            RateLimiter::clear($throttleKey); // reset hitungan gagal setelah berhasil
            $request->session()->regenerate();

            return redirect()->intended(route('admin.dashboard'))
                ->with('success', 'Berhasil masuk ke sistem.');
        }

        // Gagal login → catat percobaan
        RateLimiter::hit($throttleKey, 60); // kunci 60 detik setelah limit tercapai

        $remaining = RateLimiter::remaining($throttleKey, 5);

        return back()->withErrors([
            'email' => $remaining > 0
                ? 'Email atau kata sandi yang Anda masukkan salah.'
                : 'Terlalu banyak percobaan gagal. Coba lagi dalam beberapa saat.',
        ])->onlyInput('email');
    }

    /**
     * Proses keluar (logout).
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login')
            ->with('success', 'Anda telah keluar dari sistem.');
    }

    /**
     * Kunci unik untuk rate limiting — kombinasi email + IP,
     * supaya penyerang tidak bisa lewat cuma dengan ganti-ganti email.
     */
    protected function throttleKey(Request $request): string
    {
        return Str::lower($request->input('email')) . '|' . $request->ip();
    }
}