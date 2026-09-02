{{-- resources/views/auth/login.blade.php --}}
@extends('layouts.app')

@php
    $schoolName = setting('school_name', 'SMPN 3 Ciawigebang');
    $schoolLogo = setting('logo') ? Storage::url(setting('logo')) : asset('images/logo-sekolah.webp');
    $loginBg = setting('bg_login') ? Storage::url(setting('bg_login')) : asset('images/sekolah-1.jpg');
    $loginCardImg = setting('login_card_image')
        ? Storage::url(setting('login_card_image'))
        : asset('images/siswa-1.jpg');
@endphp

@section('title', 'Login Portal — ' . $schoolName)

@section('content')
    <!-- Section Utama Background Halaman -->
    <section
        class="relative w-full min-h-screen flex items-center justify-center py-12 sm:py-20 px-4 sm:px-6 lg:px-8 overflow-hidden z-25 bg-slate-950">

        <!-- Background Lingkungan Sekolah -->
        <div class="absolute inset-0 z-0 overflow-hidden">
            <img src="{{ $loginBg }}" alt="Background Login"
                class="w-full h-full object-cover object-center filter brightness-60" loading="eager">
            <div class="absolute inset-0 bg-slate-950/80"></div>
        </div>

        <!-- Container Utama Split Screen (Responsif: Di HP menumpuk ke bawah dengan foto di atas, di Laptop berdampingan) -->
        <div
            class="relative z-10 w-full max-w-4xl bg-white border border-slate-200 rounded-3xl overflow-hidden shadow-2xl flex flex-col lg:flex-row my-auto">

            <!-- SISI KANAN / ATAS (Tampil di HP & Laptop): Foto Aktivitas Sekolah -->
            <div
                class="w-full lg:w-1/2 relative bg-slate-900 overflow-hidden flex items-end p-6 sm:p-8 lg:p-10 min-h-[200px] sm:min-h-[240px] lg:min-h-full">

                <!-- Gambar Card Login -->
                <img src="{{ $loginCardImg }}" alt="Aktivitas Sekolah"
                    class="absolute inset-0 w-full h-full object-cover object-center opacity-65">

                <!-- Overlay Gradien Gelap -->
                <div class="absolute inset-0 bg-gradient-to-t from-slate-950 via-slate-950/40 to-transparent"></div>

                <!-- Konten Teks di Atas Foto -->
                <div class="relative z-10 max-w-md">
                    <span
                        class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-blue-500/20 border border-blue-400/30 text-blue-300 text-[10px] sm:text-xs font-bold uppercase tracking-wider mb-2 sm:mb-3 backdrop-blur-md">
                        <i class="ti ti-shield-check text-blue-400"></i>
                        <span>Sistem Terintegrasi</span>
                    </span>
                    <h2
                        class="font-serif text-xl sm:text-2xl xl:text-3xl font-extrabold text-white tracking-tight leading-snug mb-1.5 sm:mb-2">
                        Membangun Generasi Unggul Berbasis Teknologi
                    </h2>
                    <p class="text-slate-300 text-xs xl:text-sm leading-relaxed font-normal">
                        Portal administrasi internal khusus untuk guru, operator, dan pengurus lembaga pendidikan.
                    </p>
                </div>
            </div>

            <!-- SISI KIRI / BAWAH: Form Login & Identitas -->
            <div class="w-full lg:w-1/2 p-6 sm:p-10 lg:p-12 flex flex-col justify-between bg-white relative">

                <!-- Header Logo & Judul -->
                <div>
                    <div class="flex items-center justify-between mb-6 sm:mb-8">
                        <a href="{{ route('home') }}" class="inline-flex items-center gap-2.5 group">
                            <div
                                class="w-10 h-10 sm:w-12 sm:h-12 flex items-center justify-center drop-shadow-md bg-slate-50 border border-slate-200 rounded-xl overflow-hidden p-1">
                                <img src="{{ $schoolLogo }}" alt="Logo Sekolah" class="w-full h-full object-contain">
                            </div>
                            <span class="font-serif font-bold text-slate-900 text-sm sm:text-base tracking-tight">
                                {{ $schoolName }}
                            </span>
                        </a>

                        <a href="{{ route('home') }}"
                            class="inline-flex items-center gap-1 text-xs font-semibold text-slate-500 hover:text-blue-600 transition-colors">
                            <i class="ti ti-arrow-left"></i>
                            <span class="hidden sm:inline">Beranda</span>
                        </a>
                    </div>

                    <div class="mb-6">
                        <span
                            class="inline-block px-3 py-1 rounded-full bg-blue-50 border border-blue-200 text-blue-800 text-[11px] font-bold uppercase tracking-wider mb-2">
                            Portal Resmi
                        </span>
                        <h1 class="font-serif text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">
                            Masuk ke Akun Anda
                        </h1>
                        <p class="text-slate-500 text-xs sm:text-sm mt-1">
                            Masukkan kredensial resmi untuk mengakses sistem manajemen sekolah.
                        </p>
                    </div>

                    <!-- Notifikasi Error Validasi -->
                    @if ($errors->any())
                        <div
                            class="mb-5 p-3.5 bg-rose-50 border border-rose-200 rounded-xl text-rose-700 text-xs sm:text-sm flex items-start gap-2.5">
                            <i class="ti ti-alert-circle text-base shrink-0 mt-0.5"></i>
                            <div>
                                <span class="font-bold block mb-0.5">Gagal Masuk</span>
                                @foreach ($errors->all() as $error)
                                    <p>{{ $error }}</p>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <!-- Form Login -->
                    <form method="POST" action="{{ route('login') }}" class="space-y-4">
                        @csrf

                        <!-- Input Email -->
                        <div>
                            <label for="email" class="block text-xs font-semibold text-slate-700 mb-1">
                                Alamat Email
                            </label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center text-slate-400">
                                    <i class="ti ti-mail text-base"></i>
                                </span>
                                <input type="email" id="email" name="email" value="{{ old('email') }}"
                                    placeholder="nama@sekolah.sch.id" required autofocus
                                    class="w-full pl-10 pr-3.5 py-2.5 rounded-xl bg-slate-50 border border-slate-200 focus:border-blue-600 focus:bg-white focus:ring-1 focus:ring-blue-600 outline-none text-slate-800 text-xs sm:text-sm transition-all">
                            </div>
                        </div>

                        <!-- Input Password dengan Toggle -->
                        <div>
                            <label for="password" class="block text-xs font-semibold text-slate-700 mb-1">
                                Kata Sandi
                            </label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center text-slate-400">
                                    <i class="ti ti-lock text-base"></i>
                                </span>

                                <input type="password" id="password" name="password" placeholder="••••••••" required
                                    class="w-full pl-10 pr-10 py-2.5 rounded-xl bg-slate-50 border border-slate-200 focus:border-blue-600 focus:bg-white focus:ring-1 focus:ring-blue-600 outline-none text-slate-800 text-xs sm:text-sm transition-all">

                                <button type="button" onclick="togglePasswordVisibility()"
                                    class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-slate-400 hover:text-slate-600 cursor-pointer">
                                    <i id="toggle-password-icon" class="ti ti-eye text-base"></i>
                                </button>
                            </div>
                        </div>

                        <!-- Ingat Saya -->
                        <div class="flex items-center justify-between text-xs pt-1">
                            <label class="flex items-center gap-2 cursor-pointer text-slate-600">
                                <input type="checkbox" name="remember"
                                    class="rounded border-slate-300 text-blue-600 focus:ring-blue-500 w-4 h-4">
                                <span>Ingat saya di perangkat ini</span>
                            </label>
                        </div>

                        <!-- Tombol Aksi -->
                        <button type="submit"
                            class="w-full py-3 bg-blue-600 hover:bg-blue-700 text-white font-semibold text-xs sm:text-sm rounded-xl shadow-md hover:shadow-lg transition-all flex items-center justify-center gap-2 cursor-pointer mt-2">
                            <span>Masuk ke Sistem</span>
                            <i class="ti ti-arrow-right text-base"></i>
                        </button>
                    </form>
                </div>

                <!-- Footer Hak Cipta Dinamis -->
                <div class="text-xs text-slate-400 text-center lg:text-left mt-8 pt-4 border-t border-slate-100">
                    &copy; {{ date('Y') }} {{ $schoolName }}. Hak Cipta Dilindungi.
                </div>

            </div>

        </div>
    </section>

    @push('scripts')
        <script>
            function togglePasswordVisibility() {
                const passwordInput = document.getElementById('password');
                const toggleIcon = document.getElementById('toggle-password-icon');

                if (passwordInput.type === 'password') {
                    passwordInput.type = 'text';
                    toggleIcon.classList.remove('ti-eye');
                    toggleIcon.classList.add('ti-eye-off');
                } else {
                    passwordInput.type = 'password';
                    toggleIcon.classList.remove('ti-eye-off');
                    toggleIcon.classList.add('ti-eye');
                }
            }
        </script>
    @endpush
@endsection
