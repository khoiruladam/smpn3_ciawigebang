<!DOCTYPE html>
<html lang="id" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="@yield('meta_description', config('app.name') . ' — Website resmi sekolah')">
    <title>@yield('title', config('app.name'))</title>

    <!-- Google Fonts & Tabler Icons -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="preconnect" href="https://cdn.jsdelivr.net" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=DM+Serif+Display:ital@0;1&family=DM+Sans:opsz,wght@9..40,300;9..40,400;9..40,500;9..40,600;9..40,700&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/dist/tabler-icons.min.css">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
</head>

<body class="bg-slate-950 text-slate-100 font-sans antialiased selection:bg-blue-600 selection:text-white">

    @unless (request()->routeIs('login'))
        <x-site-nav />
    @endunless

    @yield('content')

    @unless (request()->routeIs('login') || request()->routeIs('berita.*') || request()->routeIs('guru.index'))
        <x-site-footer />
    @endunless

    @stack('scripts')

    <!-- Global Scroll-Reveal & Chart Trigger Intersection Observer -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const observerOptions = {
                root: null,
                threshold: 0.15 // Trigger saat 15% elemen masuk layar
            };

            const observer = new IntersectionObserver((entries, observer) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        const el = entry.target;

                        // 1. Eksekusi Animasi CSS Fade In / Slide Up
                        el.classList.add('transition-all', 'duration-700', 'ease-out');
                        el.classList.remove('opacity-0', 'translate-y-12', 'translate-y-10',
                            'translate-y-8', '-translate-y-8', '-translate-y-6');
                        el.classList.add('opacity-100', 'translate-y-0');

                        // 2. Trigger Animasi Chart.js jika di dalam elemen terdapat <canvas>
                        const canvas = el.querySelector('canvas');
                        if (canvas && typeof Chart !== 'undefined') {
                            const chartInstance = Chart.getChart(canvas);
                            if (chartInstance) {
                                chartInstance.reset(); // Reset data ke posisi 0
                                chartInstance.update(); // Putar ulang animasi naik dari bawah
                            }
                        }

                        observer.unobserve(el); // Hentikan pemantauan setelah aktif
                    }
                });
            }, observerOptions);

            // Daftarkan semua elemen .reveal-item dan .reveal-card di seluruh halaman
            document.querySelectorAll('.reveal-item, .reveal-card').forEach(el => {
                observer.observe(el);
            });
        });
    </script>
</body>

</html>
