@extends('layouts.app')

@section('content')
    @php
        $bgPostIndex = asset('images/guru-1.jpg'); // Background gambar yang senada dengan halaman lain
    @endphp

    <div class="min-h-screen bg-slate-950 pt-28 pb-16 px-4 sm:px-6 lg:px-8 relative overflow-hidden">
        <!-- Background Gambar dengan Overlay Gelap -->
        <div class="absolute inset-0 z-0">
            <img src="{{ $bgPostIndex }}" alt="Background Arsip Warta Sekolah"
                class="w-full h-full object-cover object-center opacity-75" loading="lazy">
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

            <!-- Header Halaman Arsip -->
            <div class="text-center max-w-xl mx-auto mb-12 border-b-2 border-white/20 pb-6">
                <span
                    class="inline-block px-3 py-1 rounded-sm bg-slate-900 border border-slate-700 text-white text-[10px] sm:text-xs font-bold uppercase tracking-widest mb-2 shadow-sm">
                    Arsip Warta Sekolah
                </span>
                <h1 class="font-serif text-3xl sm:text-4xl md:text-5xl font-bold text-white tracking-tight mb-2">
                    Semua Berita & Artikel
                </h1>
                <p class="text-slate-300 text-xs sm:text-sm font-serif italic">
                    Kumpulan seluruh berita, pengumuman, dan informasi kegiatan di {{ config('app.name') }}.
                </p>
            </div>

            <!-- Grid Arsip Berita (Card Putih Solid dengan Gaya Koran Klasik) -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse($posts as $b)
                    @php
                        $imgUrl = $b->image
                            ? (Str::startsWith($b->image, 'http')
                                ? $b->image
                                : Storage::url($b->image))
                            : 'https://images.unsplash.com/photo-1577896851231-70ef18881754?auto=format&fit=crop&w=800&q=80';
                    @endphp
                    <article
                        class="bg-[#fbf9f5] border-2 border-slate-900 rounded-sm overflow-hidden shadow-lg hover:shadow-2xl transition-all flex flex-col justify-between group p-4">
                        <div>
                            <!-- Gambar Cover ala Koran -->
                            <div
                                class="relative aspect-[16/10] bg-slate-200 border border-slate-900 overflow-hidden mb-3.5">
                                <img src="{{ $imgUrl }}" alt="{{ $b->title }}"
                                    class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
                                    loading="lazy">
                                <span
                                    class="absolute top-2.5 left-2.5 px-2.5 py-1 bg-slate-900 text-white text-[9px] font-bold uppercase tracking-wider rounded-xs shadow-xs">
                                    {{ $b->category }}
                                </span>
                            </div>

                            <!-- Deskripsi & Tipografi Koran -->
                            <div class="space-y-2">
                                <span
                                    class="text-[11px] text-slate-600 font-serif italic flex items-center gap-1.5 border-b border-slate-300 pb-1.5">
                                    <i class="ti ti-calendar text-slate-900"></i> Edisi:
                                    {{ $b->created_at->format('d M Y') }}
                                </span>
                                <h3
                                    class="font-serif text-base sm:text-lg font-bold text-slate-950 line-clamp-2 group-hover:text-blue-900 transition-colors leading-snug">
                                    {{ $b->title }}
                                </h3>
                                <p class="text-xs sm:text-sm text-slate-700 line-clamp-3 leading-relaxed font-sans">
                                    {{ $b->excerpt }}
                                </p>
                            </div>
                        </div>

                        <!-- Tautan Aksi Klasik -->
                        <div class="pt-3 mt-4 border-t border-slate-300 flex items-center justify-between">
                            <a href="{{ route('berita.show', $b) }}"
                                class="inline-flex items-center gap-1.5 text-xs font-bold text-slate-950 group-hover:text-blue-900 uppercase tracking-wider transition-colors">
                                <span>Baca Selengkapnya</span>
                                <i class="ti ti-arrow-right transition-transform group-hover:translate-x-1"></i>
                            </a>
                        </div>
                    </article>
                @empty
                    <div
                        class="col-span-full text-center py-16 text-slate-700 bg-[#fbf9f5] border-2 border-slate-900 rounded-sm shadow-sm font-serif italic">
                        Belum ada berita atau artikel arsip yang tersedia.
                    </div>
                @endforelse
            </div>

            <!-- Pagination -->
            <div class="mt-12 text-white">
                {{ $posts->links() }}
            </div>
        </div>
    </div>
@endsection
