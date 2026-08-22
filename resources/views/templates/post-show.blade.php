@extends('layouts.app')

@section('content')
    <div class="min-h-screen bg-white pt-28 pb-16 px-4 sm:px-6 lg:px-8">
        <div class="max-w-7xl mx-auto">

            <!-- Tombol Kembali -->
            <div class="mb-10">
                <a href="{{ url('/#berita') }}"
                    class="inline-flex items-center gap-2 px-5 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-800 text-sm font-bold rounded-xl transition-all">
                    <i class="ti ti-arrow-left"></i> Kembali
                </a>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-start">

                <!-- KOLOM KIRI: ARTIKEL (Gaya Koran Klasik & Rapat) -->
                <article class="lg:col-span-8 space-y-8">
                    <header class="border-b-4 border-slate-900 pb-8">
                        <span class="text-[10px] font-bold uppercase tracking-widest text-slate-500 mb-2 block">
                            Kategori: {{ strtoupper($post->category) }}
                        </span>
                        <h1 class="font-serif text-4xl md:text-6xl font-black text-slate-950 leading-tight tracking-tight">
                            {{ $post->title }}
                        </h1>
                        <div class="mt-4 text-sm font-serif italic text-slate-600">
                            {{ $post->created_at->format('d F Y') }} • Oleh Tim Redaksi
                        </div>
                    </header>

                    @if ($post->image)
                        <div class="w-full h-80 md:h-[450px] border-2 border-slate-900 overflow-hidden shadow-sm">
                            <img src="{{ Str::startsWith($post->image, 'http') ? $post->image : Storage::url($post->image) }}"
                                alt="{{ $post->title }}" class="w-full h-full object-cover">
                        </div>
                    @endif

                    <!-- Konten dengan Pagination & Jarak Paragraf Natural -->
                    <div id="paginated-article-body"
                        class="font-serif text-lg text-slate-900 leading-relaxed text-justify space-y-4">
                        {!! $post->body !!}
                    </div>

                    <!-- Navigasi Pagination -->
                    <div id="article-pagination"
                        class="pt-8 border-t border-slate-300 flex items-center justify-between hidden">
                        <button id="prev-page-btn" onclick="changeArticlePage(-1)"
                            class="px-6 py-2 border-2 border-slate-900 text-slate-900 font-bold text-xs uppercase tracking-wider hover:bg-slate-900 hover:text-white transition-all cursor-pointer">
                            ← Sebelumnya
                        </button>
                        <span id="page-indicator" class="font-serif italic text-slate-600 text-sm">Halaman 1</span>
                        <button id="next-page-btn" onclick="changeArticlePage(1)"
                            class="px-6 py-2 bg-slate-900 text-white font-bold text-xs uppercase tracking-wider hover:bg-slate-700 transition-all cursor-pointer">
                            Selanjutnya →
                        </button>
                    </div>
                </article>

                <!-- KOLOM KANAN: SIDEBAR (Gaya Koran) -->
                <aside class="lg:col-span-4">
                    <div class="border-2 border-slate-900 p-6 sticky top-28 bg-white shadow-sm">
                        <h3
                            class="font-serif text-lg font-bold text-slate-950 mb-6 uppercase tracking-widest border-b-2 border-slate-900 pb-2">
                            Warta Terbaru
                        </h3>

                        <div class="space-y-6">
                            @forelse($recentPosts as $rp)
                                <a href="{{ route('berita.show', $rp) }}"
                                    class="block group border-b border-slate-200 pb-4 last:border-0">
                                    <h4
                                        class="font-serif text-base font-bold text-slate-900 group-hover:text-blue-900 line-clamp-2 leading-snug">
                                        {{ $rp->title }}
                                    </h4>
                                    <span
                                        class="text-[10px] text-slate-500 mt-1 block uppercase italic">{{ $rp->created_at->format('d M Y') }}</span>
                                </a>
                            @empty
                                <p class="text-sm font-serif italic text-slate-500">Belum ada warta lainnya.</p>
                            @endforelse
                        </div>
                    </div>
                </aside>
            </div>
        </div>
    </div>

    <style>
        /* Mengatur jarak antar paragraf agar rapat dan rapi ala koran */
        #paginated-article-body p {
            margin-bottom: 1rem !important;
            margin-top: 0 !important;
        }

        #paginated-article-body figure {
            margin: 1.5rem 0 !important;
        }
    </style>

    <script>
        let currentArticlePage = 1;
        let articlePages = [];

        document.addEventListener("DOMContentLoaded", function() {
            const container = document.getElementById("paginated-article-body");
            if (!container) return;
            const children = Array.from(container.children);

            // Membagi konten setiap 5 elemen per halaman jika artikel panjang
            if (children.length > 5) {
                const itemsPerPage = 5;
                for (let i = 0; i < children.length; i += itemsPerPage) {
                    articlePages.push(children.slice(i, i + itemsPerPage));
                }
                document.getElementById("article-pagination").classList.remove("hidden");
                renderArticlePage(1);
            }
        });

        function renderArticlePage(page) {
            const container = document.getElementById("paginated-article-body");
            container.innerHTML = "";
            articlePages[page - 1].forEach(el => container.appendChild(el));

            document.getElementById("page-indicator").innerText = `Halaman ${page} dari ${articlePages.length}`;
            document.getElementById("prev-page-btn").disabled = (page === 1);
            document.getElementById("next-page-btn").disabled = (page === articlePages.length);

            window.scrollTo({
                top: 200,
                behavior: 'smooth'
            });
        }

        function changeArticlePage(direction) {
            currentArticlePage += direction;
            renderArticlePage(currentArticlePage);
        }
    </script>
@endsection
