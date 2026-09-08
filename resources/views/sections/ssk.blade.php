{{-- resources/views/sections/ssk.blade.php --}}
@php
    // Background SSK dinamis dari pengaturan admin (fallback ke sekolah-2.jpg)
    $bgHeroStyle = setting('bg_ssk') ? Storage::url(setting('bg_ssk')) : asset('images/sekolah-2.jpg');

    // Mengambil data Statistik SSK dari controller (fallback ke collect kosong jika belum dipassing)
    $sskItems = $sskItems ?? collect();

    if ($sskItems->isEmpty()) {
        $sskItems = collect([
            (object) [
                'icon' => 'ti-school',
                'label' => 'Rombongan Belajar',
                'value' => 18,
                'suffix' => ' Ruang',
                'decimals' => 0,
                'sub' => 'Kelas VII - IX',
            ],
            (object) [
                'icon' => 'ti-users',
                'label' => 'Peserta Didik',
                'value' => 540,
                'suffix' => ' Siswa',
                'decimals' => 0,
                'sub' => 'Siswa Aktif',
            ],
            (object) [
                'icon' => 'ti-user-check',
                'label' => 'Guru & Staf',
                'value' => 32,
                'suffix' => ' Orang',
                'decimals' => 0,
                'sub' => 'Pendidik & Kependidikan',
            ],
            (object) [
                'icon' => 'ti-device-desktop',
                'label' => 'Fasilitas Lab',
                'value' => 6,
                'suffix' => ' Ruang',
                'decimals' => 0,
                'sub' => 'Lab Komputer & IPA',
            ],
        ]);
    }

    // Mengambil data Demografi dari controller (fallback ke collect kosong jika belum dipassing)
    $demographics = $demographics ?? collect();

    if ($demographics->isEmpty()) {
        $demographics = collect([
            (object) ['kelas' => 'VII A', 'male_count' => 16, 'female_count' => 14],
            (object) ['kelas' => 'VII B', 'male_count' => 15, 'female_count' => 15],
            (object) ['kelas' => 'VII C', 'male_count' => 14, 'female_count' => 16],
            (object) ['kelas' => 'VIII A', 'male_count' => 13, 'female_count' => 14],
            (object) ['kelas' => 'VIII B', 'male_count' => 14, 'female_count' => 14],
            (object) ['kelas' => 'IX A', 'male_count' => 15, 'female_count' => 16],
        ]);
    }
@endphp

