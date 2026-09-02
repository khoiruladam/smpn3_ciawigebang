{{-- resources/views/welcome.blade.php --}}
@extends('layouts.app')

@section('title', 'SMP Negeri 3 Ciawigebang')
@section('meta_description',
    'Selamat datang di website resmi ' .
    config('app.name') .
    '. Temukan informasi seputar
    profil, fasilitas, kegiatan, berita, dan prestasi sekolah.')

@section('content')

    <!-- Hero Section Full-Background -->
    <x-hero title="{{ config('app.name') }}" subtitle="SMP Negeri 3 Ciawigebang"
        description="Membentuk generasi cerdas, berkarakter unggul, dan berwawasan lingkungan." :image="asset('images/sekolah-1.jpg')"
        search-action="{{ url('/') }}" />

    <!-- Sections Halaman Utama -->
    <main class="flex flex-col gap-0 bg-slate-50">
        @include('sections.profil')
        @include('sections.fasilitas')
        @include('sections.ssk')
        @include('sections.galeri')
        @include('sections.berita')
        @include('sections.guru')
        @include('sections.prestasi')
        @include('sections.ekskul')
        @include('sections.kontak')
    </main>

@endsection
