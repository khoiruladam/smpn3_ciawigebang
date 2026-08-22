{{-- resources/views/components/site-nav.blade.php --}}

<nav class="fixed top-0 left-0 right-0 z-50 bg-slate-950 border-b border-slate-800/80 transition-all duration-300 m-0 p-0"
    id="site-nav">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-20 flex items-center justify-between gap-4">

        <!-- Brand Logo -->
        @php
            $logo = setting('logo') ? Storage::url(setting('logo')) : asset('images/logo-sekolah.webp');
            $schoolName = setting('school_name', 'SMP Negeri 3 Ciawigebang');
        @endphp

        <a href="{{ url('/') }}" class="flex items-center gap-3 shrink-0 no-underline group">
            <div
                class="w-10 h-10 bg-white rounded-xl p-1 shadow-sm flex items-center justify-center shrink-0 border border-slate-700 overflow-hidden group-hover:border-blue-500 transition-colors">
                <img src="{{ $logo }}" alt="Logo {{ $schoolName }}" class="w-full h-full object-contain">
            </div>
            <div class="flex flex-col">
                <span class="text-base font-bold text-white leading-tight group-hover:text-blue-300 transition-colors">
                    {{ $schoolName }}
                </span>
                <span class="text-[11px] text-slate-400 font-normal">
                    Official Website
                </span>
            </div>
        </a>

        <!-- Desktop Menu Links (Clean Solid Hover States) -->
        <ul class="hidden xl:flex items-center gap-1 list-none m-0 p-0">
            <li>
                <a href="{{ url('/') }}"
                    class="px-3.5 py-1.5 rounded-lg text-sm font-semibold text-white bg-slate-800 border border-slate-700 transition-all whitespace-nowrap">
                    Beranda
                </a>
            </li>
            <li>
                <a href="#profil"
                    class="px-3.5 py-1.5 rounded-lg text-sm font-medium text-slate-300 hover:text-white hover:bg-slate-900 transition-all duration-200 whitespace-nowrap">
                    Profil
                </a>
            </li>
            <li>
                <a href="#fasilitas"
                    class="px-3.5 py-1.5 rounded-lg text-sm font-medium text-slate-300 hover:text-white hover:bg-slate-900 transition-all duration-200 whitespace-nowrap">
                    Fasilitas
                </a>
            </li>
            <li>
                <a href="#ssk"
                    class="px-3.5 py-1.5 rounded-lg text-sm font-medium text-slate-300 hover:text-white hover:bg-slate-900 transition-all duration-200 whitespace-nowrap">
                    SSK
                </a>
            </li>
            <li>
                <a href="#galeri"
                    class="px-3.5 py-1.5 rounded-lg text-sm font-medium text-slate-300 hover:text-white hover:bg-slate-900 transition-all duration-200 whitespace-nowrap">
                    Galeri
                </a>
            </li>
            <li>
                <a href="#berita"
                    class="px-3.5 py-1.5 rounded-lg text-sm font-medium text-slate-300 hover:text-white hover:bg-slate-900 transition-all duration-200 whitespace-nowrap">
                    Berita
                </a>
            </li>
            <li>
                <a href="#guru"
                    class="px-3.5 py-1.5 rounded-lg text-sm font-medium text-slate-300 hover:text-white hover:bg-slate-900 transition-all duration-200 whitespace-nowrap">
                    Guru
                </a>
            </li>
            <li>
                <a href="#prestasi"
                    class="px-3.5 py-1.5 rounded-lg text-sm font-medium text-slate-300 hover:text-white hover:bg-slate-900 transition-all duration-200 whitespace-nowrap">
                    Prestasi
                </a>
            </li>
            <li>
                <a href="#ekskul"
                    class="px-3.5 py-1.5 rounded-lg text-sm font-medium text-slate-300 hover:text-white hover:bg-slate-900 transition-all duration-200 whitespace-nowrap">
                    Ekskul
                </a>
            </li>
        </ul>

        <!-- Right Action Buttons -->
        <div class="flex items-center gap-2.5 shrink-0">
            <a href="{{ route('login') }}"
                class="hidden sm:inline-flex items-center gap-2 px-4 py-2 bg-slate-900 hover:bg-slate-800 text-white border border-slate-700 rounded-lg text-sm font-semibold transition-all duration-200 whitespace-nowrap">
                <i class="ti ti-user-shield text-base text-blue-400" aria-hidden="true"></i>
                <span>Portal Login</span>
            </a>

            <a href="#kontak"
                class="hidden sm:inline-flex items-center gap-2 px-5 py-2 bg-amber-500 hover:bg-amber-600 text-slate-950 rounded-lg text-sm font-bold shadow-sm transition-all duration-200 whitespace-nowrap">
                <i class="ti ti-phone-call text-base" aria-hidden="true"></i>
                <span>Kontak</span>
            </a>

            <!-- Toggle Mobile Hamburger -->
            <button id="nav-toggle"
                class="xl:hidden inline-flex flex-col justify-center items-center gap-1 w-10 h-10 bg-slate-900 border border-slate-800 hover:border-slate-700 rounded-lg p-2 cursor-pointer text-white transition-all duration-200"
                aria-label="Buka Menu">
                <span class="w-full h-0.5 bg-white rounded-full transition-transform"></span>
                <span class="w-full h-0.5 bg-white rounded-full transition-opacity"></span>
                <span class="w-full h-0.5 bg-white rounded-full transition-transform"></span>
            </button>
        </div>
    </div>
