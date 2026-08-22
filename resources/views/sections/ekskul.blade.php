{{-- resources/views/sections/ekskul.blade.php --}}
@php
    // Background Ekstrakurikuler dinamis dari pengaturan admin (fallback ke siswa-1.jpg jika belum diatur)
    $bgEkskul = setting('bg_ekskul') ? Storage::url(setting('bg_ekskul')) : asset('images/siswa-1.jpg');
@endphp

<!-- Section Full-Width Ekstrakurikuler (Padding Responsif untuk HP & Desktop) -->
<section id="ekskul" class="relative w-full bg-slate-950 py-12 sm:py-16 lg:py-24 overflow-hidden z-20"
    aria-label="Ekstrakurikuler Sekolah">

    <!-- Background Image Tipis (Subtle Overlay) -->
    <div class="absolute inset-0 z-0">
        <img src="{{ $bgEkskul }}" alt="Background Ekstrakurikuler"
            class="w-full h-full object-cover object-center opacity-100" loading="lazy" decoding="async">
        <div class="absolute inset-0 bg-slate-950/90"></div>
    </div>

    <!-- Konten Utama Ekstrakurikuler -->
    <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <!-- Header Seksi (Clean & Professional) -->
        <div class="reveal-item opacity-0 -translate-y-6 transition-all duration-700 max-w-2xl mb-8 sm:mb-12">
            <span
                class="inline-block px-2.5 py-0.5 sm:px-3 sm:py-1 rounded bg-slate-800 text-slate-300 text-[10px] sm:text-xs font-semibold uppercase tracking-wider mb-2.5 sm:mb-3">
                Pengembangan Diri
            </span>

            <h2 id="h-ekskul"
                class="font-serif text-2xl sm:text-3xl lg:text-5xl font-bold text-white tracking-tight leading-tight mb-2 sm:mb-3">
                Ekstrakurikuler Siswa
            </h2>

            <p class="text-slate-400 text-xs sm:text-sm lg:text-base font-normal leading-relaxed">
                Wadah pengembangan minat, bakat, kepemimpinan, dan kreativitas siswa di luar jam pelajaran
                {{ config('app.name') }}.
            </p>
        </div>

        <!-- Grid/Slider Kartu Ekskul dari Database -->
        <div class="w-full overflow-x-auto sm:overflow-visible pb-4 sm:pb-0 scrollbar-none">
            <div
                class="flex sm:grid sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6 lg:gap-8 w-max sm:w-full px-1 sm:px-0">

                @forelse ($ekskulItems ?? [] as $index => $e)
                    <a href="{{ route('ekskul.show', $e->slug) }}"
                        class="reveal-card opacity-0 translate-y-8 transition-all duration-700 bg-slate-900 border border-slate-800/80 hover:border-slate-700 rounded-xl overflow-hidden shadow-md flex flex-col justify-between group hover:-translate-y-1 w-72 sm:w-auto shrink-0"
                        style="transition-delay: {{ $index * 120 }}ms;">

                        <div>
                            <!-- Foto Visual Ekskul (Dari Database Storage) -->
                            <div class="relative w-full h-36 sm:h-44 overflow-hidden bg-slate-800">
                                @if ($e->cover_image)
                                    <img src="{{ Storage::url($e->cover_image) }}" alt="{{ $e->name }}"
                                        class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
                                        loading="lazy" decoding="async">
                                @else
                                    <div class="w-full h-full flex items-center justify-center text-slate-500">
                                        <i class="ti ti-photo text-3xl"></i>
                                    </div>
                                @endif

                                <!-- Badge Kategori di Atas Foto -->
                                @if ($e->category)
                                    <div
                                        class="absolute top-2.5 right-2.5 sm:top-3 sm:right-3 px-2.5 py-0.5 sm:py-1 rounded bg-slate-950/80 backdrop-blur-xs text-slate-200 border border-slate-700/60 text-[10px] sm:text-[11px] font-semibold">
                                        {{ $e->category }}
                                    </div>
                                @endif

                                <!-- Icon Badge -->
                                <div
                                    class="absolute bottom-2.5 left-2.5 sm:bottom-3 sm:left-3 w-8 h-8 sm:w-9 sm:h-9 rounded-lg bg-blue-600 text-white flex items-center justify-center text-base sm:text-lg shadow-md">
                                    <i class="ti {{ $e->icon ?? 'ti-star' }}" aria-hidden="true"></i>
                                </div>
                            </div>

                            <!-- Content Detail -->
                            <div class="p-4 sm:p-5">
                                <h3
                                    class="font-serif text-base sm:text-lg font-bold text-white group-hover:text-blue-400 transition-colors mb-1.5 sm:mb-2 truncate">
                                    {{ $e->name }}
                                </h3>

                                <p class="text-slate-400 text-xs sm:text-sm font-normal leading-relaxed line-clamp-3">
                                    {{ $e->short_description }}
                                </p>
                            </div>
                        </div>

                        <!-- Footer Kartu -->
                        <div
                            class="px-4 sm:px-5 pb-4 sm:pb-5 pt-2 border-t border-slate-800/60 flex items-center justify-between text-[11px] sm:text-xs font-semibold text-slate-400 group-hover:text-blue-400 transition-colors">
                            <span>Informasi Kegiatan</span>
                            <i class="ti ti-arrow-right text-xs sm:text-sm transform group-hover:translate-x-1 transition-transform"
                                aria-hidden="true"></i>
                        </div>

                    </a>
                @empty
                    <div class="col-span-full py-8 text-center text-slate-400 text-sm">
                        Belum ada data ekstrakurikuler yang ditayangkan.
                    </div>
                @endforelse

            </div>
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
                        el.classList.remove('opacity-0', 'translate-y-8', '-translate-y-6');
                        el.classList.add('opacity-100', 'translate-y-0');
                        observer.unobserve(el);
                    }
                });
            }, observerOptions);

            document.querySelectorAll('#ekskul .reveal-item, #ekskul .reveal-card').forEach(el => {
                observer.observe(el);
            });
        });
    </script>
@endpush
