@extends('layouts.admin')

@section('title', 'Edit Kartu Statistik')
@section('header_title', 'Edit Kartu Statistik SSK')

@section('content')

    <div class="max-w-2xl mx-auto">
        <!-- Tombol Kembali yang Jelas -->
        <div class="mb-6">
            <a href="{{ route('admin.ssk.index') }}"
                class="inline-flex items-center gap-2 px-3.5 py-2 bg-white hover:bg-slate-50 border border-slate-200 text-slate-700 text-xs sm:text-sm font-semibold rounded-xl shadow-2xs transition-all">
                <i class="ti ti-arrow-left text-base text-slate-500" aria-hidden="true"></i>
                <span>Kembali ke Kelola SSK</span>
            </a>
        </div>

        <div class="bg-white rounded-2xl border border-slate-200 shadow-xs p-6 sm:p-8">

            <div class="mb-6 pb-4 border-b border-slate-100">
                <h2 class="text-base font-bold text-slate-900">Formulir Edit Kartu Statistik</h2>
                <p class="text-xs sm:text-sm text-slate-500 mt-0.5">Perbarui informasi dan nilai angka untuk kartu statistik
                    ini.</p>
            </div>

            <form method="POST" action="{{ route('admin.ssk.stats.update', $stat) }}" class="space-y-5">
                @csrf
                @method('PUT')

                <!-- Nama Icon dengan Live Preview -->
                <div>
                    <label for="icon" class="block text-xs sm:text-sm font-bold text-slate-700 mb-1.5">Simbol / Ikon
                        (Tabler Icons)</label>
                    <div class="flex items-center gap-3">
                        <!-- Kotak Preview Ikon -->
                        <div id="icon-preview-box"
                            class="w-11 h-11 rounded-xl bg-blue-50 text-blue-600 border border-blue-200 flex items-center justify-center text-xl shrink-0 shadow-2xs transition-all">
                            <i id="preview-icon-element" class="ti {{ old('icon', $stat->icon) }}"></i>
                        </div>
                        <div class="relative flex-1">
                            <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 text-slate-400">
                                <i class="ti ti-icons text-base"></i>
                            </span>
                            <input type="text" id="icon" name="icon" value="{{ old('icon', $stat->icon) }}"
                                required placeholder="Contoh: ti-school, ti-users, ti-map-2"
                                class="w-full pl-10 pr-4 py-2.5 bg-slate-50/50 border border-slate-300 rounded-xl text-sm focus:bg-white focus:ring-2 focus:ring-blue-500/20 focus:border-blue-600 outline-none transition-all">
                        </div>
                    </div>
                    <p class="text-[11px] text-slate-400 mt-1.5">
                        Ketik nama kelas ikon Tabler. Contoh: <code
                            class="bg-slate-100 px-1 py-0.5 rounded text-slate-600">ti-school</code>. Cari referensinya di
                        <a href="https://tabler.io/icons" target="_blank"
                            class="text-blue-600 font-semibold underline">tabler.io/icons</a>.
                    </p>
                </div>

                <!-- Label -->
                <div>
                    <label for="label" class="block text-xs sm:text-sm font-bold text-slate-700 mb-1.5">Judul Statistik
                        (Label)</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 text-slate-400">
                            <i class="ti ti-tag text-base"></i>
                        </span>
                        <input type="text" id="label" name="label" value="{{ old('label', $stat->label) }}"
                            required placeholder="Contoh: Rombongan Belajar, Jumlah Siswa, dll."
                            class="w-full pl-10 pr-4 py-2.5 bg-slate-50/50 border border-slate-300 rounded-xl text-sm focus:bg-white focus:ring-2 focus:ring-blue-500/20 focus:border-blue-600 outline-none transition-all">
                    </div>
                </div>

                <!-- Nilai dan Suffix -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label for="value" class="block text-xs sm:text-sm font-bold text-slate-700 mb-1.5">Nilai
                            Angka</label>
                        <input type="number" step="0.01" id="value" name="value"
                            value="{{ old('value', $stat->value) }}" required placeholder="Contoh: 450"
                            class="w-full px-4 py-2.5 bg-slate-50/50 border border-slate-300 rounded-xl text-sm focus:bg-white focus:ring-2 focus:ring-blue-500/20 focus:border-blue-600 outline-none transition-all">
                    </div>
                    <div>
                        <label for="suffix" class="block text-xs sm:text-sm font-bold text-slate-700 mb-1.5">Simbol
                            Tambahan <span class="text-slate-400 font-normal">(Opsional)</span></label>
                        <input type="text" id="suffix" name="suffix" value="{{ old('suffix', $stat->suffix) }}"
                            placeholder="Contoh: +, %, Jiwa"
                            class="w-full px-4 py-2.5 bg-slate-50/50 border border-slate-300 rounded-xl text-sm focus:bg-white focus:ring-2 focus:ring-blue-500/20 focus:border-blue-600 outline-none transition-all">
                        <p class="text-[11px] text-slate-400 mt-1">Akan diletakkan persis di belakang angka (misal: +).</p>
                    </div>
                </div>

                <!-- Desimal -->
                <div>
                    <label for="decimals" class="block text-xs sm:text-sm font-bold text-slate-700 mb-1.5">Jumlah Angka di
                        Belakang Koma</label>
                    <input type="number" id="decimals" name="decimals" value="{{ old('decimals', $stat->decimals) }}"
                        min="0" max="2" required
                        class="w-full px-4 py-2.5 bg-slate-50/50 border border-slate-300 rounded-xl text-sm focus:bg-white focus:ring-2 focus:ring-blue-500/20 focus:border-blue-600 outline-none transition-all">
                    <p class="text-[11px] text-slate-400 mt-1">Pilih <strong>0</strong> jika berupa angka bulat (contoh:
                        120), atau <strong>1</strong> jika ada komanya (contoh: 98.5).</p>
                </div>

                <!-- Keterangan Tambahan -->
                <div>
                    <label for="sub" class="block text-xs sm:text-sm font-bold text-slate-700 mb-1.5">Keterangan
                        Tambahan <span class="text-slate-400 font-normal">(Opsional)</span></label>
                    <input type="text" id="sub" name="sub" value="{{ old('sub', $stat->sub) }}"
                        placeholder="Contoh: Kelas VII sampai IX"
                        class="w-full px-4 py-2.5 bg-slate-50/50 border border-slate-300 rounded-xl text-sm focus:bg-white focus:ring-2 focus:ring-blue-500/20 focus:border-blue-600 outline-none transition-all">
                </div>

                <!-- Urutan Tampil -->
                <div>
                    <label for="sort_order" class="block text-xs sm:text-sm font-bold text-slate-700 mb-1.5">Urutan
                        Tampil</label>
                    <input type="number" id="sort_order" name="sort_order"
                        value="{{ old('sort_order', $stat->sort_order) }}"
                        class="w-full px-4 py-2.5 bg-slate-50/50 border border-slate-300 rounded-xl text-sm focus:bg-white focus:ring-2 focus:ring-blue-500/20 focus:border-blue-600 outline-none transition-all">
                    <p class="text-[11px] text-slate-400 mt-1">Semakin kecil angkanya, maka akan tampil di posisi paling
                        depan.</p>
                </div>

                <!-- Tombol Submit -->
                <div class="pt-2">
                    <button type="submit"
                        class="w-full flex items-center justify-center gap-2 py-3 bg-blue-600 hover:bg-blue-700 text-white font-bold text-sm rounded-xl shadow-sm transition-all cursor-pointer">
                        <i class="ti ti-device-floppy text-base"></i>
                        <span>Simpan Perubahan Kartu</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