</nav>

<!-- Mobile Navigation Drawer -->
<div id="mobile-menu"
    class="fixed top-0 right-0 w-4/5 max-w-xs h-full bg-slate-950 border-l border-slate-800 z-[60] flex flex-col shadow-xl transition-transform duration-300 ease-in-out translate-x-full"
    aria-hidden="true">
    <div class="flex items-center justify-between p-4 border-b border-slate-800">
        <div class="flex items-center gap-2.5">
            <div
                class="w-8 h-8 bg-blue-600 text-white font-serif text-lg font-bold flex items-center justify-center rounded-lg">
                {{ substr(config('app.name'), 0, 1) }}
            </div>
            <span class="font-serif text-base font-bold text-white">{{ config('app.name') }}</span>
        </div>
        <button id="nav-close"
            class="w-8 h-8 rounded-lg bg-slate-900 text-slate-300 hover:text-white border border-slate-800 flex items-center justify-center transition-all">
            <i class="ti ti-x text-lg"></i>
        </button>
    </div>

    <div class="flex-1 p-4 overflow-y-auto">
        <ul class="flex flex-col gap-1 list-none p-0 m-0">
            <li><a href="{{ url('/') }}"
                    class="mobile-link flex items-center gap-3 px-3.5 py-2.5 text-sm font-medium text-slate-200 hover:text-white hover:bg-slate-900 rounded-lg transition-colors"><i
                        class="ti ti-home text-blue-400 text-lg"></i> Beranda</a></li>
            <li><a href="#profil"
                    class="mobile-link flex items-center gap-3 px-3.5 py-2.5 text-sm font-medium text-slate-200 hover:text-white hover:bg-slate-900 rounded-lg transition-colors"><i
                        class="ti ti-building text-blue-400 text-lg"></i> Profil Sekolah</a></li>
            <li><a href="#fasilitas"
                    class="mobile-link flex items-center gap-3 px-3.5 py-2.5 text-sm font-medium text-slate-200 hover:text-white hover:bg-slate-900 rounded-lg transition-colors"><i
                        class="ti ti-layout-grid text-blue-400 text-lg"></i> Fasilitas</a></li>
            <li><a href="#ssk"
                    class="mobile-link flex items-center gap-3 px-3.5 py-2.5 text-sm font-medium text-slate-200 hover:text-white hover:bg-slate-900 rounded-lg transition-colors"><i
                        class="ti ti-file-text text-blue-400 text-lg"></i> Info SSK / PPDB</a></li>
            <li><a href="#galeri"
                    class="mobile-link flex items-center gap-3 px-3.5 py-2.5 text-sm font-medium text-slate-200 hover:text-white hover:bg-slate-900 rounded-lg transition-colors"><i
                        class="ti ti-photo text-blue-400 text-lg"></i> Galeri Kegiatan</a></li>
            <li><a href="#berita"
                    class="mobile-link flex items-center gap-3 px-3.5 py-2.5 text-sm font-medium text-slate-200 hover:text-white hover:bg-slate-900 rounded-lg transition-colors"><i
                        class="ti ti-news text-blue-400 text-lg"></i> Berita & Artikel</a></li>
            <li><a href="#guru"
                    class="mobile-link flex items-center gap-3 px-3.5 py-2.5 text-sm font-medium text-slate-200 hover:text-white hover:bg-slate-900 rounded-lg transition-colors"><i
                        class="ti ti-users text-blue-400 text-lg"></i> Data Guru</a></li>
            <li><a href="#prestasi"
                    class="mobile-link flex items-center gap-3 px-3.5 py-2.5 text-sm font-medium text-slate-200 hover:text-white hover:bg-slate-900 rounded-lg transition-colors"><i
                        class="ti ti-trophy text-blue-400 text-lg"></i> Prestasi</a></li>
            <li><a href="#ekskul"
                    class="mobile-link flex items-center gap-3 px-3.5 py-2.5 text-sm font-medium text-slate-200 hover:text-white hover:bg-slate-900 rounded-lg transition-colors"><i
                        class="ti ti-activity text-blue-400 text-lg"></i> Ekstrakurikuler</a></li>
        </ul>
    </div>

    <div class="p-4 border-t border-slate-800 flex flex-col gap-2">
        <a href="{{ route('login') }}"
            class="flex items-center justify-center gap-2 w-full py-2.5 bg-slate-900 text-white rounded-lg text-sm font-semibold hover:bg-slate-800 border border-slate-800 transition-colors">
            <i class="ti ti-user-shield text-blue-400"></i> Portal Login
        </a>
        <a href="#kontak"
            class="flex items-center justify-center gap-2 w-full py-2.5 bg-amber-500 text-slate-950 rounded-lg text-sm font-bold hover:bg-amber-600 transition-colors">
            <i class="ti ti-phone-call"></i> Hubungi Kami
        </a>
    </div>
