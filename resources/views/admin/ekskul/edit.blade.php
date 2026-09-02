@extends('layouts.admin')

@section('title', 'Edit Ekskul')
@section('header_title', 'Edit Ekstrakurikuler')

@push('styles')
    <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
    <style>
        .ql-toolbar.ql-snow {
            border-radius: 0.75rem 0.75rem 0 0;
            background-color: #f8fafc;
        }

        .ql-container.ql-snow {
            border-radius: 0 0 0.75rem 0.75rem;
            min-height: 140px;
        }
    </style>
@endpush

@section('content')
    <div class="mb-6">
        <a href="{{ route('admin.ekskul.index') }}"
            class="inline-flex items-center gap-2 px-3.5 py-2 bg-white hover:bg-slate-50 border border-slate-200 text-slate-700 text-sm font-semibold rounded-xl">
            <i class="ti ti-arrow-left"></i> Kembali
        </a>
    </div>

    <form method="POST" action="{{ route('admin.ekskul.update', $ekskul) }}" enctype="multipart/form-data" id="ekskul-form">
        @csrf @method('PUT')

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
            <!-- KIRI: FORM -->
            <div class="lg:col-span-7 xl:col-span-8 bg-white rounded-2xl border p-6 sm:p-8 space-y-4">

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <div class="flex items-center justify-between mb-1.5">
                            <label class="block text-xs font-bold text-slate-700">Simbol / Ikon</label>
                            <a href="https://tabler.io/icons" target="_blank" rel="noopener noreferrer"
                                class="inline-flex items-center gap-1 text-[11px] font-semibold text-blue-600 hover:text-blue-700 hover:underline">
                                <span>Cari Simbol</span>
                                <i class="ti ti-external-link text-xs"></i>
                            </a>
                        </div>
                        <div class="flex items-center gap-2.5">
                            <div
                                class="w-10 h-10 rounded-xl bg-blue-50 text-blue-600 border border-blue-200 flex items-center justify-center text-lg shrink-0">
                                <i id="preview-icon-element" class="ti {{ old('icon', $ekskul->icon) }}"></i>
                            </div>
                            <input type="text" id="icon" name="icon" value="{{ old('icon', $ekskul->icon) }}"
                                required
                                class="w-full px-3.5 py-2 bg-slate-50 border border-slate-300 rounded-xl text-sm outline-none focus:ring-2 focus:ring-blue-500/20">
                        </div>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1.5">Kategori / Tag</label>
                        <input type="text" id="category" name="category"
                            value="{{ old('category', $ekskul->category) }}"
                            class="w-full px-3.5 py-2 bg-slate-50 border border-slate-300 rounded-xl text-sm outline-none focus:ring-2 focus:ring-blue-500/20">
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1.5">Nama Ekskul</label>
                    <input type="text" id="name" name="name" value="{{ old('name', $ekskul->name) }}" required
                        class="w-full px-3.5 py-2 bg-slate-50 border border-slate-300 rounded-xl text-sm outline-none focus:ring-2 focus:ring-blue-500/20">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1.5">Deskripsi Ringkas</label>
                    <textarea id="short_description" name="short_description" rows="2" required maxlength="500"
                        class="w-full px-3.5 py-2 bg-slate-50 border border-slate-300 rounded-xl text-sm outline-none focus:ring-2 focus:ring-blue-500/20">{{ old('short_description', $ekskul->short_description) }}</textarea>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1.5">Deskripsi Lengkap</label>
                    <div id="wysiwyg-editor"></div>
                    <textarea id="description" name="description" class="hidden" required>{{ old('description', $ekskul->description) }}</textarea>
                </div>

                <!-- Kelola Galeri -->
                @php $galleryImages = is_array($ekskul->gallery) ? $ekskul->gallery : []; @endphp
                @if (count($galleryImages) > 0)
                    <div class="pt-4 border-t">
                        <label class="block text-xs font-bold text-slate-700 mb-2">Galeri Saat Ini</label>
                        <div class="grid grid-cols-3 gap-3">
                            @foreach ($galleryImages as $index => $img)
                                <div class="relative group rounded-xl overflow-hidden aspect-video bg-slate-100">
                                    <img src="{{ Storage::url($img) }}" class="w-full h-full object-cover">
                                    <button type="button"
                                        onclick="event.preventDefault(); document.getElementById('delete-gal-{{ $index }}').submit();"
                                        class="absolute inset-0 bg-slate-900/40 opacity-0 group-hover:opacity-100 flex items-center justify-center text-white transition-opacity cursor-pointer">
                                        <i class="ti ti-trash text-lg bg-rose-600 rounded-full p-2"></i>
                                    </button>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 pt-2">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1.5">Ganti Cover Utama</label>
                        <input type="file" id="cover_image" name="cover_image" accept="image/*"
                            class="w-full px-2.5 py-1.5 bg-slate-50/50 border border-slate-300 rounded-xl text-xs text-slate-600 file:mr-2 file:py-1 file:px-2.5 file:rounded-lg file:border-0 file:bg-blue-50 file:text-blue-700 file:text-xs file:font-semibold hover:file:bg-blue-100 transition-all cursor-pointer">
                        <div id="cover-size-info" class="text-[11px] text-slate-500 mt-1 hidden"></div>
                        <p class="text-[10px] text-slate-400 mt-0.5">Kosongkan jika tidak diubah. Maks. 2MB.</p>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1.5">Tambah Foto Galeri <span
                                class="text-slate-400 font-normal">(Maks. 3)</span></label>
                        <input type="file" id="gallery" name="gallery[]" accept="image/*" multiple
                            class="w-full px-2.5 py-1.5 bg-slate-50/50 border border-slate-300 rounded-xl text-xs text-slate-600 file:mr-2 file:py-1 file:px-2.5 file:rounded-lg file:border-0 file:bg-blue-50 file:text-blue-700 file:text-xs file:font-semibold hover:file:bg-blue-100 transition-all cursor-pointer">
                        <div id="gallery-size-info" class="text-[11px] text-slate-500 mt-1 space-y-0.5 hidden"></div>
                        <p class="text-[10px] text-slate-400 mt-0.5">Maks. 2MB per file.</p>
                    </div>
                </div>
            </div>

            <!-- KANAN: PREVIEW & PENGATURAN -->
            <div class="lg:col-span-5 xl:col-span-4 space-y-6">
                <!-- PREVIEW KARTU -->
                <div class="bg-white rounded-2xl border border-slate-200 p-5">
                    <h3 class="text-xs font-bold text-slate-700 uppercase mb-4 border-b pb-2">
                        <i class="ti ti-eye text-blue-600"></i> Pratinjau Kartu
                    </h3>
                    <div class="bg-slate-50 border border-slate-200 rounded-xl p-4">
                        <div
                            class="w-full h-32 bg-slate-200 rounded-lg mb-3 flex items-center justify-center overflow-hidden">
                            <img id="card-preview-cover"
                                src="{{ $ekskul->cover_image ? Storage::url($ekskul->cover_image) : '' }}"
                                class="w-full h-full object-cover {{ $ekskul->cover_image ? '' : 'hidden' }}">
                            <span id="card-placeholder"
                                class="text-xs text-slate-400 {{ $ekskul->cover_image ? 'hidden' : '' }}">Cover Area</span>
                        </div>
                        <h4 id="card-preview-title" class="font-bold text-sm text-slate-900">
                            {{ old('name', $ekskul->name) ?: 'Nama Ekskul' }}</h4>
                        <p id="card-preview-desc" class="text-xs text-slate-500 line-clamp-2 mt-1">
                            {{ old('short_description', $ekskul->short_description) ?: 'Deskripsi ringkas...' }}</p>
                    </div>
                </div>

                <div class="bg-white rounded-2xl border p-5 space-y-4">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1.5">Urutan</label>
                        <input type="number" name="sort_order" value="{{ old('sort_order', $ekskul->sort_order) }}"
                            class="w-full px-3.5 py-2 bg-slate-50 border border-slate-300 rounded-xl text-sm outline-none focus:ring-2 focus:ring-blue-500/20">
                    </div>
                    <div>
                        <label class="relative inline-flex items-center cursor-pointer gap-3">
                            <input type="checkbox" name="is_published" value="1"
                                {{ $ekskul->is_published ? 'checked' : '' }} class="sr-only peer">
                            <div
                                class="w-9 h-5 bg-slate-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:bg-blue-600 after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:rounded-full after:h-4 after:w-4 after:transition-all">
                            </div>
                            <span class="text-sm font-semibold text-slate-700">Tayangkan</span>
                        </label>
                    </div>
                    <button type="submit"
                        class="w-full py-3 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-xl transition-all cursor-pointer">Update
                        Ekskul</button>
                </div>
            </div>
        </div>

        @include('admin.partials._seo-form', ['seo' => $ekskul->seo ?? null])
    </form>

    <!-- Hidden forms for deleting gallery images -->
    @foreach ($galleryImages as $index => $img)
        <form id="delete-gal-{{ $index }}"
            action="{{ route('admin.ekskul.gallery.destroy', [$ekskul->id, $index]) }}" method="POST" class="hidden">
            @csrf @method('DELETE')
        </form>
    @endforeach

    <!-- MODAL WARNING / ALERT CUSTOM -->
    <div id="custom-alert-modal"
        class="fixed inset-0 z-50 flex items-center justify-center bg-slate-900/40 backdrop-blur-xs opacity-0 pointer-events-none transition-opacity duration-200">
        <div class="bg-white rounded-2xl border border-slate-200 shadow-xl max-w-sm w-full p-6 text-center transform scale-95 transition-transform duration-200"
            id="custom-alert-card">
            <div
                class="w-12 h-12 rounded-full bg-rose-50 text-rose-600 border border-rose-100 mx-auto flex items-center justify-center text-2xl mb-4">
                <i class="ti ti-alert-triangle"></i>
            </div>
            <h3 id="alert-title" class="text-base font-bold text-slate-900 mb-1">Ukuran File Terlalu Besar</h3>
            <p id="alert-message" class="text-xs text-slate-500 leading-relaxed mb-6">File yang Anda pilih melebihi batas
                maksimal 2 MB. Harap pilih file yang lebih kecil.</p>
            <button type="button" id="close-alert-btn"
                class="w-full py-2.5 bg-slate-900 hover:bg-slate-800 text-white text-xs font-semibold rounded-xl transition-all cursor-pointer">
                Saya Mengerti
            </button>
        </div>
    </div>
@endsection
