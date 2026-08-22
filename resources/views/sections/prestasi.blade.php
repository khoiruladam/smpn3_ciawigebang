{{-- resources/views/sections/prestasi.blade.php --}}
@php
    $prestasiList = $prestasiItems ?? [];
@endphp

<!-- Section Prestasi: Background Solid & Padding Responsif -->
<section id="prestasi" class="py-12 sm:py-20 md:py-28 bg-white relative z-20 border-t border-slate-200"
    aria-labelledby="h-prestasi">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <!-- Header Seksi -->
        <div
            class="reveal-item opacity-0 -translate-y-8 transition-all duration-700 ease-out flex flex-col md:flex-row md:items-end justify-between gap-4 sm:gap-6 mb-8 sm:mb-12 md:mb-16 pb-6 border-b border-slate-200">
            <div class="max-w-2xl">
                <span
                    class="inline-flex items-center gap-2 px-3 py-1 sm:px-3.5 sm:py-1.5 rounded-full bg-blue-50 border border-blue-200 text-blue-800 text-[11px] sm:text-xs font-bold uppercase tracking-wider mb-2.5 sm:mb-3">
                    <i class="ti ti-trophy text-amber-500 text-sm" aria-hidden="true"></i>
                    <span>Pencapaian Siswa</span>
                </span>
                <h2 id="h-prestasi"
                    class="font-serif text-2xl sm:text-3xl md:text-4xl font-extrabold text-slate-900 leading-tight">
                    Prestasi & Penghargaan
                </h2>
                <p class="text-slate-600 text-xs sm:text-sm md:text-base mt-2 leading-relaxed">
                    Deretan piala, medali, dan piagam yang telah diraih oleh siswa serta sekolah dari tahun ke tahun
                    {{ config('app.name') }}.
                </p>
            </div>

            <!-- Total Counter Badge -->
            <div
                class="inline-flex items-center gap-3 px-3.5 py-2 sm:px-4 sm:py-2.5 bg-slate-50 border border-slate-200 rounded-xl shadow-sm shrink-0 self-start md:self-auto">
                <div
                    class="w-7 h-7 sm:w-8 sm:h-8 rounded-lg bg-amber-500/10 text-amber-600 flex items-center justify-center font-bold text-xs sm:text-sm">
                    <i class="ti ti-award text-sm sm:text-base"></i>
                </div>
                <div class="flex flex-col">
                    <span class="text-[11px] sm:text-xs font-bold text-slate-900">{{ $totalPrestasiCount ?? 0 }}+
                        Penghargaan</span>
                    <span class="text-[10px] sm:text-[11px] text-slate-500">Kabupaten s/d Nasional</span>
                </div>
            </div>
        </div>

        <!-- Section Visualisasi Grafik -->
        @if (!empty($chartYears) && count($chartYears) > 0)
            <div
                class="reveal-card opacity-0 translate-y-10 transition-all duration-700 bg-slate-50 hover:bg-white border border-slate-200 rounded-2xl p-4 sm:p-6 md:p-8 shadow-sm hover:shadow-xl mb-8 sm:mb-12">
                <div
                    class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 sm:gap-4 mb-4 sm:mb-6 pb-4 border-b border-slate-200">
                    <div>
                        <span
                            class="inline-flex items-center gap-1.5 px-2.5 py-0.5 sm:px-3 sm:py-1 rounded-full bg-amber-50 border border-amber-200 text-amber-800 text-[10px] sm:text-xs font-bold uppercase tracking-wider mb-1">
                            <i class="ti ti-chart-line text-amber-600"></i>
                            <span>Grafik Pertumbuhan</span>
                        </span>
                        <h3 class="font-serif text-lg sm:text-xl md:text-2xl font-bold text-slate-900">
                            Rekapitulasi Raihan Juara Per Tahun
                        </h3>
                    </div>
                    <div class="flex items-center gap-2 text-[11px] sm:text-xs font-semibold text-slate-600">
                        <span class="w-2.5 h-2.5 sm:w-3 sm:h-3 rounded-full bg-blue-600 inline-block"></span>
                        <span>Total Kejuaraan Diraih</span>
                    </div>
                </div>

                <div class="w-full h-48 sm:h-56 md:h-64">
                    <canvas id="prestasiYearlyChart"></canvas>
                </div>
            </div>
        @endif

        <!-- Grid Kartu Highlight Prestasi -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 sm:gap-6 md:gap-8">
            @forelse ($prestasiList as $index => $p)
                <a href="{{ route('prestasi.show', $p->slug) }}"
                    class="reveal-card opacity-0 translate-y-12 transition-all duration-700 ease-out group bg-slate-50 hover:bg-white border border-slate-200 hover:border-blue-400 rounded-2xl overflow-hidden shadow-sm hover:shadow-xl hover:-translate-y-1.5 flex flex-col justify-between"
                    style="transition-delay: {{ $index * 120 }}ms;">

                    <div>
                        <!-- Container Foto Kejuaraan -->
                        <div class="relative w-full h-44 sm:h-48 overflow-hidden bg-slate-200">
                            @if ($p->cover_image)
                                <img src="{{ Storage::url($p->cover_image) }}" alt="{{ $p->title }}"
                                    class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
                                    loading="lazy" decoding="async">
                            @else
                                <div class="w-full h-full flex items-center justify-center text-slate-400 bg-slate-100">
                                    <i class="ti ti-trophy text-4xl"></i>
                                </div>
                            @endif

                            <!-- Badge Tahun di Atas Foto -->
                            <div class="absolute top-3 right-3">
                                <span
                                    class="px-2.5 py-1 bg-slate-950/80 backdrop-blur-xs text-white border border-slate-700/60 text-[10px] sm:text-xs font-bold rounded-md shadow-xs">
                                    {{ $p->year }}
                                </span>
                            </div>
                        </div>

                        <!-- Konten Teks -->
                        <div class="p-4 sm:p-6">
                            <div class="flex items-center gap-3 mb-3">
                                <div
                                    class="w-9 h-9 sm:w-10 sm:h-10 rounded-xl bg-amber-500/10 border border-amber-500/20 text-amber-600 group-hover:bg-blue-600 group-hover:text-white group-hover:border-blue-600 flex items-center justify-center text-lg sm:text-xl transition-colors duration-300 shadow-2xs shrink-0">
                                    <i class="ti {{ $p->icon ?? 'ti-trophy' }}" aria-hidden="true"></i>
                                </div>
                                <span
                                    class="text-[11px] sm:text-xs font-semibold text-blue-700 uppercase tracking-wider">
                                    {{ $p->category ?? 'Prestasi Sekolah' }}
                                </span>
                            </div>

                            <h3
                                class="font-serif text-base sm:text-lg font-bold text-slate-900 group-hover:text-blue-900 transition-colors leading-snug">
                                {{ $p->title }}
                            </h3>
                        </div>
                    </div>

                    <!-- Footer Kartu -->
                    <div
                        class="px-4 sm:px-6 pb-4 sm:pb-6 pt-3 border-t border-slate-200 flex items-center justify-between text-[11px] sm:text-xs font-semibold text-slate-600 group-hover:text-blue-700 transition-colors">
                        <div class="flex items-center gap-1.5">
                            <i class="ti ti-medal text-amber-500 text-xs sm:text-sm" aria-hidden="true"></i>
                            <span>Dokumentasi Prestasi</span>
                        </div>
                        <i class="ti ti-arrow-right text-xs sm:text-sm transform group-hover:translate-x-1 transition-transform"
                            aria-hidden="true"></i>
                    </div>

                </a>
            @empty
                <div
                    class="col-span-full py-12 text-center text-slate-500 text-sm bg-slate-50 rounded-2xl border border-slate-200">
                    Belum ada data prestasi yang ditayangkan.
                </div>
            @endforelse
        </div>

    </div>