</div>

<!-- Backdrop Overlay Mobile -->
<div id="mobile-overlay"
    class="fixed inset-0 bg-slate-950/80 z-[55] opacity-0 pointer-events-none transition-opacity duration-200"
    aria-hidden="true"></div>

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const navToggle = document.getElementById('nav-toggle');
            const navClose = document.getElementById('nav-close');
            const mobileMenu = document.getElementById('mobile-menu');
            const mobileOverlay = document.getElementById('mobile-overlay');
            const mobileLinks = document.querySelectorAll('.mobile-link');
            const siteNav = document.getElementById('site-nav');

            function openMenu() {
                mobileMenu.classList.remove('translate-x-full');
                mobileOverlay.classList.remove('opacity-0', 'pointer-events-none');
                document.body.classList.add('overflow-hidden');
            }

            function closeMenu() {
                mobileMenu.classList.add('translate-x-full');
                mobileOverlay.classList.add('opacity-0', 'pointer-events-none');
                document.body.classList.remove('overflow-hidden');
            }

            if (navToggle) navToggle.addEventListener('click', openMenu);
            if (navClose) navClose.addEventListener('click', closeMenu);
            if (mobileOverlay) mobileOverlay.addEventListener('click', closeMenu);

            mobileLinks.forEach(link => {
                link.addEventListener('click', closeMenu);
            });

            // Efek shadow & border saat di-scroll
            window.addEventListener('scroll', function() {
                if (window.scrollY > 40) {
                    siteNav.classList.add('shadow-lg', 'bg-slate-950/95');
                } else {
                    siteNav.classList.remove('shadow-lg', 'bg-slate-950/95');
                }
            });
        });
    </script>
@endpush
