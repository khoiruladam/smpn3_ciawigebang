@extends('layouts.admin')

@section('title', 'Edit Berita & Artikel')
@section('header_title', 'Edit Berita & Artikel')

@section('content')
    <div class="max-w-6xl mx-auto">
        <!-- Tombol Kembali -->
        <div class="mb-6">
            <a href="{{ route('admin.posts.index') }}"
                class="inline-flex items-center gap-2 px-4 py-2 bg-white border border-slate-200 text-slate-700 text-sm font-semibold rounded-xl hover:bg-slate-50 transition-all shadow-xs">
                <i class="ti ti-arrow-left"></i> Kembali ke Daftar Berita
            </a>
        </div>

        <form action="{{ route('admin.posts.update', $post) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

                <!-- Kolom Utama (Form Edit) -->
                <div class="lg:col-span-2 space-y-6">
                    <div class="bg-white rounded-2xl border border-slate-200 p-6 shadow-xs space-y-5">

                        <!-- Judul Berita -->
                        <div>
                            <label for="title"
                                class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                                Judul Berita <span class="text-rose-500">*</span>
                            </label>
                            <input type="text" name="title" id="title" value="{{ old('title', $post->title) }}"
                                required
                                class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-slate-900 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all">
                            @error('title')
                                <p class="text-rose-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Kategori Berita -->
                        <div>
                            <label for="category"
                                class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                                Kategori <span class="text-rose-500">*</span>
                            </label>
                            <input type="text" name="category" id="category"
                                value="{{ old('category', $post->category) }}" required
                                class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-slate-900 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all">
                            @error('category')
                                <p class="text-rose-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Ringkasan / Excerpt -->
                        <div>
                            <label for="excerpt"
                                class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                                Ringkasan Pendek (Excerpt) <span class="text-rose-500">* (Maks 300 karakter)</span>
                            </label>
                            <textarea name="excerpt" id="excerpt" rows="3" required maxlength="300"
                                class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-slate-900 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all">{{ old('excerpt', $post->excerpt) }}</textarea>
                            @error('excerpt')
                                <p class="text-rose-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Konten Lengkap / Quill WYSIWYG Editor -->
                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                                Isi Konten Berita <span class="text-rose-500">*</span>
                            </label>
                            <div id="wysiwyg-editor" class="h-64 mb-12 bg-white rounded-b-xl"></div>
                            <textarea name="body" id="description" class="hidden">{{ old('body', $post->body) }}</textarea>
                            @error('body')
                                <p class="text-rose-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Ganti Cover Image -->
                        <div>
                            <label for="cover_image"
                                class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                                Ganti Foto Cover <span class="text-slate-400 font-normal">(Kosongkan jika tidak ingin
                                    mengubah)</span>
                            </label>
                            <input type="file" name="image" id="cover_image" accept="image/*"
                                class="block w-full text-sm text-slate-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 transition-all cursor-pointer">
                            <div id="cover-size-info" class="text-xs mt-2 hidden"></div>
                            @error('image')
                                <p class="text-rose-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Status Publish -->
                        <div class="pt-4 border-t border-slate-100">
                            <label class="inline-flex items-center gap-2 cursor-pointer">
                                <input type="checkbox" name="is_published" value="1"
                                    {{ old('is_published', $post->is_published) ? 'checked' : '' }}
                                    class="w-4 h-4 rounded text-blue-600 focus:ring-blue-500 border-slate-300">
                                <span class="text-sm font-semibold text-slate-700">Publikasikan Berita</span>
                            </label>
                        </div>

                    </div>

                    <div class="flex justify-end gap-3">
                        <button type="submit"
                            class="px-6 py-2.5 bg-blue-600 hover:bg-blue-700 text-white text-sm font-bold rounded-xl shadow-sm transition-all cursor-pointer">
                            <i class="ti ti-check mr-1"></i> Perbarui Berita
                        </button>
                    </div>
                </div>

                <!-- Kolom Kanan (Pratinjau Card Berita) -->
                <div class="lg:col-span-1">
                    <div class="sticky top-6 bg-white rounded-2xl border border-slate-200 p-5 shadow-xs space-y-4">
                        <h3 class="text-xs font-bold text-slate-400 uppercase tracking-wider">Pratinjau Card Berita</h3>

                        <div class="bg-white border border-slate-300 rounded-sm overflow-hidden p-3 shadow-2xs">
                            <div class="relative aspect-[16/10] bg-slate-200 overflow-hidden mb-3">
                                @php
                                    $currentImg = $post->image
                                        ? (Str::startsWith($post->image, 'http')
                                            ? $post->image
                                            : Storage::url($post->image))
                                        : '#';
                                @endphp
                                <img id="card-preview-cover" src="{{ $currentImg }}" alt="{{ $post->title }}"
                                    class="w-full h-full object-cover">
                                <div id="card-placeholder"
                                    class="w-full h-full flex flex-col items-center justify-center text-slate-400 p-4 hidden">
                                    <i class="ti ti-photo text-2xl mb-1"></i>
                                    <span class="text-[10px]">Belum ada gambar</span>
                                </div>
                                <span id="preview-category"
                                    class="absolute top-2 left-2 px-2 py-0.5 bg-slate-900 text-white text-[9px] font-bold uppercase rounded">
                                    {{ old('category', $post->category) }}
                                </span>
                            </div>
                            <div class="space-y-1.5">
                                <span
                                    class="text-[10px] text-slate-400 font-serif italic">{{ $post->created_at->format('d M Y') }}</span>
                                <h4 id="card-preview-title"
                                    class="font-serif text-sm font-bold text-slate-900 leading-snug line-clamp-2">
                                    {{ old('title', $post->title) }}
                                </h4>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
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
