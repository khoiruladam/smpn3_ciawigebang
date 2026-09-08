{{-- resources/views/sections/galeri.blade.php --}}
<section id="galeri" class="py-12 sm:py-16 md:py-24 bg-slate-50 border-t border-slate-200/80 relative z-20"
    aria-labelledby="h-galeri">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <!-- Header Seksi -->
        <div
            class="reveal-item opacity-0 -translate-y-6 transition-all duration-700 ease-out flex flex-col md:flex-row md:items-end justify-between gap-4 sm:gap-6 mb-8 sm:mb-12 pb-6 border-b border-slate-200">
            <div class="max-w-2xl">
                <span
                    class="inline-block px-3 py-1 rounded-md bg-blue-100 text-blue-800 text-[11px] sm:text-xs font-semibold uppercase tracking-wider mb-2.5 sm:mb-3">
                    Dokumentasi
                </span>
                <h2 id="h-galeri"
                    class="font-serif text-2xl sm:text-3xl md:text-4xl font-bold text-slate-900 leading-tight">
                    Galeri & Kegiatan Sekolah
                </h2>
                <p class="text-slate-600 text-xs sm:text-sm md:text-base mt-2 leading-relaxed">
                    Kumpulan momen penting, aktivitas belajar mengajar, dan kegiatan di {{ config('app.name') }}.
                </p>
            </div>

            <!-- Total Counter Badge -->
            <div
                class="inline-flex items-center gap-3 px-3.5 py-2 sm:px-4 sm:py-2.5 bg-white border border-slate-200 rounded-xl shadow-xs shrink-0 self-start md:self-auto">
                <div
                    class="w-7 h-7 sm:w-8 sm:h-8 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center font-bold text-xs sm:text-sm">
                    <i class="ti ti-camera text-sm sm:text-base" aria-hidden="true"></i>
                </div>
                <div class="flex flex-col">
                    <span class="text-[11px] sm:text-xs font-bold text-slate-900">Dokumentasi</span>
                    <span class="text-[10px] sm:text-[11px] text-slate-500">Foto & Media Terbaru</span>
                </div>
            </div>
        </div>

        <!-- Grid Foto Dokumentasi -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6 md:gap-8">
            @forelse ($fotos->take(3) as $index => $foto)
                @php
                    $isFeatured = $foto->is_featured;
                    $imgUrl = Str::startsWith($foto->image, 'http') ? $foto->image : Storage::url($foto->image);
                @endphp

                <div class="reveal-card opacity-0 translate-y-8 transition-all duration-700 ease-out group bg-white border border-slate-200 hover:border-blue-400 rounded-2xl overflow-hidden shadow-xs hover:shadow-md transition-all flex flex-col justify-between cursor-pointer gallery-card"
                    style="transition-delay: {{ $index * 100 }}ms;" data-image="{{ $imgUrl }}"
                    data-title="{{ $foto->title }}"
                    data-caption="{{ $foto->caption ?? 'Tidak ada deskripsi tersedia untuk momen ini.' }}"
                    data-category="{{ $foto->category }}">

                    <!-- Image Container -->
                    <div class="relative w-full overflow-hidden bg-slate-900 h-48 sm:h-56">
                        <img src="{{ $imgUrl }}" alt="{{ $foto->title }}"
                            class="w-full h-full object-cover transform group-hover:scale-105 transition-transform duration-500"
                            loading="lazy" decoding="async">

                        <div class="absolute top-3 left-3 flex items-center gap-2">
                            @if ($isFeatured)
                                <span
                                    class="px-2.5 py-0.5 sm:px-3 sm:py-1 bg-amber-500 text-slate-950 text-[11px] sm:text-xs font-bold rounded-md shadow-xs flex items-center gap-1.5">
                                    <i class="ti ti-star-filled text-[10px] sm:text-xs"></i>
                                    <span>Momen Utama</span>
                                </span>
                            @else
                                <span
                                    class="px-2 py-0.5 sm:px-2.5 sm:py-1 bg-slate-900/80 backdrop-blur-xs text-white text-[10px] sm:text-[11px] font-medium rounded-md border border-white/20">
                                    {{ $foto->category }}
                                </span>
                            @endif
                        </div>

                        <div
                            class="absolute inset-0 bg-slate-950/20 group-hover:bg-slate-950/40 transition-colors flex items-center justify-center opacity-0 group-hover:opacity-100">
                            <div
                                class="w-9 h-9 sm:w-10 sm:h-10 rounded-full bg-white text-slate-900 flex items-center justify-center shadow-lg transform scale-90 group-hover:scale-100 transition-transform">
                                <i class="ti ti-maximize text-base sm:text-lg" aria-hidden="true"></i>
                            </div>
                        </div>
                    </div>

                    <!-- Description Box -->
                    <div class="p-3.5 sm:p-5 flex items-center justify-between gap-4 bg-white">
                        <div>
                            <span
                                class="block text-[10px] sm:text-[11px] font-bold text-blue-600 uppercase tracking-wider mb-0.5">
                                {{ $foto->category }}
                            </span>
                            <h3
                                class="font-serif text-xs sm:text-sm md:text-base font-bold text-slate-900 leading-snug line-clamp-2">
                                {{ $foto->title }}
                            </h3>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full text-center py-12 text-slate-400">
                    Belum ada dokumentasi galeri yang diunggah.
                </div>
            @endforelse
        </div>

        <!-- Tombol Lihat Semua Galeri -->
        @if (isset($fotos) && $fotos->count() > 0)
            <div class="mt-10 text-center">
                <a href="{{ route('gallery.index') }}" target="_blank" rel="noopener noreferrer"
                    class="inline-flex items-center gap-2 px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-semibold text-xs sm:text-sm rounded-xl shadow-md transition-all">
                    <span>Lihat Seluruh Galeri & Dokumentasi</span>
                    <i class="ti ti-external-link text-base"></i>
                </a>
            </div>
        @endif

    </div>