<!-- Section Full-Width Berstyle Hero Section -->
<section id="ssk" class="relative w-full bg-slate-950 py-20 lg:py-28 overflow-hidden z-20"
    aria-label="Sekolah Siaga Kependudukan">

    <!-- Background Image & Solid Dark Overlay (Tanpa Blur) -->
    <div class="absolute inset-0 z-0 bg-slate-950">
        <!-- Hapus opacity-10 agar gambar memiliki visibilitas 100% -->
        <img src="{{ $bgHeroStyle }}" alt="Background SSK" class="w-full h-full object-cover object-center" loading="lazy"
            decoding="async">

        <!-- Kurangi kepekatan overlay (misal 60% ke 90%) agar gambar terlihat menembus warna gelap -->
        <div class="absolute inset-0 bg-gradient-to-b from-slate-950/60 via-slate-950/70 to-slate-950/90"></div>
    </div>

    <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <!-- Header Title -->
        <div class="reveal-item opacity-0 -translate-y-6 transition-all duration-700 max-w-3xl mb-12">
            <div
                class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-slate-900 border border-slate-800 text-blue-400 text-xs sm:text-sm font-semibold mb-5 shadow-lg">
                <i class="ti ti-chart-dots text-amber-400 text-base" aria-hidden="true"></i>
                <span>Data & Statistik SSK</span>
            </div>
            <h2 id="h-ssk"
                class="font-serif text-3xl sm:text-4xl lg:text-5xl font-extrabold text-white tracking-tight leading-tight mb-4">
                Sekolah Siaga Kependudukan
            </h2>
            <p class="text-slate-400 text-sm sm:text-base font-normal leading-relaxed">
                Gambaran statistik data pokok, demografi peserta didik, dan standar sarana di
                {{ config('app.name', 'sekolah') }}.
            </p>
        </div>

        <!-- STATS GRID (Solid Cards) -->
        <div
            class="reveal-item opacity-0 -translate-y-6 transition-all duration-700 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4 sm:gap-6 pb-12">
            @foreach ($sskItems as $s)
                <div
                    class="group bg-slate-900 border border-slate-800 hover:border-blue-600 hover:bg-slate-800 rounded-2xl p-5 sm:p-6 flex flex-col justify-center shadow-xl transition-all duration-300 hover:-translate-y-1">

                    <div class="flex items-start gap-4">
                        <!-- Icon Wrapper Solid -->
                        <div
                            class="w-12 h-12 rounded-xl bg-slate-800 border border-slate-700 text-blue-400 flex items-center justify-center text-2xl shrink-0 group-hover:bg-blue-600 group-hover:text-white group-hover:border-blue-500 transition-all duration-300">
                            <i class="ti {{ $s->icon ?? 'ti-chart-bar' }}" aria-hidden="true"></i>
                        </div>

                        <div class="flex flex-col overflow-hidden">
                            <!-- Nilai dan Suffix Dipisah -->
                            <div class="flex items-baseline gap-1.5 mb-1">
                                <span
                                    class="counter-number font-serif text-3xl sm:text-4xl font-extrabold text-white tracking-tight leading-none"
                                    data-target="{{ $s->value }}" data-decimals="{{ $s->decimals ?? 0 }}">
                                    0
                                </span>
                                @if (!empty($s->suffix))
                                    <span class="text-sm font-semibold text-blue-400 whitespace-nowrap">
                                        {{ $s->suffix }}
                                    </span>
                                @endif
                            </div>

                            <span class="text-sm font-bold text-slate-300 mt-1">
                                {{ $s->label }}
                            </span>

                            @if (!empty($s->sub))
                                <span class="text-[11px] sm:text-xs text-slate-500 font-medium mt-0.5 line-clamp-2">
                                    {{ $s->sub }}
                                </span>
                            @endif
                        </div>
                    </div>

                </div>
            @endforeach
        </div>

        <!-- CHART SECTION (Solid Card) -->
        <div
            class="reveal-card opacity-0 translate-y-8 transition-all duration-700 bg-slate-900 border border-slate-800 rounded-2xl p-5 sm:p-8 shadow-2xl">

            <!-- Chart Header -->
            <div
                class="flex flex-col lg:flex-row lg:items-center justify-between gap-4 mb-6 pb-5 border-b border-slate-800">
                <div>
                    <h3 class="font-serif text-xl sm:text-2xl font-bold text-white tracking-wide">
                        Distribusi Peserta Didik Per Tingkat
                    </h3>
                    <p class="text-xs sm:text-sm text-slate-400 font-normal mt-1.5">
                        Perbandingan jumlah siswa Laki-laki dan Perempuan berdasarkan kelas
                    </p>
                </div>

                <div
                    class="flex flex-wrap items-center gap-4 text-xs sm:text-sm font-semibold text-slate-300 bg-slate-800 px-4 py-2 rounded-lg border border-slate-700">
                    <div class="flex items-center gap-2">
                        <span class="w-3 h-3 rounded-sm bg-blue-500 inline-block"></span>
                        <span>Siswa Laki-laki</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="w-3 h-3 rounded-sm bg-amber-400 inline-block"></span>
                        <span>Siswa Perempuan</span>
                    </div>
                </div>
            </div>

            <!-- Chart Container (Responsif tanpa overflow horizontal) -->
            <div class="w-full pb-3">
                <div class="w-full min-w-full h-64 sm:h-80">
                    <canvas id="sskDemographicChart" data-labels="{{ $demographics->pluck('kelas')->toJson() }}"
                        data-male="{{ $demographics->pluck('male_count')->toJson() }}"
                        data-female="{{ $demographics->pluck('female_count')->toJson() }}">
                    </canvas>
                </div>
            </div>

        </div>

    </div>
</section>

