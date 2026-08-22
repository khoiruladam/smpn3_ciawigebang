{{-- resources/views/sections/ssk.blade.php --}}
@php
    // Background SSK dinamis dari pengaturan admin (fallback ke sekolah-2.jpg)
    $bgHeroStyle = setting('bg_ssk') ? Storage::url(setting('bg_ssk')) : asset('images/sekolah-2.jpg');

    // Mengambil data Statistik SSK dari database (jika model/tabel ada, jika belum gunakan fallback array)
    $sskItems = isset($sskItems)
        ? $sskItems
        : (class_exists(\App\Models\SskStat::class)
            ? \App\Models\SskStat::orderBy('sort_order')->get()
            : collect());

    if ($sskItems->isEmpty()) {
        $sskItems = collect([
            (object) [
                'icon' => 'ti-school',
                'label' => 'Rombongan Belajar',
                'value' => 18,
                'suffix' => '',
                'decimals' => 0,
                'sub' => 'Kelas VII - IX',
            ],
            (object) [
                'icon' => 'ti-users',
                'label' => 'Peserta Didik',
                'value' => 540,
                'suffix' => '+',
                'decimals' => 0,
                'sub' => 'Siswa Aktif',
            ],
            (object) [
                'icon' => 'ti-user-check',
                'label' => 'Guru & Staf',
                'value' => 32,
                'suffix' => '',
                'decimals' => 0,
                'sub' => 'Tenaga Pendidik',
            ],
            (object) [
                'icon' => 'ti-map-2',
                'label' => 'Luas Lahan',
                'value' => 1.5,
                'suffix' => '',
                'decimals' => 1,
                'sub' => 'Hektar (Ha)',
            ],
        ]);
    }

    // Mengambil data Demografi dari database (jika model/tabel ada, jika belum gunakan fallback array)
    $demographics = isset($demographics)
        ? $demographics
        : (class_exists(\App\Models\SskDemographic::class)
            ? \App\Models\SskDemographic::orderBy('sort_order')->get()
            : collect());

    if ($demographics->isEmpty()) {
        $demographics = collect([
            (object) ['kelas' => 'Kelas VII', 'male_count' => 95, 'female_count' => 90],
            (object) ['kelas' => 'Kelas VIII', 'male_count' => 92, 'female_count' => 88],
            (object) ['kelas' => 'Kelas IX', 'male_count' => 88, 'female_count' => 87],
        ]);
    }
@endphp

<!-- Section Full-Width Berstyle Hero Section -->
<section id="ssk" class="relative w-full bg-slate-950 py-20 lg:py-28 overflow-hidden z-20"
    aria-label="Sekolah Siaga Kependudukan">

    <!-- Background Image & Dark Gradient Overlay -->
    <div class="absolute inset-0 z-0">
        <img src="{{ $bgHeroStyle }}" alt="Background SSK Hero Style" class="w-full h-full object-cover object-center"
            loading="lazy" decoding="async">
        <div class="absolute inset-0 bg-gradient-to-r from-slate-950 via-slate-950/90 to-slate-950/70"></div>
    </div>

    <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <div class="reveal-item opacity-0 -translate-y-6 transition-all duration-700 max-w-2xl mb-12">
            <div
                class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-blue-600/35 backdrop-blur-md border border-blue-400/30 text-blue-200 text-xs sm:text-sm font-semibold mb-4 shadow-md">
                <i class="ti ti-chart-dots text-amber-400 text-base" aria-hidden="true"></i>
                <span>Data & Statistik SSK</span>
            </div>

            <h2 id="h-ssk"
                class="font-serif text-3xl sm:text-4xl lg:text-5xl font-extrabold text-white tracking-tight leading-tight drop-shadow-md mb-3">
                Sekolah Siaga Kependudukan
            </h2>

            <p class="text-slate-300 text-sm sm:text-base font-light leading-relaxed drop-shadow">
                Gambaran statistik data pokok, demografi peserta didik, dan standar sarana di {{ config('app.name') }}.
            </p>
        </div>

        <div
            class="reveal-item opacity-0 -translate-y-6 transition-all duration-700 grid grid-cols-2 md:grid-cols-4 gap-6 sm:gap-8 divide-y md:divide-y-0 md:divide-x divide-white/15 pb-12">
            @foreach ($sskItems as $index => $s)
                <div class="flex items-center gap-4 {{ $index > 0 ? 'pt-4 md:pt-0 md:pl-6' : '' }}">
                    <div
                        class="w-12 h-12 rounded-xl bg-amber-500/10 border border-amber-500/30 text-amber-400 flex items-center justify-center text-2xl shrink-0 shadow-lg backdrop-blur-md">
                        <i class="ti {{ $s->icon ?? 'ti-chart-bar' }}" aria-hidden="true"></i>
                    </div>

                    <div class="flex flex-col">
                        <span
                            class="counter-number font-serif text-2xl sm:text-4xl font-extrabold text-white tracking-tight leading-none mb-1"
                            data-target="{{ $s->value }}" data-suffix="{{ $s->suffix ?? '' }}"
                            data-decimals="{{ $s->decimals ?? 0 }}">
                            0{{ $s->suffix ?? '' }}
                        </span>
                        <span class="text-xs sm:text-sm font-semibold text-slate-200">
                            {{ $s->label }}
                        </span>
                        @if (!empty($s->sub))
                            <span class="text-[11px] text-slate-400 font-light mt-0.5">
                                {{ $s->sub }}
                            </span>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>

        <div
            class="reveal-card opacity-0 translate-y-8 transition-all duration-700 bg-white/10 hover:bg-white/15 border border-white/20 rounded-2xl p-6 sm:p-8 backdrop-blur-xl shadow-2xl">

            <div
                class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6 pb-4 border-b border-white/15">
                <div>
                    <h3 class="font-serif text-lg sm:text-2xl font-bold text-white tracking-wide">
                        Distribusi Peserta Didik Per Tingkat
                    </h3>
                    <p class="text-xs text-slate-300 font-light mt-1">Perbandingan jumlah siswa Laki-laki dan Perempuan
                    </p>
                </div>

                <div class="flex items-center gap-4 text-xs font-semibold text-slate-200">
                    <div class="flex items-center gap-2">
                        <span class="w-3 h-3 rounded-full bg-blue-500 inline-block shadow-xs"></span>
                        <span>Siswa Laki-laki</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="w-3 h-3 rounded-full bg-amber-400 inline-block shadow-xs"></span>
                        <span>Siswa Perempuan</span>
                    </div>
                </div>
            </div>

            <div class="w-full h-60 sm:h-72">
                <canvas id="sskDemographicChart" data-labels="{{ $demographics->pluck('kelas')->toJson() }}"
                    data-male="{{ $demographics->pluck('male_count')->toJson() }}"
                    data-female="{{ $demographics->pluck('female_count')->toJson() }}"></canvas>
            </div>

        </div>

    </div>
