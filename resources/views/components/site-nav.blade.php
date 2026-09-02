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

            <!-- Toggle Search + Dropdown Panel (menggantikan tombol Kontak) -->
            <div class="relative">
                <button type="button" id="nav-search-toggle"
                    class="hidden sm:inline-flex items-center gap-2 px-4 py-2 bg-slate-900 hover:bg-slate-800 text-white border border-slate-700 rounded-lg text-sm font-semibold transition-all duration-200 whitespace-nowrap"
                    aria-expanded="false" aria-label="Buka Pencarian">
                    <i class="ti ti-search text-base text-blue-400" aria-hidden="true"></i>
                    <span>Cari</span>
                </button>

                {{-- Dropdown Panel Search (solid, tanpa efek glass/blur) --}}
                <div id="nav-search-panel"
                    class="hidden absolute right-0 top-full mt-2 w-80 sm:w-96 bg-white border border-slate-200 rounded-xl shadow-xl overflow-hidden z-50">
                    <div class="p-3 border-b border-slate-100 bg-slate-50">
                        <div class="relative">
                            <i
                                class="ti ti-search absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-base"></i>
                            <input type="text" id="nav-search-input" autocomplete="off"
                                placeholder="Cari berita, fasilitas, galeri, prestasi..."
                                class="w-full pl-10 pr-4 py-2.5 bg-white border border-slate-200 rounded-lg text-sm text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-500/30 focus:border-blue-500">
                        </div>
                    </div>

                    <div class="px-4 py-2.5 border-b border-slate-100">
                        <p id="nav-search-label" class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">
                            Berita Terbaru
                        </p>
                    </div>

                    <ul id="nav-search-results" class="max-h-80 overflow-y-auto divide-y divide-slate-100">
                        {{-- Diisi via JavaScript (AJAX fetch) --}}
                    </ul>

                    <p id="nav-search-loading" class="hidden px-4 py-6 text-center text-sm text-slate-400">
                        Memuat...
                    </p>
                    <p id="nav-search-empty" class="hidden px-4 py-6 text-center text-sm text-slate-400">
                        Tidak ada hasil yang cocok.
                    </p>
                </div>
            </div>

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

    <!-- Search Bar di Mobile Drawer -->
    <div class="p-4 border-b border-slate-800">
        <div class="relative">
            <i class="ti ti-search absolute left-3 top-1/2 -translate-y-1/2 text-slate-500 text-base"></i>
            <input type="text" id="nav-search-input-mobile" autocomplete="off"
                placeholder="Cari berita, fasilitas, galeri, prestasi..."
                class="w-full pl-10 pr-4 py-2.5 bg-slate-900 border border-slate-800 rounded-lg text-sm text-white placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-blue-500/40 focus:border-blue-500">
        </div>
        <ul id="nav-search-results-mobile" class="mt-2 max-h-56 overflow-y-auto divide-y divide-slate-800 hidden">
            {{-- Diisi via JavaScript (AJAX fetch) --}}
        </ul>
        <p id="nav-search-empty-mobile" class="hidden mt-2 text-center text-xs text-slate-500 py-3">
            Tidak ada hasil yang cocok.
        </p>
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

            // ============================
            // Toggle Search Panel (Desktop)
            // ============================
            const searchToggle = document.getElementById('nav-search-toggle');
            const searchPanel = document.getElementById('nav-search-panel');
            const searchInput = document.getElementById('nav-search-input');

            function openSearchPanel() {
                searchPanel.classList.remove('hidden');
                searchToggle.setAttribute('aria-expanded', 'true');
                searchInput.focus();
                if (searchInput.value.trim() === '') {
                    fetchSearchResults('', 'desktop');
                }
            }

            function closeSearchPanel() {
                searchPanel.classList.add('hidden');
                searchToggle.setAttribute('aria-expanded', 'false');
            }

            if (searchToggle) {
                searchToggle.addEventListener('click', function(e) {
                    e.stopPropagation();
                    if (searchPanel.classList.contains('hidden')) {
                        openSearchPanel();
                    } else {
                        closeSearchPanel();
                    }
                });
            }

            // Tutup panel saat klik di luar area
            document.addEventListener('click', function(e) {
                if (searchPanel && !searchPanel.contains(e.target) && e.target !== searchToggle) {
                    closeSearchPanel();
                }
            });

            // Tutup panel saat tekan Escape
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape') closeSearchPanel();
            });

            // ============================
            // AJAX Live Search (Debounced)
            // ============================
            let debounceTimer = null;

            function debounceSearch(query, context) {
                clearTimeout(debounceTimer);
                debounceTimer = setTimeout(() => fetchSearchResults(query, context), 350);
            }

            function fetchSearchResults(query, context) {
                const isMobile = context === 'mobile';
                const resultsEl = document.getElementById(isMobile ? 'nav-search-results-mobile' :
                    'nav-search-results');
                const emptyEl = document.getElementById(isMobile ? 'nav-search-empty-mobile' : 'nav-search-empty');
                const loadingEl = document.getElementById('nav-search-loading'); // hanya ada di desktop
                const labelEl = document.getElementById('nav-search-label'); // hanya ada di desktop

                if (!isMobile && loadingEl) loadingEl.classList.remove('hidden');
                if (!isMobile && resultsEl) resultsEl.classList.add('hidden');
                if (emptyEl) emptyEl.classList.add('hidden');

                fetch(`{{ route('search.quick') }}?q=${encodeURIComponent(query)}`)
                    .then(response => response.json())
                    .then(data => {
                        if (!isMobile && loadingEl) loadingEl.classList.add('hidden');
                        if (!isMobile && labelEl) {
                            labelEl.textContent = query ? 'Hasil Pencarian' : 'Berita Terbaru';
                        }

                        if (!resultsEl) return;

                        // Bersihkan hasil sebelumnya (aman — menghapus child nodes)
                        while (resultsEl.firstChild) {
                            resultsEl.removeChild(resultsEl.firstChild);
                        }

                        if (data.length === 0) {
                            if (emptyEl) emptyEl.classList.remove('hidden');
                            resultsEl.classList.add('hidden');
                            return;
                        }

                        resultsEl.classList.remove('hidden');

                        data.forEach(function(item) {
                            const li = document.createElement('li');

                            const a = document.createElement('a');
                            a.href = item.url;
                            a.className = `flex items-center gap-3 px-4 py-3 hover:bg-slate-50 transition-colors ${isMobile ? 'hover:bg-slate-800 rounded-lg' : ''}`;

                            // Thumbnail / Icon container
                            const thumbDiv = document.createElement('div');
                            thumbDiv.className = `w-11 h-11 rounded-lg ${isMobile ? 'bg-slate-800 text-blue-400' : 'bg-blue-50 text-blue-600'} flex items-center justify-center shrink-0 overflow-hidden`;

                            if (item.image) {
                                const img = document.createElement('img');
                                img.src = item.image;
                                img.alt = item.title || '';
                                img.className = 'w-full h-full object-cover';
                                thumbDiv.appendChild(img);
                            } else {
                                const icon = document.createElement('i');
                                icon.className = 'ti ti-news text-lg';
                                icon.setAttribute('aria-hidden', 'true');
                                thumbDiv.appendChild(icon);
                            }

                            a.appendChild(thumbDiv);

                            // Text container
                            const textDiv = document.createElement('div');
                            textDiv.className = 'min-w-0';

                            const titleP = document.createElement('p');
                            titleP.className = `text-sm font-semibold ${isMobile ? 'text-white' : 'text-slate-900'} truncate`;
                            titleP.textContent = item.title || '(tanpa judul)';
                            textDiv.appendChild(titleP);

                            const metaP = document.createElement('p');
                            metaP.className = `text-[11px] ${isMobile ? 'text-slate-400' : 'text-slate-400'} mt-0.5`;

                            // Tampilkan type badge + tanggal
                            if (item.type) {
                                const typeBadge = document.createElement('span');
                                typeBadge.className = 'font-bold uppercase tracking-wide mr-1.5';
                                typeBadge.textContent = item.type;
                                metaP.appendChild(typeBadge);
                            }
                            if (item.date) {
                                const dateSpan = document.createElement('span');
                                dateSpan.textContent = item.date;
                                metaP.appendChild(dateSpan);
                            }

                            textDiv.appendChild(metaP);
                            a.appendChild(textDiv);
                            li.appendChild(a);
                            resultsEl.appendChild(li);
                        });
                    })
                    .catch(() => {
                        if (!isMobile && loadingEl) loadingEl.classList.add('hidden');
                        if (emptyEl) emptyEl.classList.remove('hidden');
                    });
            }

            if (searchInput) {
                searchInput.addEventListener('input', function() {
                    debounceSearch(this.value.trim(), 'desktop');
                });
            }

            // ============================
            // Search Mobile (di dalam drawer)
            // ============================
            const searchInputMobile = document.getElementById('nav-search-input-mobile');
            if (searchInputMobile) {
                searchInputMobile.addEventListener('input', function() {
                    debounceSearch(this.value.trim(), 'mobile');
                });
            }
        });
    </script>
@endpush