</section>

@push('scripts')
    @if (!empty($chartYears) && count($chartYears) > 0)
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                let chartInstance = null;

                function initPrestasiChart() {
                    const canvas = document.getElementById('prestasiYearlyChart');
                    if (!canvas || chartInstance) return;

                    const ctx = canvas.getContext('2d');
                    chartInstance = new Chart(ctx, {
                        type: 'line',
                        data: {
                            labels: @json($chartYears),
                            datasets: [{
                                label: 'Jumlah Kejuaraan',
                                data: @json($chartCounts),
                                borderColor: '#2563eb',
                                backgroundColor: 'rgba(37, 99, 235, 0.12)',
                                borderWidth: 3,
                                fill: true,
                                tension: 0.4,
                                pointBackgroundColor: '#f59e0b',
                                pointBorderColor: '#ffffff',
                                pointBorderWidth: 2,
                                pointRadius: 5,
                                pointHoverRadius: 8
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            plugins: {
                                legend: {
                                    display: false
                                },
                                tooltip: {
                                    backgroundColor: '#0f172a',
                                    padding: 10,
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
                                            weight: '600'
                                        },
                                        color: '#475569'
                                    }
                                },
                                y: {
                                    min: 0,
                                    grid: {
                                        color: '#e2e8f0',
                                        borderDash: [4, 4]
                                    },
                                    ticks: {
                                        color: '#64748b',
                                        stepSize: 1
                                    }
                                }
                            }
                        }
                    });
                }

                const observerOptions = {
                    root: null,
                    threshold: 0.15
                };
                const observer = new IntersectionObserver((entries, observer) => {
                    entries.forEach(entry => {
                        if (entry.isIntersecting) {
                            const el = entry.target;
                            el.classList.remove('opacity-0', 'translate-y-12', 'translate-y-10',
                                '-translate-y-8');
                            el.classList.add('opacity-100', 'translate-y-0');
                            initPrestasiChart();
                            observer.unobserve(el);
                        }
                    });
                }, observerOptions);

                document.querySelectorAll('#prestasi .reveal-item, #prestasi .reveal-card').forEach(el => {
                    observer.observe(el);
                });
            });
        </script>
    @endif
@endpush
