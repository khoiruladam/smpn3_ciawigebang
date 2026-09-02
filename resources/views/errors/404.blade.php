@extends('layouts.app')

@php
    // Mengambil background hero yang sama dengan settingan website
    $bgHero = setting('bg_hero') ? Storage::url(setting('bg_hero')) : asset('images/hero-1.jpg');
@endphp

@section('content')
    <!-- Section Utama 404 dengan Background Hero -->
    <div class="relative min-h-[85vh] flex items-center justify-center px-4 py-20 bg-cover bg-center bg-no-repeat overflow-hidden"
        style="background-image: url('{{ $bgHero }}')">

        <!-- Dark Overlay untuk kontras -->
        <div class="absolute inset-0 bg-slate-950/60 z-0"></div>

        <!-- Content Card (Solid White, No Glass) -->
        <div class="relative z-10 max-w-sm w-full bg-white rounded-3xl p-8 shadow-2xl text-center space-y-6">

            <!-- Logo Sekolah -->
            @if (function_exists('setting') && setting('logo'))
                <div class="flex justify-center">
                    <div
                        class="w-16 h-16 rounded-xl border border-slate-200 flex items-center justify-center p-2 shadow-sm bg-slate-50">
                        <img src="{{ Storage::url(setting('logo')) }}" alt="Logo Sekolah"
                            class="max-w-full max-h-full object-contain">
                    </div>
                </div>
            @endif

            <!-- Ikon -->
            <div class="w-16 h-16 bg-blue-50 text-blue-600 rounded-2xl flex items-center justify-center text-3xl mx-auto">
                <i class="ti ti-compass-off"></i>
            </div>

            <!-- Teks -->
            <div class="space-y-2">
                <h1 class="text-4xl font-black text-slate-900 tracking-tight">404</h1>
                <h2 class="text-lg font-bold text-slate-800">Halaman Tidak Ditemukan</h2>
                <p class="text-slate-500 text-sm leading-relaxed">
                    Halaman yang Anda cari tidak tersedia atau sedang dalam tahap pengembangan.
                </p>
            </div>

            <!-- Tombol -->
            <div class="pt-2">
                <a href="/"
                    class="w-full inline-flex items-center justify-center gap-2 px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-bold text-sm rounded-xl transition-all shadow-md">
                    <i class="ti ti-arrow-left"></i>
                    <span>Kembali ke Beranda</span>
                </a>
            </div>

        </div>

    </div>
@endsection
