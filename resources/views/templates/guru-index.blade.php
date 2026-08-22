@extends('layouts.app')

@section('content')
    @php
        $bgGuru = asset('images/guru-1.jpg');
    @endphp

    <div class="relative w-full min-h-screen bg-slate-950 pt-28 pb-16 px-4 sm:px-6 lg:px-8 overflow-hidden">
        <!-- Background Gambar dengan Overlay Gelap -->
        <div class="absolute inset-0 z-0">
            <img src="{{ $bgGuru }}" alt="Background Tenaga Pendidik"
                class="w-full h-full object-cover object-center opacity-40" loading="lazy">
            <div class="absolute inset-0 bg-slate-950/75"></div>
        </div>

        <div class="relative z-10 max-w-4xl mx-auto">
            <!-- Tombol Kembali dengan Jarak Aman dari Topbar -->
            <div class="mb-8">
                <a href="{{ url('/') }}"
                    class="inline-flex items-center gap-2 px-4 py-2 bg-white/10 hover:bg-white/20 border border-white/20 text-white text-xs sm:text-sm font-semibold rounded-xl backdrop-blur-md transition-all shadow-sm">
                    <i class="ti ti-arrow-left"></i> Kembali ke Beranda
                </a>
            </div>

            <!-- Header Halaman -->
            <div class="text-center max-w-xl mx-auto mb-12">
                <span
                    class="inline-block px-3 py-1 rounded-full bg-white/10 border border-white/20 text-slate-200 text-[10px] sm:text-xs font-semibold uppercase tracking-wider mb-2 backdrop-blur-md">
                    Direktori Sekolah
                </span>
                <h1 class="font-serif text-3xl sm:text-4xl font-bold text-white tracking-tight mb-2">
                    Struktur Pendidik & Staff Lengkap
                </h1>
                <p class="text-slate-300 text-xs sm:text-sm">
                    Bagan kepemimpinan, jajaran guru, dan staff pendukung di {{ config('app.name') }}.
                </p>
            </div>

            @php
                $kepsek = $gurus->where('category', 'kepsek')->first();
                $wakels = $gurus->where('category', 'wakel');
                $staffs = $gurus->whereNotIn('category', ['kepsek', 'wakel']);
            @endphp

            <div class="flex flex-col items-center space-y-4">

                <!-- TINGKAT 1: KEPALA SEKOLAH -->
                @if ($kepsek)
                    <div
                        class="w-full max-w-md bg-white border border-slate-200 rounded-2xl p-4 shadow-xl flex items-center gap-4 hover:border-blue-500 transition-colors z-10">
                        @php
                            $kepsekImg = $kepsek->image
                                ? (Str::startsWith($kepsek->image, 'http')
                                    ? $kepsek->image
                                    : Storage::url($kepsek->image))
                                : 'https://via.placeholder.com/150';
                        @endphp
                        <img src="{{ $kepsekImg }}" alt="{{ $kepsek->name }}"
                            class="w-14 h-14 rounded-full object-cover bg-slate-100 shrink-0 border-2 border-blue-600">
                        <div class="overflow-hidden text-left">
                            <span
                                class="inline-block text-[11px] font-bold text-blue-700 uppercase tracking-wider mb-0.5">{{ $kepsek->jabatan }}</span>
                            <h3 class="font-serif text-base font-bold text-slate-900 truncate leading-snug">
                                {{ $kepsek->name }}</h3>
                            <p class="text-xs text-slate-500 font-medium truncate mt-0.5">{{ $kepsek->sub }}</p>
                        </div>
                    </div>

                    @if ($wakels->count() > 0 || $staffs->count() > 0)
                        <!-- GARIS PENGHUBUNG 1 -->
                        <div class="w-0.5 h-8 bg-blue-500/80"></div>
                    @endif
                @endif

                <!-- TINGKAT 2: WAKIL KEPALA SEKOLAH -->
                @if ($wakels->count() > 0)
                    <div class="w-full max-w-md space-y-3 z-10">
                        @foreach ($wakels as $wakel)
                            <div
                                class="bg-white border border-slate-200 rounded-2xl p-4 shadow-lg flex items-center gap-4 hover:border-blue-400 transition-colors">
                                @php
                                    $wakelImg = $wakel->image
                                        ? (Str::startsWith($wakel->image, 'http')
                                            ? $wakel->image
                                            : Storage::url($wakel->image))
                                        : 'https://via.placeholder.com/150';
                                @endphp
                                <img src="{{ $wakelImg }}" alt="{{ $wakel->name }}"
                                    class="w-13 h-13 rounded-full object-cover bg-slate-100 shrink-0 border border-slate-300">
                                <div class="overflow-hidden text-left">
                                    <span
                                        class="inline-block text-[11px] font-bold text-slate-600 uppercase tracking-wider mb-0.5">{{ $wakel->jabatan }}</span>
                                    <h3 class="font-serif text-base font-bold text-slate-900 truncate leading-snug">
                                        {{ $wakel->name }}</h3>
                                    <p class="text-xs text-slate-500 font-medium truncate mt-0.5">{{ $wakel->sub }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    @if ($staffs->count() > 0)
                        <!-- GARIS PENGHUBUNG 2 -->
                        <div class="w-0.5 h-8 bg-slate-400/80"></div>
                    @endif
                @endif

                <!-- TINGKAT 3: DEWAN GURU & STAFF LAINNYA -->
                @if ($staffs->count() > 0)
                    <div class="w-full mt-4">
                        <div class="text-center mb-6">
                            <span
                                class="text-xs font-semibold text-slate-300 uppercase tracking-widest bg-white/10 border border-white/20 px-4 py-1.5 rounded-full backdrop-blur-md">
                                Dewan Guru & Staff Pendukung
                            </span>
                        </div>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            @foreach ($staffs as $g)
                                <div
                                    class="bg-white border border-slate-200/90 rounded-xl p-3.5 shadow-md flex items-center gap-3.5 hover:shadow-lg hover:border-blue-300 transition-all">
                                    @php
                                        $guruImg = $g->image
                                            ? (Str::startsWith($g->image, 'http')
                                                ? $g->image
                                                : Storage::url($g->image))
                                            : 'https://via.placeholder.com/150';
                                    @endphp
                                    <img src="{{ $guruImg }}" alt="{{ $g->name }}"
                                        class="w-11 h-11 rounded-full object-cover bg-slate-100 shrink-0 border border-slate-200">
                                    <div class="overflow-hidden text-left">
                                        <span
                                            class="block text-[10px] font-bold text-blue-600 uppercase tracking-wide truncate">{{ $g->jabatan }}</span>
                                        <h4 class="font-serif text-sm font-bold text-slate-900 truncate leading-snug">
                                            {{ $g->name }}</h4>
                                        <p class="text-[11px] text-slate-500 font-medium truncate mt-0.5">
                                            {{ $g->sub ?? 'Pengajar' }}</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

            </div>
        </div>
    </div>
@endsection
