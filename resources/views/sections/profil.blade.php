{{-- resources/views/sections/profil.blade.php --}}
@php
    $defaultProfil = [
        [
            'icon' => 'ti-target-arrow',
            'label' => 'Visi Sekolah',
            'text' =>
                'Terwujudnya peserta didik yang unggul dalam prestasi, berkarakter mulia, menguasai teknologi, dan berwawasan lingkungan.',
            'icon_bg' => 'bg-blue-50 text-blue-600 border-blue-100',
            'badge' => 'Fokus Utama',
            'keterangan' => 'Landasan utama arah pengembangan kurikulum dan pembinaan karakter di sekolah.',
        ],
        [
            'icon' => 'ti-list-check',
            'label' => 'Misi Sekolah',
            'text' =>
                'Menyelenggarakan pembelajaran inovatif berbasis TIK, menguatkan profil pelajar Pancasila, serta membangun sinergi dengan masyarakat.',
            'icon_bg' => 'bg-emerald-50 text-emerald-600 border-emerald-100',
            'badge' => 'Implementasi',
            'keterangan' =>
                'Langkah strategis harian untuk merealisasikan visi pendidikan melalui kegiatan akademik & non-akademik.',
        ],
        [
            'icon' => 'ti-award',
            'label' => 'Akreditasi A',
            'text' =>
                'Terakreditasi A (Unggul) oleh Badan Akreditasi Nasional Sekolah/Madrasah (BAN-S/M) dengan nilai mutu pendidikan tinggi.',
            'icon_bg' => 'bg-amber-50 text-amber-600 border-amber-100',
            'badge' => 'Standar Mutu',
            'keterangan' => 'Pengakuan resmi atas kualitas sarana, prasarana, pengajar, dan manajemen sekolah.',
        ],
    ];

    $profilPoints = setting('profil_points_data') ? json_decode(setting('profil_points_data'), true) : $defaultProfil;
@endphp

<!-- Seksi Profil: Padding disesuaikan agar di HP tidak terlalu besar/longgar -->
<section id="profil" class="py-12 sm:py-20 md:py-28 bg-white relative z-25 border-t border-slate-200"
    aria-labelledby="h-profil">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <!-- Header Seksi Layout Kiri & Kanan -->
        <div
            class="reveal-item opacity-0 -translate-y-8 transition-all duration-700 ease-out flex flex-col md:flex-row md:items-end justify-between gap-4 sm:gap-6 mb-8 sm:mb-12 md:mb-16 pb-6 border-b border-slate-200">
            <div class="max-w-2xl">
                <span
                    class="inline-flex items-center gap-2 px-3 py-1 sm:px-3.5 sm:py-1.5 rounded-full bg-blue-50 border border-blue-200 text-blue-800 text-[11px] sm:text-xs font-bold uppercase tracking-wider mb-2.5 sm:mb-3">
                    <i class="ti ti-building text-blue-600" aria-hidden="true"></i>
                    <span>Tentang Kami</span>
                </span>
                <h2 id="h-profil"
                    class="font-serif text-2xl sm:text-3xl md:text-4xl font-extrabold text-slate-900 leading-tight">
                    Profil & Landasan Utama
                </h2>
                <p class="text-slate-600 text-xs sm:text-sm md:text-base mt-2 leading-relaxed">
                    Mengenal lebih dekat komitmen mutu, visi misi, dan fondasi pendidikan di {{ config('app.name') }}.
                </p>
            </div>

            <!-- Action Button Konsisten -->
            <a href="#ssk"
                class="inline-flex items-center gap-2 px-4 py-2 sm:px-4.5 sm:py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-semibold text-xs sm:text-sm rounded-xl shadow-sm transition-all shrink-0 self-start md:self-auto">
                <span>Selengkapnya tentang SSK</span>
                <i class="ti ti-arrow-right text-base" aria-hidden="true"></i>
            </a>
        </div>

        <!-- Cards Grid Profil -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 sm:gap-6 md:gap-8">
            @foreach ($profilPoints as $index => $p)
                <div class="reveal-card opacity-0 translate-y-12 transition-all duration-700 ease-out group bg-slate-50 hover:bg-white border border-slate-200 hover:border-blue-400 rounded-2xl p-5 sm:p-6 md:p-8 shadow-sm hover:shadow-xl hover:-translate-y-1.5 flex flex-col justify-between"
                    style="transition-delay: {{ $index * 150 }}ms;">

                    <div>
                        <!-- Header Kartu: Icon Box + Badge Kategori -->
                        <div class="flex items-center justify-between gap-4 mb-4 sm:mb-6">
                            <div
                                class="w-10 h-10 sm:w-12 sm:h-12 rounded-xl border flex items-center justify-center text-lg sm:text-xl transition-all duration-300 group-hover:scale-110 shrink-0 {{ $p['icon_bg'] }}">
                                <i class="ti {{ $p['icon'] }}" aria-hidden="true"></i>
                            </div>

                            <span
                                class="px-2.5 py-0.5 sm:px-3 sm:py-1 rounded-full bg-slate-200/70 text-slate-700 border border-slate-300 text-[10px] sm:text-[11px] font-bold tracking-wide uppercase">
                                {{ $p['badge'] }}
                            </span>
                        </div>

                        <!-- Judul Poin -->
                        <h3
                            class="font-serif text-lg sm:text-xl font-bold text-slate-900 group-hover:text-blue-900 transition-colors mb-2 sm:mb-3">
                            {{ $p['label'] }}
                        </h3>

                        <!-- Deskripsi Utama (Tersinkron dengan Database Admin) -->
                        <p class="text-slate-600 text-xs sm:text-sm md:text-base leading-relaxed mb-3 sm:mb-4">
                            {{ $p['text'] }}
                        </p>
                    </div>

                    <!-- Keterangan Tambahan -->
                    @if (!empty($p['keterangan']))
                        <div class="pt-3 sm:pt-4 mt-2 border-t border-slate-200">
                            <p class="text-[11px] sm:text-xs text-slate-500 leading-normal flex items-start gap-1.5">
                                <i class="ti ti-info-circle text-blue-600 text-sm shrink-0 mt-0.5"
                                    aria-hidden="true"></i>
                                <span>{{ $p['keterangan'] }}</span>
                            </p>
                        </div>
                    @endif

                </div>
            @endforeach
        </div>

    </div>
</section>

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const observerOptions = {
                root: null,
                threshold: 0.15
            };

            const observer = new IntersectionObserver((entries, observer) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        const el = entry.target;
                        el.classList.remove('opacity-0', 'translate-y-12', '-translate-y-8');
                        el.classList.add('opacity-100', 'translate-y-0');
                        observer.unobserve(el);
                    }
                });
            }, observerOptions);

            document.querySelectorAll('#profil .reveal-item, #profil .reveal-card').forEach(el => {
                observer.observe(el);
            });
        });
    </script>
@endpush
