     @extends('layouts.app')

     @section('title', ($item->name ?? 'Detail') . ' — ' . config('app.name'))
     @section('meta_description', Str::limit(strip_tags($item->short_description ?? ''), 160))

     @section('content')

     <article class="bg-white min-h-screen">
          {{-- Hero Gambar Cover / Banner --}}
          @php
               $coverUrl = $item->cover_image ? Storage::url($item->cover_image) : null;
               // Menangani berbagai macam format atribut (category untuk ekskul, tag untuk fasilitas)
               $badgeText = $item->category ?? ($item->tag ?? $type);
               // Menangani ikon (icon atau default ti-star)
               $itemIcon = $item->icon ?? 'ti-star';
          @endphp

          <div class="relative w-full h-56 sm:h-80 md:h-[380px] bg-slate-900">
               @if ($coverUrl)
                    <img src="{{ $coverUrl }}" alt="{{ $item->name }}" class="w-full h-full object-cover opacity-80">
               @else
                    <div class="w-full h-full flex items-center justify-center text-slate-500">
                         <i class="ti ti-photo text-5xl"></i>
                    </div>
               @endif

               <div class="absolute inset-0 bg-gradient-to-t from-slate-950 via-slate-950/40 to-transparent"></div>

               <div class="absolute bottom-0 left-0 right-0 max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 pb-6 sm:pb-8">
                    @if ($badgeText)
                         <span
                         class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-blue-600/90 text-white text-[11px] sm:text-xs font-semibold mb-2.5 shadow-sm">
                         <i class="ti {{ $itemIcon }}" aria-hidden="true"></i>
                         {{ $badgeText }}
                         </span>
                    @endif
                    <h1 class="font-serif text-2xl sm:text-4xl md:text-5xl font-extrabold text-white leading-tight">
                         {{ $item->name }}
                    </h1>
               </div>
          </div>

          {{-- Container Utama 2 Kolom --}}
          <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-8 sm:py-12">
               <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-12 items-start">

                    <!-- KOLOM KIRI: KONTEN UTAMA -->
                    <div class="lg:col-span-8">
                         <!-- Tombol Kembali -->
                         <div class="mb-6 pb-4 border-b border-slate-100 flex items-center justify-between gap-4">
                         <a href="{{ $backUrl ?? url('/') }}"
                              class="inline-flex items-center gap-2 px-3.5 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs sm:text-sm font-semibold rounded-xl transition-all">
                              <i class="ti ti-arrow-left text-base" aria-hidden="true"></i>
                              <span>{{ $backLabel ?? 'Kembali' }}</span>
                         </a>
                         <span class="text-[11px] sm:text-xs text-slate-400 shrink-0">
                              Diperbarui {{ $item->updated_at ? $item->updated_at->diffForHumans() : 'baru saja' }}
                         </span>
                         </div>

                         <!-- Deskripsi Ringkas -->
                         @if ($item->short_description)
                         <div
                              class="p-4 sm:p-5 bg-blue-50/70 border-l-4 border-blue-600 rounded-r-xl text-slate-700 text-sm sm:text-base leading-relaxed italic mb-6">
                              "{{ $item->short_description }}"
                         </div>
                         @endif

                         <!-- Deskripsi Lengkap -->
                         <div
                         class="prose prose-slate prose-blue max-w-none text-slate-700 text-sm sm:text-base leading-relaxed mb-8">
                         {!! $item->description !!}
                         </div>

                         {{-- Galeri Foto (Mendukung format array JSON 'gallery' atau relasi 'images') --}}
                         @php
                         $galleryImages = [];
                         if (is_array($item->gallery)) {
                              $galleryImages = $item->gallery;
                         } elseif (
                              isset($item->images) &&
                              method_exists($item->images, 'count') &&
                              $item->images->count() > 0
                         ) {
                              $galleryImages = $item->images->pluck('image_path')->toArray();
                         }
                         @endphp

                         @if (count($galleryImages) > 0)
                         <div class="mt-10 pt-6 border-t border-slate-100">
                              <h2 class="font-serif text-lg sm:text-xl font-bold text-slate-900 mb-4 flex items-center gap-2">
                                   <i class="ti ti-photo-album text-blue-600"></i>
                                   <span>Dokumentasi Kegiatan</span>
                              </h2>
                              <div class="grid grid-cols-2 sm:grid-cols-3 gap-3">
                                   @foreach ($galleryImages as $image)
                                        <figure
                                             class="group aspect-4/3 rounded-xl overflow-hidden bg-slate-100 border border-slate-200">
                                             <img src="{{ Storage::url($image) }}" alt="Galeri"
                                             class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                                        </figure>
                                   @endforeach
                              </div>
                         </div>
                         @endif
                    </div>

                    <!-- KOLOM KANAN: SIDEBAR -->
                    <div class="lg:col-span-4 space-y-6 lg:sticky lg:top-6 w-full">
                         <!-- Info Detail -->
                         <div class="bg-slate-50 border border-slate-200/80 rounded-2xl p-4 sm:p-5 space-y-3.5">
                         <h3
                              class="text-xs font-bold text-slate-400 uppercase tracking-wider pb-2 border-b border-slate-200/60">
                              Informasi {{ $type }}</h3>
                         <ul class="space-y-3 text-xs sm:text-sm">
                              <li class="flex items-center gap-3 text-slate-700">
                                   <div
                                        class="w-8 h-8 rounded-lg bg-blue-50 text-blue-600 border border-blue-100 flex items-center justify-center shrink-0">
                                        <i class="ti {{ $itemIcon }} text-base"></i>
                                   </div>
                                   <div class="min-w-0 flex-1">
                                        <span class="block text-[11px] text-slate-400 font-medium">Nama
                                             {{ $type }}</span>
                                        <span class="font-bold text-slate-900 truncate block">{{ $item->name }}</span>
                                   </div>
                              </li>
                              <li class="flex items-center gap-3 text-slate-700">
                                   <div
                                        class="w-8 h-8 rounded-lg bg-emerald-50 text-emerald-600 border border-emerald-100 flex items-center justify-center shrink-0">
                                        <i class="ti ti-check text-base"></i>
                                   </div>
                                   <div>
                                        <span class="block text-[11px] text-slate-400 font-medium">Status Aktif</span>
                                        <span class="font-bold text-emerald-700">Sedang Berjalan</span>
                                   </div>
                              </li>
                         </ul>
                         </div>

                         <!-- Rekomendasi Item Lainnya secara Otomatis -->
                         @php
                         $modelClass = get_class($item);
                         $otherItems = $modelClass
                              ::where('id', '!=', $item->id)
                              ->where('is_published', true)
                              ->inRandomOrder()
                              ->take(4)
                              ->get();

                         // Menentukan rute berdasarkan jenis model
                         $isFacility = $item instanceof \App\Models\Facility;
                         $routeTarget = $isFacility ? 'facilities.show' : 'ekskul.show';
                         @endphp

                         @if ($otherItems->count() > 0)
                         <div class="bg-slate-50 border border-slate-200/80 rounded-2xl p-4 sm:p-5 space-y-3">
                              <h3
                                   class="text-xs font-bold text-slate-400 uppercase tracking-wider pb-2 border-b border-slate-200/60">
                                   {{ $type }} Lainnya</h3>
                              <div class="space-y-2.5">
                                   @foreach ($otherItems as $other)
                                        <a href="{{ route($routeTarget, $other->slug) }}"
                                             class="flex items-center gap-3 group p-2 rounded-xl hover:bg-white transition-colors">
                                             <div
                                             class="w-11 h-11 rounded-lg bg-slate-200 overflow-hidden border border-slate-200 shrink-0">
                                             @if ($other->cover_image)
                                                  <img src="{{ Storage::url($other->cover_image) }}"
                                                       class="w-full h-full object-cover">
                                             @else
                                                  <div
                                                       class="w-full h-full flex items-center justify-center text-slate-400 bg-slate-100">
                                                       <i class="ti {{ $other->icon ?? 'ti-star' }}"></i>
                                                  </div>
                                             @endif
                                             </div>
                                             <div class="min-w-0 flex-1">
                                             <h4
                                                  class="text-xs sm:text-sm font-bold text-slate-900 group-hover:text-blue-600 truncate">
                                                  {{ $other->name }}</h4>
                                             <p class="text-[11px] text-slate-400 truncate">
                                                  {{ $other->category ?? ($other->tag ?? 'Kegiatan Sekolah') }}</p>
                                             </div>
                                        </a>
                                   @endforeach
                              </div>
                         </div>
                         @endif
                    </div>

               </div>
          </div>
     </article>

     @endsection
