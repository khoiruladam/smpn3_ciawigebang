@extends('layouts.admin')

@section('title', 'Edit Fasilitas')
@section('header_title', 'Edit Fasilitas Sekolah')

{{-- Include Quill.js CSS untuk WYSIWYG Editor --}}
@push('styles')
    <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
    <style>
        .ql-toolbar.ql-snow {
            border-top-left-radius: 0.75rem;
            border-top-right-radius: 0.75rem;
            border-color: #cbd5e1;
            background-color: #f8fafc;
        }

        .ql-container.ql-snow {
            border-bottom-left-radius: 0.75rem;
            border-bottom-right-radius: 0.75rem;
            border-color: #cbd5e1;
            font-family: inherit;
            min-height: 140px;
        }
    </style>
@endpush

@section('content')

    <!-- Tombol Kembali -->
    <div class="mb-6">
        <a href="{{ route('admin.facilities.index') }}"
            class="inline-flex items-center gap-2 px-3.5 py-2 bg-white hover:bg-slate-50 border border-slate-200 text-slate-700 text-xs sm:text-sm font-semibold rounded-xl shadow-2xs transition-all">
            <i class="ti ti-arrow-left text-base text-slate-500" aria-hidden="true"></i>
            <span>Kembali ke Daftar Fasilitas</span>
        </a>
    </div>

    <form method="POST" action="{{ route('admin.facilities.update', $facility) }}" enctype="multipart/form-data"
        id="facility-form">
        @csrf
        @method('PUT')

        <!-- Container Utama 2 Kolom Layout Sejajar -->
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">

            <!-- KOLOM KIRI: FORMULIR UTAMA (Ringkas & Efisien) -->
            <div
                class="lg:col-span-7 xl:col-span-8 bg-white rounded-2xl border border-slate-200 shadow-xs p-6 sm:p-8 space-y-4">
                <div class="pb-3 border-b border-slate-100">
                    <h2 class="text-base font-bold text-slate-900">Formulir Edit Fasilitas</h2>
                    <p class="text-xs text-slate-500 mt-0.5">Perbarui informasi, sampul, dan deskripsi fasilitas sekolah
                        ini.</p>
                </div>

                <!-- Grid Baris 1: Simbol & Kategori/Tag -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <!-- Nama Icon -->
                    <div>
                        <label for="icon" class="block text-xs font-bold text-slate-700 mb-1.5">Simbol / Ikon (Tabler
                            Icons)</label>
                        <div class="flex items-center gap-2.5">
                            <div id="icon-preview-box"
                                class="w-10 h-10 rounded-xl bg-blue-50 text-blue-600 border border-blue-200 flex items-center justify-center text-lg shrink-0 shadow-2xs">
                                <i id="preview-icon-element"
                                    class="ti {{ old('icon', $facility->icon ?? 'ti-building') }}"></i>
                            </div>
                            <div class="relative flex-1">
                                <input type="text" id="icon" name="icon"
                                    value="{{ old('icon', $facility->icon) }}" required placeholder="Contoh: ti-school"
                                    class="w-full px-3.5 py-2 bg-slate-50/50 border border-slate-300 rounded-xl text-sm focus:bg-white focus:ring-2 focus:ring-blue-500/20 focus:border-blue-600 outline-none transition-all">
                            </div>
                        </div>
                    </div>

                    <!-- Tag / Kategori -->
                    <div>
                        <label for="tag" class="block text-xs font-bold text-slate-700 mb-1.5">Kategori / Tag <span
                                class="text-slate-400 font-normal">(Opsional)</span></label>
                        <div class="relative">
                            <input type="text" id="tag" name="tag" value="{{ old('tag', $facility->tag) }}"
                                placeholder="Contoh: Akademik"
                                class="w-full px-3.5 py-2 bg-slate-50/50 border border-slate-300 rounded-xl text-sm focus:bg-white focus:ring-2 focus:ring-blue-500/20 focus:border-blue-600 outline-none transition-all">
                        </div>
                    </div>
                </div>

                <!-- Nama Fasilitas -->
                <div>
                    <label for="name" class="block text-xs font-bold text-slate-700 mb-1.5">Nama Fasilitas</label>
                    <input type="text" id="name" name="name" value="{{ old('name', $facility->name) }}" required
                        placeholder="Contoh: Perpustakaan Digital"
                        class="w-full px-3.5 py-2 bg-slate-50/50 border border-slate-300 rounded-xl text-sm focus:bg-white focus:ring-2 focus:ring-blue-500/20 focus:border-blue-600 outline-none transition-all">
                </div>

                <!-- Deskripsi Singkat -->
                <div>
                    <label for="short_description" class="block text-xs font-bold text-slate-700 mb-1.5">Deskripsi
                        Ringkas</label>
                    <textarea id="short_description" name="short_description" rows="2" required maxlength="500"
                        placeholder="Ringkasan singkat yang akan muncul pada kartu di halaman utama..."
                        class="w-full px-3.5 py-2 bg-slate-50/50 border border-slate-300 rounded-xl text-sm focus:bg-white focus:ring-2 focus:ring-blue-500/20 focus:border-blue-600 outline-none transition-all">{{ old('short_description', $facility->short_description ?? $facility->desc) }}</textarea>
                </div>

                <!-- Deskripsi Lengkap dengan Editor -->
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1.5">Deskripsi Lengkap (Detail Halaman)</label>
                    <div id="wysiwyg-editor"></div>
                    <textarea id="description" name="description" class="hidden" required>{{ old('description', $facility->description ?? $facility->content) }}</textarea>
                </div>

                <!-- Galeri Foto Saat Ini (Jika Ada) -->
                @php
                    $existingImages = collect();
                    if (is_a($facility->images, 'Illuminate\Database\Eloquent\Collection')) {
                        $existingImages = $facility->images;
                    }
                @endphp

                @if ($existingImages->count() > 0)
                    <div class="pt-2 border-t border-slate-100">
                        <label class="block text-xs font-bold text-slate-700 mb-1.5">Galeri Foto Saat Ini</label>
                        <div class="grid grid-cols-3 gap-3">
                            @foreach ($existingImages as $img)
                                <div
                                    class="relative group rounded-xl overflow-hidden border border-slate-200 aspect-video bg-slate-100">
                                    <img src="{{ Storage::url($img->image_path ?? $img->path) }}" alt="Foto Galeri"
                                        class="w-full h-full object-cover">
                                    <div
                                        class="absolute inset-0 bg-slate-900/40 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                                        <button type="button"
                                            onclick="openDeleteModal('{{ route('admin.facilities.images.destroy', $img) }}', 'foto galeri ini')"
                                            class="w-8 h-8 rounded-full bg-rose-600 text-white flex items-center justify-center text-sm hover:bg-rose-700 transition-all cursor-pointer"
                                            title="Hapus Foto">
                                            <i class="ti ti-trash"></i>
                                        </button>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                <!-- Grid Baris 2: Foto Cover & Foto Galeri -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 pt-2">
                    <!-- Ganti Foto Cover Utama -->
                    <div>
                        <label for="cover_image" class="block text-xs font-bold text-slate-700 mb-1.5">
                            Ganti Cover Utama <span class="text-slate-400 font-normal">(Opsional)</span>
                        </label>
                        <input type="file" id="cover_image" name="cover_image" accept="image/*"
                            class="w-full px-2.5 py-1.5 bg-slate-50/50 border border-slate-300 rounded-xl text-xs text-slate-600 file:mr-2 file:py-1 file:px-2.5 file:rounded-lg file:border-0 file:bg-blue-50 file:text-blue-700 file:text-xs file:font-semibold hover:file:bg-blue-100 transition-all cursor-pointer">
                        <div id="cover-size-info" class="text-[11px] text-slate-500 mt-1 hidden"></div>
                        <p class="text-[10px] text-slate-400 mt-0.5">Kosongkan jika tidak mau mengubah cover. Maks. 2MB.</p>
                    </div>

                    <!-- Tambah Foto Galeri Baru -->
                    <div>
                        <label for="gallery" class="block text-xs font-bold text-slate-700 mb-1.5">
                            Tambah Foto Galeri <span class="text-slate-400 font-normal">(Maks. 3 Foto)</span>
                        </label>
                        <input type="file" id="gallery" name="gallery[]" accept="image/*" multiple
                            class="w-full px-2.5 py-1.5 bg-slate-50/50 border border-slate-300 rounded-xl text-xs text-slate-600 file:mr-2 file:py-1 file:px-2.5 file:rounded-lg file:border-0 file:bg-blue-50 file:text-blue-700 file:text-xs file:font-semibold hover:file:bg-blue-100 transition-all cursor-pointer">
                        <div id="gallery-size-info" class="text-[11px] text-slate-500 mt-1 space-y-0.5 hidden"></div>
                        <p class="text-[10px] text-slate-400 mt-0.5">Foto baru akan ditambahkan. Maks. 2MB per file.</p>
                    </div>
                </div>
            </div>

            <!-- KOLOM KANAN: PREVIEW & PENGATURAN -->
            <div class="lg:col-span-5 xl:col-span-4 space-y-6">

                <!-- KOTAK PREVIEW KARTU DEPAN -->
                <div class="bg-white rounded-2xl border border-slate-200 shadow-xs p-5">
                    <div
                        class="flex items-center gap-2 pb-3 mb-4 border-b border-slate-100 text-xs font-bold text-slate-700 uppercase tracking-wider">
                        <i class="ti ti-eye text-blue-600 text-base"></i>
                        <span>Pratinjau Kartu Depan</span>
                    </div>

                    <div
                        class="bg-slate-50 border border-slate-200 rounded-2xl p-4 flex flex-col justify-between space-y-4">
                        <div>
                            <!-- Header Kartu & Foto Sampul -->
                            @php
                                $coverUrl =
                                    $facility->cover_image || $facility->image
                                        ? Storage::url($facility->cover_image ?? $facility->image)
                                        : '';
                            @endphp
                            <div
                                class="relative w-full h-36 rounded-xl overflow-hidden bg-slate-200 mb-3 border border-slate-200">
                                <img id="card-preview-cover" src="{{ $coverUrl }}"
                                    class="w-full h-full object-cover {{ empty($coverUrl) ? 'hidden' : '' }}"
                                    alt="Preview Cover">
                                <div id="card-preview-placeholder"
                                    class="w-full h-full flex flex-col items-center justify-center text-slate-400 gap-1 {{ !empty($coverUrl) ? 'hidden' : '' }}">
                                    <i class="ti ti-photo text-2xl"></i>
                                    <span class="text-[10px] font-semibold">Foto Cover Utama</span>
                                </div>
                                <span id="card-preview-tag"
                                    class="absolute top-2.5 right-2.5 px-2 py-0.5 rounded-md bg-white/90 backdrop-blur-xs text-slate-700 border border-slate-200 text-[10px] font-semibold {{ empty($facility->tag) ? 'hidden' : '' }}">
                                    {{ $facility->tag }}
                                </span>
                            </div>

                            <!-- Ikon & Judul -->
                            <div class="flex items-center gap-2.5 mb-2">
                                <div
                                    class="w-8 h-8 rounded-lg bg-blue-50 text-blue-600 border border-blue-100 flex items-center justify-center text-base shrink-0">
                                    <i id="card-preview-icon" class="ti {{ $facility->icon ?? 'ti-building' }}"></i>
                                </div>
                                <h3 id="card-preview-title" class="font-bold text-slate-900 text-sm line-clamp-1">
                                    {{ $facility->name ?? 'Nama Fasilitas' }}
                                </h3>
                            </div>

                            <!-- Deskripsi Ringkas -->
                            <p id="card-preview-desc" class="text-xs text-slate-500 leading-relaxed line-clamp-3">
                                {{ $facility->short_description ?? ($facility->desc ?? 'Deskripsi ringkas fasilitas akan muncul di bagian ini pada halaman utama.') }}
                            </p>
                        </div>

                        <div
                            class="pt-2.5 border-t border-slate-200 flex items-center justify-between text-xs font-semibold text-blue-600">
                            <span>Lihat Detail</span>
                            <i class="ti ti-arrow-right"></i>
                        </div>
                    </div>
                </div>

                <!-- KOTAK PENGATURAN TAMPILAN & AKSI -->
                <div class="bg-white rounded-2xl border border-slate-200 shadow-xs p-5 space-y-4">
                    <div
                        class="pb-3 border-b border-slate-100 text-xs font-bold text-slate-700 uppercase tracking-wider flex items-center gap-2">
                        <i class="ti ti-settings text-blue-600 text-base"></i>
                        <span>Pengaturan & Akses</span>
                    </div>

                    <!-- Urutan Tampil -->
                    <div>
                        <label for="sort_order" class="block text-xs font-bold text-slate-700 mb-1.5">Urutan
                            Tampil</label>
                        <input type="number" id="sort_order" name="sort_order"
                            value="{{ old('sort_order', $facility->sort_order) }}"
                            class="w-full px-3.5 py-2 bg-slate-50/50 border border-slate-300 rounded-xl text-sm focus:bg-white focus:ring-2 focus:ring-blue-500/20 focus:border-blue-600 outline-none transition-all">
                        <p class="text-[11px] text-slate-400 mt-1">Angka lebih kecil tampil di posisi awal.</p>
                    </div>

                    <!-- Status Tayang -->
                    <div class="pt-1">
                        <label class="relative inline-flex items-center cursor-pointer gap-3">
                            <input type="checkbox" id="is_published" name="is_published" value="1"
                                {{ old('is_published', $facility->is_published ?? true) ? 'checked' : '' }}
                                class="sr-only peer">
                            <div
                                class="w-9 h-5 bg-slate-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-slate-300 after:border after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-blue-600">
                            </div>
                            <span class="text-xs sm:text-sm font-semibold text-slate-700">Tayangkan Langsung</span>
                        </label>
                    </div>

                    <!-- Tombol Submit -->
                    <div class="pt-2">
                        <button type="submit"
                            class="w-full flex items-center justify-center gap-2 py-3 bg-blue-600 hover:bg-blue-700 text-white font-bold text-sm rounded-xl shadow-sm transition-all cursor-pointer">
                            <i class="ti ti-device-floppy text-base"></i>
                            <span>Simpan Perubahan Fasilitas</span>
                        </button>
                    </div>
                </div>

            </div>

        </div>
    </form>

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
