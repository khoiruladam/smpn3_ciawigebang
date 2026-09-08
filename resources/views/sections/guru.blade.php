{{-- resources/views/sections/guru.blade.php --}}
@php
    // Background Guru dinamis dari pengaturan admin (fallback ke guru-1.jpg jika belum diatur)
    $bgGuru = setting('bg_guru') ? Storage::url(setting('bg_guru')) : asset('images/guru-1.jpg');
@endphp

<section id="guru" class="relative w-full bg-slate-950 py-12 sm:py-16 lg:py-24 overflow-hidden z-20"
    aria-label="Struktur Pendidik">

    <div class="absolute inset-0 z-0">
        <img src="{{ $bgGuru }}" alt="Background Tenaga Pendidik"
            class="w-full h-full object-cover object-center opacity-85" loading="lazy" decoding="async">
        <div class="absolute inset-0 bg-slate-950/75"></div>
    </div>

    <div class="relative z-10 max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">

        <!-- Header Seksi -->
        <div
            class="reveal-item opacity-0 -translate-y-6 transition-all duration-700 text-center max-w-xl mx-auto mb-8 sm:mb-12">
            <span
                class="inline-block px-3 py-1 rounded-full bg-white/10 border border-white/20 text-slate-200 text-[10px] sm:text-xs font-semibold uppercase tracking-wider mb-2 sm:mb-3 backdrop-blur-md">
                Struktur Organisasi
            </span>
            <h2
                class="font-serif text-2xl sm:text-3xl lg:text-4xl font-bold text-white tracking-tight leading-tight mb-2">
                Struktur Pendidik & Staff
            </h2>
            <p class="text-slate-300 text-xs sm:text-sm font-normal leading-relaxed">
                Bagan kepemimpinan dan jajaran tenaga pendidik di {{ config('app.name') }}.
            </p>
        </div>

        <div class="flex flex-col items-center">
            <!-- TINGKAT 1 & 2 (Kepala Sekolah & Wakil) tetap tampil di sini -->
            @if (isset($kepsek) && $kepsek)
                <div
                    class="reveal-card opacity-0 translate-y-6 transition-all duration-700 ease-out z-10 w-full max-w-sm mb-1">
                    <div
                        class="bg-white border border-slate-200 rounded-2xl p-3 sm:p-4 shadow-xl text-left flex items-center gap-3 sm:gap-4">
                        @php
                            $kepsekImg = $kepsek->image
                                ? (Str::startsWith($kepsek->image, 'http')
                                    ? $kepsek->image
                                    : Storage::url($kepsek->image))
                                : 'https://via.placeholder.com/150';
                        @endphp
                        <img src="{{ $kepsekImg }}" alt="{{ $kepsek->name }}"
                            class="w-12 h-12 sm:w-14 sm:h-14 rounded-full object-cover bg-slate-100 shrink-0 border-2 border-blue-600"
                            loading="lazy" decoding="async">
                        <div class="overflow-hidden">
                            <span
                                class="inline-block text-[10px] sm:text-[11px] font-bold text-blue-700 uppercase tracking-wider mb-0.5">{{ $kepsek->jabatan }}</span>
                            <h3 class="font-serif text-sm sm:text-base font-bold text-slate-900 truncate leading-snug">
                                {{ $kepsek->name }}</h3>
                            <p class="text-[11px] sm:text-xs text-slate-500 font-medium truncate mt-0.5">
                                {{ $kepsek->sub }}</p>
                        </div>
                    </div>
                </div>
                @if (isset($wakel) && $wakel)
                    <div
                        class="reveal-card opacity-0 transition-opacity duration-500 w-0.5 h-6 sm:h-8 bg-blue-500/80 my-1">
                    </div>
                @endif
            @endif

            @if (isset($wakel) && $wakel)
                <div
                    class="reveal-card opacity-0 translate-y-6 transition-all duration-700 ease-out z-10 w-full max-w-sm mb-1">
                    <div
                        class="bg-white border border-slate-200 rounded-2xl p-3 sm:p-4 shadow-lg text-left flex items-center gap-3 sm:gap-4">
                        @php
                            $wakelImg = $wakel->image
                                ? (Str::startsWith($wakel->image, 'http')
                                    ? $wakel->image
                                    : Storage::url($wakel->image))
                                : 'https://via.placeholder.com/150';
                        @endphp
                        <img src="{{ $wakelImg }}" alt="{{ $wakel->name }}"
                            class="w-12 h-12 sm:w-13 sm:h-13 rounded-full object-cover bg-slate-100 shrink-0 border border-slate-300"
                            loading="lazy" decoding="async">
                        <div class="overflow-hidden">
                            <span
                                class="inline-block text-[10px] sm:text-[11px] font-bold text-slate-600 uppercase tracking-wider mb-0.5">{{ $wakel->jabatan }}</span>
                            <h3 class="font-serif text-sm sm:text-base font-bold text-slate-900 truncate leading-snug">
                                {{ $wakel->name }}</h3>
                            <p class="text-[11px] sm:text-xs text-slate-500 font-medium truncate mt-0.5">
                                {{ $wakel->sub }}</p>
                        </div>
                    </div>
                </div>
                @if (isset($guruList) && $guruList->count() > 0)
                    <div
                        class="reveal-card opacity-0 transition-opacity duration-500 w-0.5 h-6 sm:h-8 bg-slate-400/80 my-1">
                    </div>
                @endif
            @endif

            <!-- TINGKAT 3: BATASI HANYA 4 GURU TERATAS DI HOME -->
            @if (isset($guruList) && $guruList->count() > 0)
                <div class="w-full mt-2">
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3.5 sm:gap-4">
                        @foreach ($guruList->take(4) as $index => $g)
                            <div
                                class="reveal-card opacity-0 translate-y-6 transition-all duration-700 ease-out bg-white border border-slate-200/90 rounded-xl p-3 shadow-md flex items-center gap-3 hover:shadow-lg hover:border-blue-300 transition-all">
                                @php
                                    $guruImg = $g->image
                                        ? (Str::startsWith($g->image, 'http')
                                            ? $g->image
                                            : Storage::url($g->image))
                                        : asset('images/siswa-1.jpg');
                                @endphp
                                <img src="{{ $guruImg }}" alt="{{ $g->name }}"
                                    class="w-11 h-11 sm:w-12 sm:h-12 rounded-full object-cover bg-slate-100 shrink-0 border border-slate-200"
                                    loading="lazy" decoding="async">
                                <div class="overflow-hidden text-left">
                                    <span
                                        class="block text-[10px] sm:text-[11px] font-bold text-blue-600 uppercase tracking-wide truncate">{{ $g->jabatan }}</span>
                                    <h4
                                        class="font-serif text-xs sm:text-sm font-bold text-slate-900 truncate leading-snug">
                                        {{ $g->name }}</h4>
                                    <p class="text-[11px] sm:text-xs text-slate-500 font-medium truncate mt-0.5">
                                        {{ $g->sub ?? 'Pengajar' }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- TOMBOL LIHAT SEMUA GURU -->
                <div class="mt-8 text-center">
                    <a href="{{ route('guru.index') }}" target="_blank" rel="noopener noreferrer"
                        class="inline-flex items-center gap-2 px-6 py-3 bg-white/10 hover:bg-white/20 border border-white/20 text-white font-semibold text-xs sm:text-sm rounded-xl backdrop-blur-md transition-all shadow-lg">
                        <span>Lihat Seluruh Jajaran Guru & Staff</span>
                        <i class="ti ti-external-link text-base"></i>
                    </a>
                </div>
            @endif

        </div>

    </div>
</section>
