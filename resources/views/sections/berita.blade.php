{{-- resources/views/sections/berita.blade.php --}}
<section id="berita"
    class="py-12 sm:py-16 md:py-24 bg-slate-100/60 border-t border-b border-slate-200/80 relative z-20"
    aria-labelledby="h-berita">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <!-- Header Seksi -->
        <div
            class="reveal-item opacity-0 -translate-y-6 transition-all duration-700 flex flex-col md:flex-row md:items-end justify-between gap-4 sm:gap-6 mb-8 sm:mb-12 pb-6 border-b-2 border-slate-300">
            <div class="max-w-2xl">
                <span
                    class="inline-block px-3 py-1 rounded-sm bg-slate-900 text-slate-100 text-[10px] sm:text-[11px] font-semibold uppercase tracking-widest mb-2.5 sm:mb-3">
                    Warta Sekolah
                </span>
                <h2 id="h-berita"
                    class="font-serif text-2xl sm:text-3xl md:text-4xl font-bold text-slate-900 leading-tight tracking-tight">
                    Berita & Artikel Terbaru
                </h2>
                <p class="text-slate-600 text-xs sm:text-sm md:text-base mt-2 font-serif italic leading-relaxed">
                    Kabar kegiatan, pengumuman resmi, dan pencapaian akademik dari lingkungan {{ config('app.name') }}.
                </p>
            </div>

            <div
                class="hidden sm:inline-flex items-center gap-2 px-3.5 py-2 bg-white border border-slate-300 rounded-sm text-slate-700 text-xs font-serif italic shrink-0">
                <i class="ti ti-news text-slate-800 text-base" aria-hidden="true"></i>
                <span>Edisi Terkini — {{ date('F Y') }}</span>
            </div>
        </div>

        <!-- Grid Cards Berita -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 sm:gap-8">
            @forelse ($beritaUtama as $index => $b)
                @php
                    $imgUrl = $b->image
                        ? (Str::startsWith($b->image, 'http')
                            ? $b->image
                            : Storage::url($b->image))
                        : 'https://images.unsplash.com/photo-1577896851231-70ef18881754?auto=format&fit=crop&w=800&q=80';
                @endphp
                <article
                    class="reveal-card opacity-0 translate-y-8 transition-all duration-700 group bg-white border border-slate-300 hover:border-slate-900 rounded-sm overflow-hidden p-3.5 sm:p-4 shadow-2xs hover:shadow-md transition-all flex flex-col justify-between"
                    style="transition-delay: {{ $index * 120 }}ms;">

                    <div>
                        <div
                            class="relative aspect-[16/10] overflow-hidden bg-slate-200 border border-slate-200 mb-3.5 sm:mb-4">
                            <img src="{{ $imgUrl }}" alt="{{ $b->title }}"
                                class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
                                loading="lazy" decoding="async">
                            <span
                                class="absolute top-2.5 left-2.5 px-2.5 py-1 bg-slate-900/90 text-white text-[10px] font-bold uppercase tracking-wider rounded-xs shadow-xs">
                                {{ $b->category }}
                            </span>
                        </div>

                        <div
                            class="flex items-center gap-1.5 sm:gap-2 text-[11px] sm:text-xs text-slate-500 font-serif italic mb-1.5 sm:mb-2">
                            <i class="ti ti-calendar text-slate-700 text-xs sm:text-sm"></i>
                            <time datetime="{{ $b->created_at }}">{{ $b->created_at->format('d M Y') }}</time>
                        </div>

                        <h3
                            class="font-serif text-base sm:text-lg font-bold text-slate-900 group-hover:text-blue-900 transition-colors line-clamp-2 leading-snug mb-2 sm:mb-3">
                            {{ $b->title }}
                        </h3>

                        <p
                            class="text-slate-600 text-xs sm:text-sm leading-relaxed line-clamp-3 font-normal mb-3 sm:mb-4">
                            {{ $b->excerpt }}
                        </p>
                    </div>

                    <div class="pt-3 border-t border-slate-200 flex items-center justify-between">
                        <a href="{{ route('berita.show', $b) }}"
                            class="inline-flex items-center gap-1.5 text-[11px] sm:text-xs font-bold text-slate-900 group-hover:text-blue-700 uppercase tracking-wider transition-colors">
                            <span>Baca Selengkapnya</span>
                            <i class="ti ti-arrow-right text-xs sm:text-sm transition-transform group-hover:translate-x-1"
                                aria-hidden="true"></i>
                        </a>
                    </div>
                </article>
            @empty
                <div class="col-span-full text-center py-12 text-slate-500 font-serif">
                    Belum ada berita atau artikel yang diterbitkan.
                </div>
            @endforelse
        </div>

        <!-- Tombol Arsip Berita -->
        <div class="mt-12 text-center">
            <a href="{{ route('berita.index') }}"
                class="inline-flex items-center gap-2 px-6 py-3 bg-slate-900 hover:bg-slate-800 text-white font-semibold text-xs sm:text-sm rounded-sm transition-all shadow-md">
                <span>Lihat Seluruh Arsip Berita</span>
                <i class="ti ti-arrow-right"></i>
            </a>
        </div>

    </div>
</section>
