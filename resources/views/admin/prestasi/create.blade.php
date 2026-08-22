@extends('layouts.admin')

@section('title', 'Tambah Prestasi')
@section('header_title', 'Tambah Prestasi Baru')

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
        <a href="{{ route('admin.prestasi.index') }}"
            class="inline-flex items-center gap-2 px-3.5 py-2 bg-white hover:bg-slate-50 border border-slate-200 text-slate-700 text-sm font-semibold rounded-xl">
            <i class="ti ti-arrow-left"></i> Kembali
        </a>
    </div>

    <form method="POST" action="{{ route('admin.prestasi.store') }}" enctype="multipart/form-data" id="prestasi-form">
        @csrf
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
            <!-- KIRI: FORM -->
            <div class="lg:col-span-7 xl:col-span-8 bg-white rounded-2xl border p-6 sm:p-8 space-y-4">
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <div>
                        <div class="flex items-center justify-between mb-1.5">
                            <label class="block text-xs font-bold text-slate-700">Ikon (Tabler)</label>
                            <a href="https://tabler.io/icons" target="_blank" rel="noopener noreferrer"
                                class="inline-flex items-center gap-1 text-[11px] font-semibold text-blue-600 hover:text-blue-700 hover:underline">
                                <span>Cari Simbol</span>
                                <i class="ti ti-external-link text-xs"></i>
                            </a>
                        </div>
                        <div class="flex items-center gap-2.5">
                            <div
                                class="w-10 h-10 rounded-xl bg-blue-50 text-blue-600 border border-blue-200 flex items-center justify-center text-lg shrink-0">
                                <i id="preview-icon-element" class="ti {{ old('icon', 'ti-trophy') }}"></i>
                            </div>
                            <input type="text" id="icon" name="icon" value="{{ old('icon', 'ti-trophy') }}"
                                required
                                class="w-full px-3.5 py-2 bg-slate-50 border border-slate-300 rounded-xl text-sm outline-none focus:ring-2 focus:ring-blue-500/20">
                        </div>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1.5">Tingkatan / Level</label>
                        <input type="text" id="category" name="category" value="{{ old('category') }}"
                            placeholder="Cth: Kabupaten"
                            class="w-full px-3.5 py-2 bg-slate-50 border border-slate-300 rounded-xl text-sm outline-none focus:ring-2 focus:ring-blue-500/20">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1.5">Tahun</label>
                        <input type="text" id="year" name="year" value="{{ old('year', date('Y')) }}" required
                            maxlength="4"
                            class="w-full px-3.5 py-2 bg-slate-50 border border-slate-300 rounded-xl text-sm outline-none focus:ring-2 focus:ring-blue-500/20">
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1.5">Judul / Nama Kejuaraan</label>
                    <input type="text" id="title" name="title" value="{{ old('title') }}" required
                        class="w-full px-3.5 py-2 bg-slate-50 border border-slate-300 rounded-xl text-sm outline-none focus:ring-2 focus:ring-blue-500/20">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1.5">Deskripsi Ringkas</label>
                    <textarea id="short_description" name="short_description" rows="2" required maxlength="500"
                        class="w-full px-3.5 py-2 bg-slate-50 border border-slate-300 rounded-xl text-sm outline-none focus:ring-2 focus:ring-blue-500/20">{{ old('short_description') }}</textarea>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1.5">Deskripsi Lengkap</label>
                    <div id="wysiwyg-editor"></div>
                    <textarea id="description" name="description" class="hidden" required>{{ old('description') }}</textarea>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 pt-2">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1.5">Foto Utama (Maks. 2MB)</label>
                        <input type="file" id="cover_image" name="cover_image" accept="image/*" required
                            class="w-full px-2.5 py-1.5 bg-slate-50/50 border border-slate-300 rounded-xl text-xs text-slate-600 file:mr-2 file:py-1 file:px-2.5 file:rounded-lg file:border-0 file:bg-blue-50 file:text-blue-700 file:text-xs file:font-semibold hover:file:bg-blue-100 transition-all cursor-pointer">
                        <div id="cover-size-info" class="text-[11px] text-slate-500 mt-1 hidden"></div>
                        <p class="text-[10px] text-slate-400 mt-0.5">Maksimal file 2MB.</p>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1.5">Foto Galeri <span
                                class="text-slate-400 font-normal">(Maks. 3 Foto)</span></label>
                        <input type="file" id="gallery" name="gallery[]" accept="image/*" multiple
                            class="w-full px-2.5 py-1.5 bg-slate-50/50 border border-slate-300 rounded-xl text-xs text-slate-600 file:mr-2 file:py-1 file:px-2.5 file:rounded-lg file:border-0 file:bg-blue-50 file:text-blue-700 file:text-xs file:font-semibold hover:file:bg-blue-100 transition-all cursor-pointer">
                        <div id="gallery-size-info" class="text-[11px] text-slate-500 mt-1 space-y-0.5 hidden"></div>
                        <p class="text-[10px] text-slate-400 mt-0.5">Maks. 3 foto & 2MB per file.</p>
                    </div>
                </div>
            </div>

            <!-- KANAN: PENGATURAN & PREVIEW -->
            <div class="lg:col-span-5 xl:col-span-4 space-y-6">
                <!-- PREVIEW KARTU -->
                <div class="bg-white rounded-2xl border border-slate-200 p-5">
                    <h3 class="text-xs font-bold text-slate-700 uppercase mb-4 border-b pb-2">
                        <i class="ti ti-eye text-blue-600"></i> Pratinjau Kartu
                    </h3>
                    <div class="bg-slate-50 border border-slate-200 rounded-xl overflow-hidden shadow-2xs">
                        <div class="relative w-full h-36 bg-slate-200 flex items-center justify-center overflow-hidden">
                            <img id="card-preview-cover" class="w-full h-full object-cover hidden">
                            <span id="card-placeholder" class="text-xs text-slate-400 font-medium">Area Foto Cover</span>
                            <div class="absolute top-2.5 right-2.5">
                                <span id="preview-year"
                                    class="px-2 py-0.5 bg-slate-950/80 text-white text-[10px] font-bold rounded">2026</span>
                            </div>
                        </div>
                        <div class="p-4 space-y-2">
                            <div class="flex items-center gap-2">
                                <div
                                    class="w-7 h-7 rounded-lg bg-amber-500/10 text-amber-600 flex items-center justify-center text-sm">
                                    <i id="preview-card-icon" class="ti ti-trophy"></i>
                                </div>
                                <span id="preview-category"
                                    class="text-[11px] font-bold text-blue-700 uppercase">Tingkatan</span>
                            </div>
                            <h4 id="card-preview-title" class="font-serif text-sm font-bold text-slate-900 leading-snug">
                                Judul Kejuaraan Siswa</h4>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-2xl border border-slate-200 p-5 space-y-4">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1.5">Urutan Tampil</label>
                        <input type="number" name="sort_order" value="{{ old('sort_order', 0) }}"
                            class="w-full px-3.5 py-2 bg-slate-50 border border-slate-300 rounded-xl text-sm outline-none focus:ring-2 focus:ring-blue-500/20">
                    </div>
                    <div>
                        <label class="relative inline-flex items-center cursor-pointer gap-3">
                            <input type="checkbox" name="is_published" value="1" checked class="sr-only peer">
                            <div
                                class="w-9 h-5 bg-slate-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:bg-blue-600 after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:rounded-full after:h-4 after:w-4 after:transition-all">
                            </div>
                            <span class="text-sm font-semibold text-slate-700">Tayangkan Langsung</span>
                        </label>
                    </div>
                    <button type="submit"
                        class="w-full py-3 bg-blue-600 hover:bg-blue-700 text-white font-bold text-sm rounded-xl transition-all cursor-pointer">Simpan
                        Prestasi</button>
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
