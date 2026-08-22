@extends('layouts.admin')

@section('title', 'Tambah Guru & Staff')
@section('header_title', 'Tambah Guru & Staff Baru')

@section('content')
    <div class="mb-6">
        <a href="{{ route('admin.guru.index') }}"
            class="inline-flex items-center gap-2 px-3.5 py-2 bg-white hover:bg-slate-50 border border-slate-200 text-slate-700 text-sm font-semibold rounded-xl">
            <i class="ti ti-arrow-left"></i> Kembali
        </a>
    </div>

    <form method="POST" action="{{ route('admin.guru.store') }}" enctype="multipart/form-data">
        @csrf
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
            <!-- KIRI: FORM -->
            <div class="lg:col-span-7 xl:col-span-8 bg-white rounded-2xl border p-6 sm:p-8 space-y-4">
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1.5">Nama Lengkap & Gelar</label>
                    <input type="text" id="name" name="name" value="{{ old('name') }}" required
                        class="w-full px-3.5 py-2 bg-slate-50 border border-slate-300 rounded-xl text-sm outline-none focus:ring-2 focus:ring-blue-500/20">
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1.5">Jabatan Utama</label>
                        <input type="text" id="jabatan" name="jabatan" value="{{ old('jabatan') }}" required
                            placeholder="Contoh: Guru IPA / Petugas Kebersihan"
                            class="w-full px-3.5 py-2 bg-slate-50 border border-slate-300 rounded-xl text-sm outline-none focus:ring-2 focus:ring-blue-500/20">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1.5">Kategori / Bagian</label>
                        <select name="category" id="category" required
                            class="w-full px-3.5 py-2 bg-slate-50 border border-slate-300 rounded-xl text-sm outline-none focus:ring-2 focus:ring-blue-500/20">
                            <option value="guru" {{ old('category') == 'guru' ? 'selected' : '' }}>Dewan Guru</option>
                            <option value="kepsek" {{ old('category') == 'kepsek' ? 'selected' : '' }}>Kepala Sekolah
                            </option>
                            <option value="wakel" {{ old('category') == 'wakel' ? 'selected' : '' }}>Wakil Kepala Sekolah
                            </option>
                            <option value="staff" {{ old('category') == 'staff' ? 'selected' : '' }}>Staff / Tata Usaha
                            </option>
                            <option value="kebersihan" {{ old('category') == 'kebersihan' ? 'selected' : '' }}>Tim
                                Kebersihan & Keamanan</option>
                        </select>
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1.5">Sub Keterangan <span
                            class="text-slate-400 font-normal">(Opsional)</span></label>
                    <input type="text" id="sub" name="sub" value="{{ old('sub') }}"
                        placeholder="Contoh: Wali Kelas VIII A / Penanggung Jawab Lapangan"
                        class="w-full px-3.5 py-2 bg-slate-50 border border-slate-300 rounded-xl text-sm outline-none focus:ring-2 focus:ring-blue-500/20">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1.5">Foto Profil <span
                            class="text-slate-400 font-normal">(Maks. 2MB)</span></label>
                    <input type="file" id="cover_image" name="image" accept="image/*"
                        class="w-full px-2.5 py-1.5 bg-slate-50/50 border border-slate-300 rounded-xl text-xs text-slate-600 file:mr-2 file:py-1 file:px-2.5 file:rounded-lg file:border-0 file:bg-blue-50 file:text-blue-700 file:text-xs file:font-semibold hover:file:bg-blue-100 transition-all cursor-pointer">
                    <div id="cover-size-info" class="text-[11px] text-slate-500 mt-1 hidden"></div>
                </div>
            </div>

            <!-- KANAN: PREVIEW & PUBLISH -->
            <div class="lg:col-span-5 xl:col-span-4 space-y-6">
                <div class="bg-white rounded-2xl border border-slate-200 p-5">
                    <h3 class="text-xs font-bold text-slate-700 uppercase mb-4 border-b pb-2">
                        <i class="ti ti-eye text-blue-600"></i> Pratinjau Kartu
                    </h3>
                    <div class="bg-slate-50 border border-slate-200 rounded-xl p-4 flex items-center gap-3">
                        <div
                            class="w-12 h-12 rounded-full bg-slate-200 overflow-hidden shrink-0 flex items-center justify-center">
                            <img id="card-preview-cover" src="" class="w-full h-full object-cover hidden">
                            <i id="card-placeholder" class="ti ti-user text-slate-400 text-xl"></i>
                        </div>
                        <div class="overflow-hidden text-left">
                            <span id="preview-category"
                                class="block text-[10px] font-bold text-blue-600 uppercase tracking-wide truncate">GURU</span>
                            <h4 id="card-preview-title"
                                class="font-serif text-sm font-bold text-slate-900 truncate leading-snug">Nama Guru</h4>
                            <p id="preview-sub" class="text-[11px] text-slate-500 font-medium truncate mt-0.5">Sub
                                Keterangan</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-2xl border p-5 space-y-4">
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
                            <span class="text-sm font-semibold text-slate-700">Tayangkan</span>
                        </label>
                    </div>
                    <button type="submit"
                        class="w-full py-3 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-xl transition-all cursor-pointer">Simpan
                        Data</button>
                </div>
            </div>
        </div>
    </form>

    <!-- CUSTOM ALERT MODAL (Wajib ada agar fungsi showAlert() di app.js merender pop-up) -->
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
