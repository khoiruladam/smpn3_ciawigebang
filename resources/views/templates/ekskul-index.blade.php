@extends('layouts.app')

@section('title', 'Seluruh Ekstrakurikuler — ' . config('app.name'))

@section('content')
<div class="min-h-screen bg-slate-950 pt-28 pb-16 px-4 sm:px-6 lg:px-8">
    <div class="max-w-7xl mx-auto">
        <!-- Header Halaman -->
        <div class="mb-10 pb-6 border-b border-slate-800 flex flex-col sm:flex-row sm:items-end justify-between gap-4">
            <div>
                <a href="{{ url('/#ekskul') }}"
                    class="inline-flex items-center gap-2 text-xs sm:text-sm font-semibold text-slate-400 hover:text-blue-400 mb-3 transition-colors">
                    <i class="ti ti-arrow-left"></i> Kembali ke Beranda
                </a>
                <h1 class="font-serif text-2xl sm:text-4xl font-extrabold text-white tracking-tight">
                    Seluruh Ekstrakurikuler Siswa
                </h1>
                <p class="text-slate-400 text-xs sm:text-sm mt-1.5">
                    Wadah pengembangan minat, bakat, kepemimpinan, dan kreativitas siswa di {{ config('app.name') }}.
                </p>
            </div>
            <span class="px-3.5 py-1.5 rounded-full bg-slate-900 border border-slate-800 text-slate-300 text-xs font-bold shrink-0 self-start sm:self-auto">
                Total {{ $ekskuls->count() }} Kegiatan
            </span>
        </div>

        <!-- Grid Ekskul -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 sm:gap-8">
            @forelse ($ekskuls as $e)
                <a href="{{ route('ekskul.show', $e->slug) }}"
                    class="group bg-slate-900 border border-slate-800 hover:border-slate-700 rounded-2xl overflow-hidden shadow-md flex flex-col justify-between hover:-translate-y-1 transition-all">
                    <div>
                        <div class="relative w-full h-48 sm:h-56 overflow-hidden bg-slate-800">
                            @if ($e->cover_image)
                                <img src="{{ Storage::url($e->cover_image) }}" alt="{{ $e->name }}"
                                    class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" loading="lazy">
                            @else
                                <div class="w-full h-full flex items-center justify-center text-slate-500">
                                    <i class="ti ti-star text-4xl"></i>
                                </div>
                            @endif
                            @if ($e->category)
                                <div class="absolute top-3 right-3 px-2.5 py-1 rounded bg-slate-950/80 text-slate-200 border border-slate-700/60 text-[11px] font-semibold">
                                    {{ $e->category }}
                                </div>
                            @endif
                        </div>
                        <div class="p-5">
                            <h3 class="font-serif text-lg font-bold text-white group-hover:text-blue-400 transition-colors mb-2">
                                {{ $e->name }}
                            </h3>
                            <p class="text-slate-400 text-xs sm:text-sm line-clamp-3 leading-relaxed">
                                {{ $e->short_description }}
                            </p>
                        </div>
                    </div>
                    <div class="px-5 pb-5 pt-3 border-t border-slate-800/60 flex items-center justify-between text-xs font-semibold text-slate-400 group-hover:text-blue-400 transition-colors">
                        <span>Lihat Detail</span>
                        <i class="ti ti-arrow-right text-sm transform group-hover:translate-x-1 transition-transform"></i>
                    </div>
                </a>
            @empty
                <div class="col-span-full py-16 text-center text-slate-400">
                    Belum ada data ekstrakurikuler yang diterbitkan.
                </div>
            @endforelse
        </div>
    </div>
</div>
@endsection
