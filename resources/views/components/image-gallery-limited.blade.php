{{-- resources/views/components/image-gallery-limited.blade.php --}}
@props([
    'images' => [],
    'title' => 'Dokumentasi Kegiatan',
    'allUrl' => null,
    'max' => 3
])

@php
    $imageList = is_array($images) ? $images : (method_exists($images, 'toArray') ? $images->toArray() : []);
    $displayImages = array_slice($imageList, 0, $max);
    $hasMore = count($imageList) > $max;
@endphp

@if (count($imageList) > 0)
    <div class="mt-8 pt-6 border-t border-slate-200/80">
        <div class="flex items-center justify-between gap-4 mb-4">
            <h2 class="font-serif text-lg sm:text-xl font-bold text-slate-900 flex items-center gap-2">
                <i class="ti ti-photo-album text-blue-600"></i>
                <span>{{ $title }}</span>
            </h2>

            @if ($hasMore && $allUrl)
                <a href="{{ $allUrl }}" target="_blank" rel="noopener noreferrer"
                    class="hidden sm:inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-xl bg-blue-50 hover:bg-blue-100 text-blue-700 text-xs font-bold transition-all border border-blue-100 shadow-2xs shrink-0">
                    <span>Lihat Semua ({{ count($imageList) }} Foto)</span>
                    <i class="ti ti-external-link text-sm"></i>
                </a>
            @endif
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-3 gap-3.5">
            @foreach ($displayImages as $img)
                @php
                    $src = \Illuminate\Support\Str::startsWith($img, 'http') ? $img : Storage::url($img);
                @endphp
                <figure class="group aspect-4/3 rounded-xl overflow-hidden bg-slate-100 border border-slate-200/80 shadow-2xs relative">
                    <img src="{{ $src }}" alt="{{ $title }} - Foto {{ $loop->iteration }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300" loading="lazy">
                </figure>
            @endforeach
        </div>

        @if ($hasMore && $allUrl)
            <div class="mt-3.5 sm:hidden">
                <a href="{{ $allUrl }}" target="_blank" rel="noopener noreferrer"
                    class="inline-flex items-center justify-center gap-2 w-full py-2.5 rounded-xl bg-blue-600 hover:bg-blue-700 text-white text-xs font-bold shadow-xs transition-colors">
                    <span>Lihat Semua ({{ count($imageList) }} Foto)</span>
                    <i class="ti ti-external-link text-sm"></i>
                </a>
            </div>
        @endif
    </div>
@endif
