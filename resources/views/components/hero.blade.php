@php
    // Data Background & Identitas
    $heroBg = setting('bg_hero') ? Storage::url(setting('bg_hero')) : asset('images/bg_desktop.webp');
    $logo = setting('logo') ? Storage::url(setting('logo')) : asset('images/logo-sekolah.webp');

    $heroTitle1 = setting('hero_title_1', 'SMP Negeri 3');
    $heroTitle2 = setting('hero_title_2', 'Ciawigebang');
    $heroDesc = setting(
        'hero_description',
        'Membina generasi muda dengan nilai karakter yang kuat, berwawasan lingkungan, serta menguasai teknologi modern.',
    );

    $btn1Text = setting('hero_btn1_text', 'INFO PPDB');
    $btn1Link = setting('hero_btn1_link', '#ssk');
    $btn2Text = setting('hero_btn2_text', 'JELAJAHI SEKOLAH');
    $btn2Link = setting('hero_btn2_link', '#profil');

    // Data Floating Features Dinamis dari JSON database (Fallback ke default jika kosong)
    $defaultFeatures = [
        ['icon' => 'ti-device-laptop', 'title' => 'Kelas Digital', 'desc' => 'Pembelajaran TIK'],
        ['icon' => 'ti-users', 'title' => 'Pengajar Kompeten', 'desc' => 'Guru berpengalaman'],
        ['icon' => 'ti-shield-check', 'title' => 'Lingkungan Aman', 'desc' => 'Kondusif & ramah'],
        ['icon' => 'ti-heart-handshake', 'title' => 'Karakter Unggul', 'desc' => 'Nilai Pancasila'],
        ['icon' => 'ti-flask', 'title' => 'Lab Lengkap', 'desc' => 'IPA, Komputer & Bahasa'],
    ];

    $features = setting('features_data') ? json_decode(setting('features_data'), true) : $defaultFeatures;
    $gridCount = count($features) > 0 ? count($features) : 5;
@endphp