@push('styles')
    <style>
        /* Custom Scrollbar Solid Style */
        .custom-scrollbar::-webkit-scrollbar {
            height: 8px;
        }

        .custom-scrollbar::-webkit-scrollbar-track {
            background: #0f172a;
            /* slate-900 */
            border-radius: 4px;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #334155;
            /* slate-700 */
            border-radius: 4px;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb:hover {
            background: #475569;
            /* slate-600 */
        }
    </style>
@endpush

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Setup Chart
            const canvasEl = document.getElementById('sskDemographicChart');
            if (canvasEl) {
                if (typeof Chart !== 'undefined') {
                    const existingChart = Chart.getChart(canvasEl);
                    if (existingChart) {
                        existingChart.destroy();
                    }
                }
                const ctx = canvasEl.getContext('2d');
                const labels = JSON.parse(canvasEl.dataset.labels || '[]');
                const maleData = JSON.parse(canvasEl.dataset.male || '[]');
                const femaleData = JSON.parse(canvasEl.dataset.female || '[]');

                new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: labels,
                        datasets: [{
                                label: 'Laki-laki',
                                data: maleData,
                                backgroundColor: '#3b82f6',
                                borderRadius: 4,
                                barPercentage: 0.7,
                                categoryPercentage: 0.8
                            },
                            {
                                label: 'Perempuan',
                                data: femaleData,
                                backgroundColor: '#fbbf24',
                                borderRadius: 4,
                                barPercentage: 0.7,
                                categoryPercentage: 0.8
                            }
                        ]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        animation: {
                            duration: 1500,
                            easing: 'easeOutQuart'
                        },
                        interaction: {
                            intersect: false,
                            mode: 'index'
                        },
                        plugins: {
                            legend: {
                                display: false
                            },
                            tooltip: {
                                backgroundColor: '#1e293b', // slate-800 solid
                                borderColor: '#334155', // slate-700 solid border
                                borderWidth: 1,
                                padding: 12,
                                titleFont: {
                                    family: 'sans-serif',
                                    size: 13,
                                    weight: 'bold'
                                },
                                bodyFont: {
                                    family: 'sans-serif',
                                    size: 12
                                },
                                cornerRadius: 6,
                                displayColors: true
                            }
                        },
                        scales: {
                            x: {
                                grid: {
                                    display: false
                                },
                                ticks: {
                                    font: {
                                        family: 'sans-serif',
                                        size: 12,
                                        weight: '600'
                                    },
                                    color: '#cbd5e1'
                                } // slate-300
                            },
                            y: {
                                grid: {
                                    color: '#1e293b',
                                    borderDash: [4, 4]
                                }, // slate-800
                                ticks: {
                                    font: {
                                        family: 'sans-serif',
                                        size: 11
                                    },
                                    color: '#64748b',
                                    precision: 0
                                } // slate-500
                            }
                        }
                    }
                });
            }

            // Setup Counter Animation
            function animateCounters() {
                const counters = document.querySelectorAll('#ssk .counter-number');
                const duration = 2000;

                counters.forEach(counter => {
                    const target = parseFloat(counter.getAttribute('data-target'));
                    const decimals = parseInt(counter.getAttribute('data-decimals')) || 0;
                    const startTime = performance.now();

                    function updateNumber(currentTime) {
                        const elapsedTime = currentTime - startTime;
                        const progress = Math.min(elapsedTime / duration, 1);
                        const easeProgress = 1 - Math.pow(1 - progress, 4);
                        const currentValue = easeProgress * target;

                        counter.innerText = currentValue.toFixed(decimals);

                        if (progress < 1) {
                            requestAnimationFrame(updateNumber);
                        } else {
                            counter.innerText = target.toFixed(decimals);
                        }
                    }
                    requestAnimationFrame(updateNumber);
                });
            }

            // Intersection Observer Setup
            let animated = false;
            const observerOptions = {
                root: null,
                threshold: 0.15
            };
            const observer = new IntersectionObserver((entries, obs) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        const el = entry.target;
                        el.classList.remove('opacity-0', 'translate-y-8', '-translate-y-6');
                        el.classList.add('opacity-100', 'translate-y-0');

                        if (!animated) {
                            animateCounters();
                            animated = true;
                        }
                        obs.unobserve(el);
                    }
                });
            }, observerOptions);

            document.querySelectorAll('#ssk .reveal-item, #ssk .reveal-card').forEach(el => {
                observer.observe(el);
            });
        });
    </script>
@endpush
