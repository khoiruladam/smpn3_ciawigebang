{{-- resources/views/prestasi/index.blade.php --}}
@extends('layouts.app')

@section('content')
    @php
        $bgPrestasi = asset('images/guru-1.jpg'); // Anda bisa menyesuaikan path background sesuai keinginan
    @endphp

    <div class="min-h-screen bg-slate-950 pt-28 pb-16 px-4 sm:px-6 lg:px-8 relative overflow-hidden">
        <!-- Background Gambar dengan Overlay Gelap -->
        <div class="absolute inset-0 z-0">
            <img src="{{ $bgPrestasi }}" alt="Background Prestasi Sekolah"
                class="w-full h-full object-cover object-center opacity-80" loading="lazy">
            <div class="absolute inset-0 bg-slate-950/75"></div>
        </div>

        <div class="relative z-10 max-w-6xl mx-auto">
            <!-- Tombol Kembali -->
            <div class="mb-8">
                <a href="{{ url('/') }}"
                    class="inline-flex items-center gap-2 px-4 py-2 bg-white/10 hover:bg-white/20 border border-white/20 text-white text-xs sm:text-sm font-semibold rounded-xl backdrop-blur-md transition-all shadow-sm">
                    <i class="ti ti-arrow-left"></i> Kembali ke Beranda
                </a>
            </div>

            <!-- Header Halaman -->
            <div class="text-center max-w-xl mx-auto mb-12">
                <span
                    class="inline-block px-3 py-1 rounded-full bg-white/10 border border-white/20 text-slate-200 text-[10px] sm:text-xs font-semibold uppercase tracking-wider mb-2 backdrop-blur-md">
                    Arsip Pencapaian
                </span>
                <h1 class="font-serif text-3xl sm:text-4xl font-bold text-white tracking-tight mb-2">
                    Seluruh Prestasi & Penghargaan
                </h1>
                <p class="text-slate-300 text-xs sm:text-sm">
                    Koleksi lengkap seluruh piala, medali, dan piagam kejuaraan yang telah diraih oleh siswa serta sekolah
                    di {{ config('app.name') }}.
                </p>
            </div>

            <!-- Grid Seluruh Prestasi -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse($prestasiList as $p)
                    @php
                        $imgUrl = $p->cover_image
                            ? (Str::startsWith($p->cover_image, 'http')
                                ? $p->cover_image
                                : Storage::url($p->cover_image))
                            : null;
                    @endphp
                    <div class="bg-white border border-slate-200/90 rounded-2xl overflow-hidden shadow-sm hover:shadow-md hover:border-blue-400 transition-all flex flex-col justify-between cursor-pointer prestasi-item"
                        data-image="{{ $imgUrl }}" data-title="{{ $p->title }}" data-year="{{ $p->year }}"
                        data-category="{{ $p->category ?? 'Prestasi Sekolah' }}">

                        <div class="relative w-full h-52 bg-slate-900 overflow-hidden group">
                            @if ($imgUrl)
                                <img src="{{ $imgUrl }}" alt="{{ $p->title }}"
                                    class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
                                    loading="lazy">
                            @else
                                <div class="w-full h-full flex items-center justify-center text-slate-400 bg-slate-100">
                                    <i class="ti ti-trophy text-4xl"></i>
                                </div>
                            @endif

                            <!-- Badge Kategori -->
                            <div class="absolute top-3 left-3">
                                <span
                                    class="px-2.5 py-1 bg-slate-900/80 backdrop-blur-xs text-white text-[10px] font-medium rounded border border-white/20">
                                    {{ $p->category ?? 'Prestasi Sekolah' }}
                                </span>
                            </div>

                            <!-- Badge Tahun -->
                            <div class="absolute top-3 right-3">
                                <span
                                    class="px-2.5 py-1 bg-slate-950/90 backdrop-blur-xs text-amber-400 text-[10px] font-bold rounded border border-amber-500/30">
                                    {{ $p->year }}
                                </span>
                            </div>
                        </div>

                        <div class="p-4 bg-white flex-1 flex flex-col justify-between">
                            <div>
                                <h3
                                    class="font-serif text-sm sm:text-base font-bold text-slate-900 leading-snug line-clamp-2 mb-1">
                                    {{ $p->title }}
                                </h3>
                            </div>
                            <div
                                class="pt-3 mt-3 border-t border-slate-100 flex items-center justify-between text-xs font-semibold text-blue-600">
                                <span class="flex items-center gap-1">
                                    <i class="ti ti-medal text-amber-500"></i> Lihat Detail
                                </span>
                                <i class="ti ti-arrow-right"></i>
                            </div>
                        </div>
                    </div>
                @empty
                    <div
                        class="col-span-full text-center py-16 text-slate-400 bg-white/5 border border-white/10 rounded-2xl backdrop-blur-md">
                        Belum ada data prestasi yang tersedia.
                    </div>
                @endforelse
            </div>

            <!-- Pagination jika menggunakan paginator -->
            @if (method_exists($prestasiList, 'links'))
                <div class="mt-10">
                    {{ $prestasiList->links() }}
                </div>
            @endif
        </div>
    </div>

    <!-- Lightbox Modal untuk Prestasi -->
    <div id="prestasi-lightbox"
        class="fixed inset-0 z-50 bg-slate-950/90 hidden items-center justify-center p-4 backdrop-blur-sm transition-opacity">
        <div class="relative max-w-3xl w-full bg-slate-900 rounded-2xl overflow-hidden shadow-2xl border border-slate-800">
            <button id="lightbox-close-btn"
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
                    <span id="lightbox-year"
                        class="px-2 py-0.5 bg-amber-500/20 text-amber-400 text-[10px] font-bold uppercase rounded border border-amber-500/30"></span>
                </div>
                <h3 id="lightbox-title" class="text-white font-serif text-base sm:text-lg font-bold"></h3>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const lightbox = document.getElementById('prestasi-lightbox');
            const lightboxImg = document.getElementById('lightbox-img');
            const lightboxTitle = document.getElementById('lightbox-title');
            const lightboxCategory = document.getElementById('lightbox-category');
            const lightboxYear = document.getElementById('lightbox-year');
            const closeBtn = document.getElementById('lightbox-close-btn');
            const prestasiItems = document.querySelectorAll('.prestasi-item');

            function openLightbox(imageUrl, title, category, year) {
                if (!imageUrl) return;
                lightboxImg.src = imageUrl;
                lightboxImg.alt = title || '';
                lightboxTitle.textContent = title || '';
                lightboxCategory.textContent = category || '';
                lightboxYear.textContent = year || '';

                lightbox.classList.remove('hidden');
                lightbox.classList.add('flex');
                document.body.classList.add('overflow-hidden');
            }

            function closeLightbox() {
                lightbox.classList.add('hidden');
                lightbox.classList.remove('flex');
                document.body.classList.remove('overflow-hidden');
                lightboxImg.src = '';
            }

            prestasiItems.forEach(function(item) {
                item.addEventListener('click', function() {
                    openLightbox(
                        this.dataset.image,
                        this.dataset.title,
                        this.dataset.category,
                        this.dataset.year
                    );
                });
            });

            if (closeBtn) closeBtn.addEventListener('click', closeLightbox);

            // Tutup saat klik area gelap di luar modal card
            if (lightbox) {
                lightbox.addEventListener('click', function(e) {
                    if (e.target === lightbox) closeLightbox();
                });
            }

            // Tutup dengan tombol Escape
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape') closeLightbox();
            });
        });
    </script>
@endpush
