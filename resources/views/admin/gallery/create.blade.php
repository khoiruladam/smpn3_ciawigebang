@extends('layouts.admin')

@section('title', 'Tambah Foto Galeri')
@section('header_title', 'Tambah Foto Galeri / Kegiatan')

@section('content')
    <div class="max-w-5xl mx-auto">
        <!-- Tombol Kembali -->
        <div class="mb-6">
            <a href="{{ route('admin.gallery.index') }}"
                class="inline-flex items-center gap-2 px-4 py-2 bg-white border border-slate-200 text-slate-700 text-sm font-semibold rounded-xl hover:bg-slate-50 transition-all shadow-xs">
                <i class="ti ti-arrow-left"></i> Kembali ke Daftar Galeri
            </a>
        </div>

        <form action="{{ route('admin.gallery.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

                <!-- Kolom Utama (Input Form) -->
                <div class="lg:col-span-2 space-y-6">
                    <div class="bg-white rounded-2xl border border-slate-200 p-6 shadow-xs space-y-5">

                        <!-- Judul / Alt Foto -->
                        <div>
                            <label for="title"
                                class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                                Judul / Alt Foto <span class="text-rose-500">*</span>
                            </label>
                            <input type="text" name="title" id="title" value="{{ old('title') }}" required
                                placeholder="Contoh: Upacara Bendera Peringatan Hardiknas"
                                class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-slate-900 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all">
                            @error('title')
                                <p class="text-rose-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Kategori & Urutan (Side by Side) -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label for="category"
                                    class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                                    Kategori <span class="text-rose-500">*</span>
                                </label>
                                <input type="text" name="category" id="category"
                                    value="{{ old('category', 'Kegiatan') }}" required
                                    placeholder="Contoh: Akademik, Olahraga, Seni"
                                    class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-slate-900 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all">
                                @error('category')
                                    <p class="text-rose-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="sort_order"
                                    class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                                    Urutan Tampil
                                </label>
                                <input type="number" name="sort_order" id="sort_order" value="{{ old('sort_order', 0) }}"
                                    class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-slate-900 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all">
                                @error('sort_order')
                                    <p class="text-rose-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Keterangan / Caption -->
                        <div>
                            <label for="caption"
                                class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                                Keterangan / Caption <span class="text-rose-500">*</span>
                            </label>
                            <textarea name="caption" id="caption" rows="4" required
                                placeholder="Tuliskan deskripsi ringkas mengenai foto dokumentasi ini..."
                                class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-slate-900 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all">{{ old('caption') }}</textarea>
                            @error('caption')
                                <p class="text-rose-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Upload Foto Utama -->
                        <div>
                            <label for="cover_image"
                                class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                                Unggah Foto <span class="text-rose-500">* (Maks 2 MB)</span>
                            </label>
                            <input type="file" name="image" id="cover_image" accept="image/*" required
                                class="block w-full text-sm text-slate-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 transition-all cursor-pointer">
                            <div id="cover-size-info" class="text-xs mt-2 hidden"></div>
                            @error('image')
                                <p class="text-rose-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Checkbox Options -->
                        <div class="pt-4 border-t border-slate-100 flex flex-wrap gap-6">
                            <label class="inline-flex items-center gap-2 cursor-pointer">
                                <input type="checkbox" name="is_featured" value="1"
                                    {{ old('is_featured') ? 'checked' : '' }}
                                    class="w-4 h-4 rounded text-blue-600 focus:ring-blue-500 border-slate-300">
                                <span class="text-sm font-semibold text-slate-700">Tandai sebagai Momen Utama</span>
                            </label>

                            <label class="inline-flex items-center gap-2 cursor-pointer">
                                <input type="checkbox" name="is_published" value="1"
                                    {{ old('is_published', true) ? 'checked' : '' }}
                                    class="w-4 h-4 rounded text-blue-600 focus:ring-blue-500 border-slate-300">
                                <span class="text-sm font-semibold text-slate-700">Publikasikan Langsung</span>
                            </label>
                        </div>

                    </div>

                    <div class="flex justify-end gap-3">
                        <button type="submit"
                            class="px-6 py-2.5 bg-blue-600 hover:bg-blue-700 text-white text-sm font-bold rounded-xl shadow-sm transition-all cursor-pointer">
                            <i class="ti ti-check mr-1"></i> Simpan Foto
                        </button>
                    </div>
                </div>

                <!-- Kolom Kanan (Pratinjau Card Live) -->
                <div class="lg:col-span-1">
                    <div class="sticky top-6 bg-white rounded-2xl border border-slate-200 p-5 shadow-xs">
                        <h3 class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-4">Pratinjau Tampilan Card
                        </h3>

                        <div class="bg-white border border-slate-200 rounded-2xl overflow-hidden shadow-xs">
                            <div class="relative w-full h-48 bg-slate-900 flex items-center justify-center overflow-hidden">
                                <img id="card-preview-cover" src="#" alt="Preview"
                                    class="w-full h-full object-cover hidden">
                                <div id="card-placeholder" class="text-center p-4 text-slate-500">
                                    <i class="ti ti-photo text-3xl block mb-1"></i>
                                    <span class="text-xs">Foto belum dipilih</span>
                                </div>
                                <div class="absolute top-3 left-3">
                                    <span id="preview-gallery-category"
                                        class="px-2 py-0.5 bg-slate-900/80 backdrop-blur-xs text-white text-[10px] font-medium rounded border border-white/20">
                                        {{ old('category', 'KEGIATAN') }}
                                    </span>
                                </div>
                            </div>
                            <div class="p-4 bg-white">
                                <h4 id="preview-gallery-title"
                                    class="font-serif text-sm font-bold text-slate-900 leading-snug line-clamp-2">
                                    {{ old('title', 'Judul / Keterangan foto galeri...') }}
                                </h4>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            @include('admin.partials._seo-form', ['seo' => null])
        </form>
    </div>

    <!-- CUSTOM ALERT MODAL -->
    <div id="custom-alert-modal"
        class="fixed inset-0 z-50 bg-slate-950/60 backdrop-blur-xs flex items-center justify-center p-4 opacity-0 pointer-events-none transition-opacity duration-300">
        <div id="custom-alert-card"
            class="bg-white rounded-2xl max-w-sm w-full p-6 shadow-2xl border border-slate-100 transform scale-95 transition-transform duration-300 text-center">
            <div
                class="w-12 h-12 rounded-full bg-rose-50 text-rose-600 flex items-center justify-center mx-auto mb-4 text-xl">
                <i class="ti ti-alert-circle"></i>
            </div>
            <h3 id="alert-title" class="font-serif text-base font-bold text-slate-900 mb-1">Peringatan</h3>
            <p id="alert-message" class="text-xs text-slate-500 leading-relaxed mb-5">Pesan peringatan sistem...</p>
            <button id="close-alert-btn"
                class="w-full py-2.5 bg-slate-900 hover:bg-slate-800 text-white font-semibold text-xs rounded-xl transition-all cursor-pointer">
                Mengerti
            </button>
        </div>
    </div>
@endsection