<!-- Style Animasi Masuk & Efek Mengetik -->
@push('styles')
    <style>
        @keyframes heroInLeft {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes heroInRight {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-hero-left {
            animation: heroInLeft 1s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        }

        .animate-hero-right {
            animation: heroInRight 1s cubic-bezier(0.16, 1, 0.3, 1) forwards;
            animation-delay: 150ms;
        }

        .typing-cursor::after {
            content: '|';
            animation: blink 1s infinite;
        }

        @keyframes blink {

            0%,
            100% {
                opacity: 1;
            }

            50% {
                opacity: 0;
            }
        }
    </style>
@endpush

<section
    class="relative w-full bg-slate-950 min-h-screen flex flex-col justify-center pt-28 sm:pt-32 pb-12 overflow-visible z-20"
    aria-label="Hero Section">
    <!-- Background Image & Gradient Overlay Padat -->
    <div class="absolute inset-0 z-0 overflow-hidden">
        <img src="{{ $heroBg }}" alt="Background Hero" class="w-full h-full object-cover object-center opacity-55"
            loading="eager">
        <div
            class="absolute inset-0 bg-gradient-to-b lg:bg-gradient-to-r from-slate-950 via-slate-950/90 to-slate-950/60">
        </div>
    </div>

    <!-- Container Konten Utama -->
    <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex-1 flex items-center w-full py-8">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 lg:gap-8 items-center w-full">

            <!-- Logo -->
            <div class="lg:col-span-4 flex justify-center lg:justify-end animate-hero-left opacity-0">
                <div class="w-32 h-32 sm:w-44 sm:h-44 lg:w-56 lg:h-56 flex items-center justify-center drop-shadow-2xl">
                    <img src="{{ $logo }}" alt="Logo Sekolah"
                        class="w-full h-full object-contain filter drop-shadow-[0_10px_20px_rgba(0,0,0,0.8)]">
                </div>
            </div>

            <!-- Garis Pemisah Vertikal -->
            <div class="hidden lg:flex lg:col-span-1 justify-center">
                <div class="w-px h-48 bg-gradient-to-b from-transparent via-slate-700 to-transparent"></div>
            </div>

            <!-- Teks & Tombol -->
            <div
                class="lg:col-span-7 text-center lg:text-left animate-hero-right opacity-0 flex flex-col items-center lg:items-start">
                <h1
                    class="text-2xl sm:text-4xl lg:text-5xl font-black text-white tracking-tight leading-tight mb-3 sm:mb-4 flex flex-col uppercase">
                    <span>{{ $heroTitle1 }}</span>
                    <span class="text-blue-400 mt-0.5 sm:mt-1">{{ $heroTitle2 }}</span>
                </h1>

                <p id="typing-description"
                    class="text-slate-300 text-xs sm:text-sm lg:text-base font-normal leading-relaxed mb-6 max-w-xl min-h-[48px] sm:min-h-[40px] typing-cursor px-2 lg:px-0"
                    data-text="{{ $heroDesc }}"></p>

                <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-3 w-full sm:w-auto">
                    <a href="{{ $btn1Link }}"
                        class="inline-flex items-center justify-center gap-2 px-5 py-3 sm:py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-bold text-xs sm:text-sm rounded-xl sm:rounded-lg shadow-md transition-all">
                        <span>{{ $btn1Text }}</span>
                        <i class="ti ti-arrow-right text-base"></i>
                    </a>
                    <a href="{{ $btn2Link }}"
                        class="inline-flex items-center justify-center gap-2 px-5 py-3 sm:py-2.5 bg-slate-900 hover:bg-slate-800 text-white border border-slate-700 font-semibold text-xs sm:text-sm rounded-xl sm:rounded-lg transition-all">
                        <span>{{ $btn2Text }}</span>
                        <i class="ti ti-compass text-base text-blue-400"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Floating Quick Features Bar Dinamis (Diperbaiki agar rapi memanjang ke samping di Laptop dan bersih di Mobile) -->
    <div class="relative z-30 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 w-full -mb-6 sm:-mb-16">
        @php
            $count = count($features);
            // Menentukan kelas grid secara dinamis dan aman berdasarkan jumlah data (maksimal 4 atau 5)
            $gridClass = match (true) {
                $count == 4 => 'grid-cols-1 sm:grid-cols-2 lg:grid-cols-4',
                $count == 3 => 'grid-cols-1 sm:grid-cols-3',
                default => 'grid-cols-1 sm:grid-cols-2 lg:grid-cols-5',
            };
        @endphp

        <div class="bg-white border border-slate-200/80 rounded-3xl shadow-2xl p-4 sm:p-6 lg:p-8">

            <!-- Grid disesuaikan secara presisi dengan jumlah item agar tidak ada sisa ruang kosong di kanan -->
            <div class="grid {{ $gridClass }} gap-4 sm:gap-6 divide-y sm:divide-y-0 lg:divide-y-0 lg:divide-x divide-slate-100">
                @foreach ($features as $feat)
                    <div class="flex items-center gap-3 sm:gap-4 pt-3 sm:pt-0 {{ $loop->first ? '' : 'lg:pl-6' }}">
                        <div
                            class="w-11 h-11 sm:w-14 sm:h-14 rounded-2xl bg-blue-50 text-blue-600 flex items-center justify-center text-2xl sm:text-3xl shrink-0 shadow-inner">
                            <i class="ti {{ $feat['icon'] ?? 'ti-star' }}"></i>
                        </div>
                        <div class="overflow-hidden">
                            <h4 class="font-bold text-xs sm:text-base text-slate-900 leading-tight truncate">
                                {{ $feat['title'] ?? '' }}
                            </h4>
                            <p class="text-[11px] sm:text-sm text-slate-500 mt-0.5 sm:mt-1 truncate">
                                {{ $feat['desc'] ?? '' }}
                            </p>
                        </div>
                    </div>
                @endforeach
            </div>

        </div>
    </div>
</section>

@push('scripts')
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const element = document.getElementById("typing-description");
            if (!element) return;
            const textToType = element.getAttribute("data-text");
            let charIndex = 0;

            function typeWriter() {
                if (charIndex < textToType.length) {
                    element.textContent += textToType.charAt(charIndex);
                    charIndex++;
                    setTimeout(typeWriter, 35);
                } else {
                    element.classList.remove('typing-cursor');
                }
            }
            setTimeout(typeWriter, 600);
        });
    </script>
@endpush
