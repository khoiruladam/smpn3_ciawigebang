{!! '<?xml version="1.0" encoding="UTF-8"?>' !!}
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    {{-- Halaman Utama --}}
    <url>
        <loc>{{ url('/') }}</loc>
        <changefreq>daily</changefreq>
        <priority>1.0</priority>
    </url>

    {{-- Halaman Berita Index --}}
    <url>
        <loc>{{ route('berita.index') }}</loc>
        <changefreq>daily</changefreq>
        <priority>0.9</priority>
    </url>

    {{-- Halaman Galeri --}}
    <url>
        <loc>{{ route('gallery.index') }}</loc>
        <changefreq>weekly</changefreq>
        <priority>0.7</priority>
    </url>

    {{-- Detail Berita --}}
    @foreach ($posts as $post)
    <url>
        <loc>{{ route('berita.show', $post->slug) }}</loc>
        <lastmod>{{ $post->updated_at->toW3cString() }}</lastmod>
        <changefreq>weekly</changefreq>
        <priority>0.8</priority>
    </url>
    @endforeach

    {{-- Detail Fasilitas --}}
    @foreach ($facilities as $facility)
    <url>
        <loc>{{ route('facilities.show', $facility->slug) }}</loc>
        <lastmod>{{ $facility->updated_at->toW3cString() }}</lastmod>
        <changefreq>monthly</changefreq>
        <priority>0.7</priority>
    </url>
    @endforeach

    {{-- Detail Ekstrakurikuler --}}
    @foreach ($ekskuls as $ekskul)
    <url>
        <loc>{{ route('ekskul.show', $ekskul->slug) }}</loc>
        <lastmod>{{ $ekskul->updated_at->toW3cString() }}</lastmod>
        <changefreq>monthly</changefreq>
        <priority>0.7</priority>
    </url>
    @endforeach

    {{-- Detail Prestasi --}}
    @foreach ($achievements as $achievement)
    <url>
        <loc>{{ route('prestasi.show', $achievement->slug) }}</loc>
        <lastmod>{{ $achievement->updated_at->toW3cString() }}</lastmod>
        <changefreq>monthly</changefreq>
        <priority>0.7</priority>
    </url>
    @endforeach
</urlset>
