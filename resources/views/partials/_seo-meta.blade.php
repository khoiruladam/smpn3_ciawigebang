{{--
    Partial SEO Meta Tags — di-include di <head> layout publik.
    Otomatis generate tag title, meta description, Open Graph, Twitter Card, dan canonical.

    Variabel yang diterima (opsional, semua ada fallback):
    - $seoModel: Model yang menggunakan trait HasSeo (Post, Ekskul, Facility, Achievement, Gallery)
    - $seoTitle: Override judul langsung (string)
    - $seoDescription: Override deskripsi langsung (string)
--}}

@php
    // Fallback defaults
    $defaultTitle = config('app.name', 'SMP Negeri 3 Ciawigebang') . ' — Website Resmi Sekolah';
    $defaultDescription = 'Website resmi SMP Negeri 3 Ciawigebang, Kabupaten Kuningan, Jawa Barat. Informasi profil, fasilitas, berita, prestasi, dan kegiatan sekolah.';
    $defaultImage = asset('images/sekolah-1.jpg');

    // Ambil dari model HasSeo jika tersedia
    if (isset($seoModel) && method_exists($seoModel, 'getSeoTitle')) {
        $title = $seoModel->getSeoTitle() . ' — ' . config('app.name', 'SMPN 3 Ciawigebang');
        $description = $seoModel->getSeoDescription();
        $keywords = $seoModel->getSeoKeywords();
        $ogImage = $seoModel->getOgImageUrl() ?? $defaultImage;
        $canonicalUrl = $seoModel->getCanonicalUrl();
    } else {
        $title = $seoTitle ?? $defaultTitle;
        $description = $seoDescription ?? $defaultDescription;
        $keywords = null;
        $ogImage = $defaultImage;
        $canonicalUrl = request()->url();
    }
@endphp

{{-- Primary Meta Tags --}}
<title>{{ $title }}</title>
<meta name="description" content="{{ $description }}">
<meta name="robots" content="{{ request()->is('admin*') || request()->is('login') ? 'noindex, nofollow' : 'index, follow' }}">
@if ($keywords)
<meta name="keywords" content="{{ $keywords }}">
@endif
<link rel="canonical" href="{{ $canonicalUrl }}">

{{-- Open Graph Tags --}}
<meta property="og:type" content="{{ isset($seoModel) && $seoModel instanceof \App\Models\Post ? 'article' : 'website' }}">
<meta property="og:title" content="{{ $title }}">
<meta property="og:description" content="{{ $description }}">
<meta property="og:url" content="{{ $canonicalUrl }}">
<meta property="og:image" content="{{ $ogImage }}">
<meta property="og:site_name" content="{{ config('app.name', 'SMP Negeri 3 Ciawigebang') }}">
<meta property="og:locale" content="id_ID">

{{-- Twitter Card Tags --}}
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="{{ $title }}">
<meta name="twitter:description" content="{{ $description }}">
<meta name="twitter:image" content="{{ $ogImage }}">
