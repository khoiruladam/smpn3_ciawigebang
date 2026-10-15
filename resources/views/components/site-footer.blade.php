@php
    $logo = setting('logo') ? Storage::url(setting('logo')) : asset('images/logo-sekolah.webp');
    $schoolName = setting('school_name', 'SMP Negeri 3 Ciawigebang');
    $footerAbout = setting(
        'footer_about',
        'Membentuk generasi cerdas, berkarakter unggul, berwawasan lingkungan, dan menguasai teknologi modern.',
    );
    $footerAddress = setting('footer_address', 'Jl. Raya Ciawigebang, Kuningan, Jawa Barat');
    $footerPhone = setting('footer_phone', '(0232) 123456');
    $footerEmail = setting('footer_email', 'info@smpn3ciawigebang.sch.id');
    $opWeekday = setting('operational_weekday', 'Senin - Jumat: 07.00 - 15.30 WIB');
    $opWeekend = setting('operational_weekend', 'Sabtu - Minggu: Libur');
    $copyrightText = setting('footer_copyright', 'Official School Website');

    // Data Sosial Media Dinamis dari JSON database (Fallback ke default jika kosong)
    $defaultSocials = [
        ['name' => 'Facebook', 'icon' => 'ti-brand-facebook', 'url' => setting('social_facebook', '#')],
        ['name' => 'Instagram', 'icon' => 'ti-brand-instagram', 'url' => setting('social_instagram', '#')],
        ['name' => 'YouTube', 'icon' => 'ti-brand-youtube', 'url' => setting('social_youtube', '#')],
    ];
    $socials = setting('socials_data') ? json_decode(setting('socials_data'), true) : $defaultSocials;
@endphp

<footer class="bg-slate-950 text-slate-300 py-10 sm:py-12 border-t border-slate-800" role="contentinfo">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 md:gap-12 pb-8 border-b border-slate-800">

            <!-- Kolom 1: Identitas & Kontak -->
            <div class="flex flex-col gap-4">
                <a href="{{ url('/') }}" class="flex items-center gap-3 no-underline group w-fit">
                    <div
                        class="w-10 h-10 bg-white rounded-xl p-1 shadow-sm flex items-center justify-center shrink-0 border border-slate-700 overflow-hidden">
                        <img src="{{ $logo }}" alt="Logo" class="w-full h-full object-contain">
                    </div>
                    <span
                        class="font-bold text-white text-base sm:text-lg tracking-wide group-hover:text-blue-400 transition-colors">
                        {{ $schoolName }}
                    </span>
                </a>
                <p class="text-slate-400 text-xs sm:text-sm leading-relaxed max-w-md">
                    {{ $footerAbout }}
                </p>
                <div class="flex flex-col gap-2 text-xs sm:text-sm text-slate-300 mt-1">
                    <div class="flex items-start gap-2.5">
                        <i class="ti ti-map-pin text-blue-400 text-base mt-0.5 shrink-0"></i>
                        <span>{{ $footerAddress }}</span>
                    </div>
                    <div class="flex items-center gap-2.5">
                        <i class="ti ti-phone text-blue-400 text-base shrink-0"></i> <span>{{ $footerPhone }}</span>
                    </div>
                    <div class="flex items-center gap-2.5">
                        <i class="ti ti-mail text-blue-400 text-base shrink-0"></i> <span>{{ $footerEmail }}</span>
                    </div>
                </div>
            </div>

            <!-- Kolom 2: Jam Operasional & Sosmed Dinamis -->
            <div class="flex flex-col gap-6 md:items-end justify-between">
                <div class="flex flex-col gap-2.5 md:items-end">
                    <h4 class="font-bold text-white text-xs sm:text-sm uppercase tracking-wider">Jam Operasional Sekolah
                    </h4>
                    <ul class="flex flex-col gap-1.5 list-none p-0 m-0 text-xs sm:text-sm text-slate-400 md:text-right">
                        <li class="flex items-center gap-2 md:justify-end">
                            <i class="ti ti-clock text-blue-400"></i> <span>{{ $opWeekday }}</span>
                        </li>
                        <li class="flex items-center gap-2 md:justify-end">
                            <i class="ti ti-calendar-off text-slate-500"></i> <span>{{ $opWeekend }}</span>
                        </li>
                    </ul>
                </div>

                <div class="flex flex-col gap-2.5 md:items-end">
                    <h4 class="font-bold text-white text-xs uppercase tracking-wider text-slate-400">Ikuti Kami</h4>
                    <div class="flex items-center gap-2.5 flex-wrap md:justify-end">
                        @foreach ($socials as $soc)
                            @if (!empty($soc['url']) && $soc['url'] !== '#')
                                <a href="{{ $soc['url'] }}" target="_blank" rel="noopener noreferrer"
                                    title="{{ $soc['name'] ?? 'Sosial Media' }}"
                                    class="w-9 h-9 rounded-lg bg-slate-900 hover:bg-blue-600 border border-slate-800 text-slate-300 hover:text-white flex items-center justify-center transition-all">
                                    <i class="ti {{ $soc['icon'] ?? 'ti-world' }} text-base"></i>
                                </a>
                            @endif
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <div
            class="pt-6 flex flex-col sm:flex-row items-center justify-between gap-2 text-xs text-slate-500 text-center sm:text-left">
            <p>&copy; {{ date('Y') }} {{ $schoolName }}. Semua Hak Dilindungi.</p>
            <p>{{ $copyrightText }}</p>
        </div>
    </div>
</footer>