</section>

<!-- Lightbox Modal dengan Deskripsi Lengkap -->
<div id="gallery-lightbox"
    class="fixed inset-0 z-50 bg-slate-950/90 hidden items-center justify-center p-4 backdrop-blur-sm transition-opacity"
    onclick="closeLightbox()">
    <div class="relative max-w-3xl w-full bg-slate-900 rounded-2xl overflow-hidden shadow-2xl border border-slate-800"
        onclick="event.stopPropagation()">
        <button onclick="closeLightbox()"
            class="absolute top-4 right-4 w-9 h-9 rounded-full bg-slate-800 hover:bg-slate-700 text-white flex items-center justify-center transition-colors cursor-pointer z-10">
            <i class="ti ti-x text-lg"></i>
        </button>
        <div class="max-h-[60vh] bg-black flex items-center justify-center">
            <img id="lightbox-img" src="" alt="" class="max-h-[60vh] w-auto object-contain">
        </div>
        <div class="p-5 sm:p-6 bg-slate-900 border-t border-slate-800 space-y-2">
            <div class="flex items-center gap-2">
                <span id="lightbox-category"
                    class="px-2 py-0.5 bg-blue-500/20 text-blue-400 text-[10px] font-bold uppercase rounded border border-blue-500/30"></span>
            </div>
            <h3 id="lightbox-title" class="text-white font-serif text-base sm:text-lg font-bold"></h3>
            <p id="lightbox-caption" class="text-slate-300 text-xs sm:text-sm leading-relaxed"></p>
        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const cards = document.querySelectorAll('.gallery-card');
        const lightbox = document.getElementById('gallery-lightbox');
        const lightboxImg = document.getElementById('lightbox-img');
        const lightboxTitle = document.getElementById('lightbox-title');
        const lightboxCaption = document.getElementById('lightbox-caption');
        const lightboxCategory = document.getElementById('lightbox-category');

        cards.forEach(card => {
            card.addEventListener('click', function() {
                const imageUrl = this.getAttribute('data-image');
                const title = this.getAttribute('data-title');
                const caption = this.getAttribute('data-caption');
                const category = this.getAttribute('data-category');

                lightboxImg.src = imageUrl;
                lightboxTitle.innerText = title;
                lightboxCaption.innerText = caption;
                lightboxCategory.innerText = category;

                lightbox.classList.remove('hidden');
                lightbox.classList.add('flex');
            });
        });
    });

    function closeLightbox() {
        const lightbox = document.getElementById('gallery-lightbox');
        lightbox.classList.remove('flex');
        lightbox.classList.add('hidden');
    }
</script>
