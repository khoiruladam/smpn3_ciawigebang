@extends('layouts.app')

@section('content')
    @php
        $bgGallery = asset('images/guru-1.jpg'); // Anda bisa mengganti path gambar sesuai keinginan
    @endphp

    <div class="min-h-screen bg-slate-950 pt-28 pb-16 px-4 sm:px-6 lg:px-8 relative overflow-hidden">
        <!-- Background Gambar dengan Overlay Gelap -->
        <div class="absolute inset-0 z-0">
            <img src="{{ $bgGallery }}" alt="Background Galeri Sekolah"
                class="w-full h-full object-cover object-center opacity-40" loading="lazy">
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
                    Arsip Dokumentasi
                </span>
                <h1 class="font-serif text-3xl sm:text-4xl font-bold text-white tracking-tight mb-2">
                    Seluruh Galeri & Kegiatan Sekolah
                </h1>
                <p class="text-slate-300 text-xs sm:text-sm">
                    Koleksi lengkap seluruh momen, kegiatan, dan fasilitas di {{ config('app.name') }}.
                </p>
            </div>

            <!-- Grid Seluruh Galeri -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse($fotos as $foto)
                    @php
                        $imgUrl = Str::startsWith($foto->image, 'http') ? $foto->image : Storage::url($foto->image);
                    @endphp
                    <div class="bg-white border border-slate-200/90 rounded-2xl overflow-hidden shadow-sm hover:shadow-md hover:border-blue-400 transition-all flex flex-col justify-between cursor-pointer"
                        onclick="openLightbox('{{ $imgUrl }}', '{{ addslashes($foto->title) }}', '{{ addslashes($foto->caption) }}', '{{ $foto->category }}')">
                        <div class="relative w-full h-52 bg-slate-900 overflow-hidden group">
                            <img src="{{ $imgUrl }}" alt="{{ $foto->title }}"
                                class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
                                loading="lazy">
                            <div class="absolute top-3 left-3">
                                <span
                                    class="px-2.5 py-1 bg-slate-900/80 backdrop-blur-xs text-white text-[10px] font-medium rounded border border-white/20">
                                    {{ $foto->category }}
                                </span>
                            </div>
                        </div>
                        <div class="p-4 bg-white">
                            <h3
                                class="font-serif text-sm sm:text-base font-bold text-slate-900 leading-snug line-clamp-1 mb-1">
                                {{ $foto->title }}
                            </h3>
                            <p class="text-xs text-slate-500 line-clamp-2">
                                {{ $foto->caption }}
                            </p>
                        </div>
                    </div>
                @empty
                    <div
                        class="col-span-full text-center py-16 text-slate-400 bg-white/5 border border-white/10 rounded-2xl backdrop-blur-md">
                        Belum ada dokumentasi galeri yang tersedia.
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Lightbox Modal -->
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
@endsection
