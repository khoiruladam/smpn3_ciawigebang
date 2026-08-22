{{-- resources/views/sections/fasilitas.blade.php --}}
{{-- $fasilitas idealnya dikirim dari route utama, contoh:
     'fasilitas' => \App\Models\Facility::where('is_published', true)->orderBy('sort_order')->get(),
--}}
@php
    $fasilitas = $fasilitas ?? collect([]);
@endphp

<section id="fasilitas" class="py-12 sm:py-20 md:py-28 bg-white relative z-20 border-t border-slate-200"
    aria-labelledby="h-fasilitas">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <div
            class="reveal-item opacity-0 -translate-y-8 transition-all duration-700 ease-out flex flex-col md:flex-row md:items-end justify-between gap-4 sm:gap-6 mb-8 sm:mb-12 md:mb-16 pb-6 sm:pb-8 border-b border-slate-200">
            <div class="max-w-2xl">
                <span
                    class="inline-flex items-center gap-2 px-3 py-1 sm:px-3.5 sm:py-1.5 rounded-full bg-blue-50 border border-blue-200 text-blue-800 text-[11px] sm:text-xs font-bold uppercase tracking-wider mb-2.5 sm:mb-3">
                    <i class="ti ti-layout-grid text-blue-600" aria-hidden="true"></i>
                    <span>Sarana & Prasarana</span>
                </span>
                <h2 id="h-fasilitas"
                    class="font-serif text-2xl sm:text-3xl md:text-4xl font-extrabold text-slate-900 leading-tight">
                    Fasilitas Sekolah Modern
                </h2>
                <p class="text-slate-600 text-xs sm:text-sm md:text-base mt-2 leading-relaxed">
                    Sarana pendukung pembelajaran yang lengkap, kondusif, dan aman untuk mengoptimalkan potensi siswa.
                </p>

                @if ($fasilitas->count())
                    <div class="flex flex-wrap items-center gap-1.5 sm:gap-2 mt-3.5 sm:mt-4">
                        <span
                            class="text-[11px] sm:text-xs font-bold text-slate-500 uppercase tracking-wider mr-1">Tersedia:</span>
                        @foreach ($fasilitas as $f)
                            <span
                                class="px-2 py-0.5 sm:px-2.5 sm:py-1 rounded-md bg-slate-100 text-slate-700 text-[11px] sm:text-xs font-semibold border border-slate-200">
                                {{ $f->name }}
                            </span>
                        @endforeach
                    </div>
                @endif
            </div>

            @if ($fasilitas->count())
                <div
                    class="inline-flex items-center gap-3 px-3.5 py-2 sm:px-4 sm:py-2.5 bg-slate-50 border border-slate-200 rounded-xl shadow-sm shrink-0 self-start md:self-auto">
                    <div
                        class="w-7 h-7 sm:w-8 sm:h-8 rounded-lg bg-amber-500/10 text-amber-600 flex items-center justify-center font-bold text-xs sm:text-sm">
                        {{ $fasilitas->count() }}+
                    </div>
                    <div class="flex flex-col">
                        <span class="text-[11px] sm:text-xs font-bold text-slate-900">Fasilitas Utama</span>
                        <span class="text-[10px] sm:text-[11px] text-slate-500">Siap Digunakan</span>
                    </div>
                </div>
            @endif
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6 md:gap-8">
            @forelse ($fasilitas as $index => $f)
                {{-- Seluruh kartu jadi link ke halaman detail, buka tab baru --}}
                <a href="{{ route('facilities.show', $f) }}" target="_blank" rel="noopener"
                    class="reveal-card opacity-0 translate-y-12 transition-all duration-700 ease-out group bg-slate-50 hover:bg-white border border-slate-200 hover:border-blue-400 rounded-2xl p-5 sm:p-6 md:p-8 shadow-sm hover:shadow-xl hover:-translate-y-1.5 flex flex-col justify-between"
                    style="transition-delay: {{ $index * 100 }}ms;">

                    <div>
                        <div class="flex items-center justify-between gap-4 mb-4 sm:mb-6">
                            <div
                                class="w-10 h-10 sm:w-12 sm:h-12 rounded-xl bg-blue-50 text-blue-600 border border-blue-100 group-hover:bg-blue-600 group-hover:text-white flex items-center justify-center text-xl sm:text-2xl transition-all duration-300 shadow-2xs group-hover:scale-110 shrink-0">
                                <i class="ti {{ $f->icon }}" aria-hidden="true"></i>
                            </div>

                            @if ($f->tag)
                                <span
                                    class="px-2 py-0.5 sm:px-2.5 sm:py-1 rounded-md bg-slate-200/70 text-slate-700 border border-slate-300 text-[10px] sm:text-[11px] font-semibold tracking-wide">
                                    {{ $f->tag }}
                                </span>
                            @endif
                        </div>

                        <h3
                            class="font-serif text-base sm:text-lg md:text-xl font-bold text-slate-900 group-hover:text-blue-900 transition-colors mb-2">
                            {{ $f->name }}
                        </h3>

                        <p class="text-slate-600 text-xs sm:text-sm leading-relaxed">
                            {{ $f->short_description }}
                        </p>
                    </div>

                    <div
                        class="pt-3 sm:pt-4 mt-3 sm:mt-4 border-t border-slate-200 flex items-center justify-between text-[11px] sm:text-xs font-semibold text-blue-600 group-hover:text-blue-800 transition-colors">
                        <span>Baca Detail</span>
                        <i class="ti ti-arrow-right text-xs sm:text-sm transform group-hover:translate-x-1 transition-transform"
                            aria-hidden="true"></i>
                    </div>

                </a>
            @empty
                <div class="col-span-full text-center text-slate-400 py-12">
                    Belum ada data fasilitas.
                </div>
            @endforelse
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

            document.querySelectorAll('#fasilitas .reveal-item, #fasilitas .reveal-card').forEach(el => {
                observer.observe(el);
            });
        });
    </script>
@endpush