</section>

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const canvasEl = document.getElementById('sskDemographicChart');
            if (!canvasEl) return;
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
                            borderRadius: 6,
                            borderSkipped: false,
                        },
                        {
                            label: 'Perempuan',
                            data: femaleData,
                            backgroundColor: '#fbbf24',
                            borderRadius: 6,
                            borderSkipped: false,
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
                    plugins: {
                        legend: {
                            display: false
                        },
                        tooltip: {
                            backgroundColor: '#0f172a',
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
                            cornerRadius: 8
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
                                color: '#e2e8f0'
                            }
                        },
                        y: {
                            grid: {
                                color: 'rgba(255, 255, 255, 0.15)',
                                borderDash: [4, 4]
                            },
                            ticks: {
                                font: {
                                    family: 'sans-serif',
                                    size: 11
                                },
                                color: '#94a3b8'
                            }
                        }
                    }
                }
            });

            function animateCounters() {
                const counters = document.querySelectorAll('#ssk .counter-number');
                const duration = 2000;

                counters.forEach(counter => {
                    const target = parseFloat(counter.getAttribute('data-target'));
                    const suffix = counter.getAttribute('data-suffix') || '';
                    const decimals = parseInt(counter.getAttribute('data-decimals')) || 0;
                    const startTime = performance.now();

                    function updateNumber(currentTime) {
                        const elapsedTime = currentTime - startTime;
                        const progress = Math.min(elapsedTime / duration, 1);
                        const easeProgress = 1 - Math.pow(1 - progress, 4);
                        const currentValue = easeProgress * target;

                        counter.innerText = currentValue.toFixed(decimals) + suffix;

                        if (progress < 1) {
                            requestAnimationFrame(updateNumber);
                        } else {
                            counter.innerText = target.toFixed(decimals) + suffix;
                        }
                    }

                    requestAnimationFrame(updateNumber);
                });
            }

            let animated = false;
            const observerOptions = {
                root: null,
                threshold: 0.2
            };

            const observer = new IntersectionObserver((entries, observer) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        const el = entry.target;
                        el.classList.remove('opacity-0', 'translate-y-8', '-translate-y-6');
                        el.classList.add('opacity-100', 'translate-y-0');

                        if (!animated) {
                            animateCounters();
                            animated = true;
                        }
                        observer.unobserve(el);
                    }
                });
            }, observerOptions);

            document.querySelectorAll('#ssk .reveal-item, #ssk .reveal-card').forEach(el => {
                observer.observe(el);
            });
        });
    </script>
@endpush
