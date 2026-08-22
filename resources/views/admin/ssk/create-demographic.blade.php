@extends('layouts.admin')

@section('title', 'Tambah Data Demografi')
@section('header_title', 'Tambah Data Demografi Kelas')

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
                <h2 class="text-base font-bold text-slate-900">Formulir Data Demografi Kelas</h2>
                <p class="text-xs sm:text-sm text-slate-500 mt-0.5">Masukkan jumlah siswa laki-laki dan perempuan per tingkat
                    kelas untuk grafik demografi.</p>
            </div>

            <form method="POST" action="{{ route('admin.ssk.demographics.store') }}" class="space-y-5">
                @csrf

                <!-- Nama Kelas -->
                <div>
                    <label for="kelas" class="block text-xs sm:text-sm font-bold text-slate-700 mb-1.5">Nama Tingkat
                        Kelas</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 text-slate-400">
                            <i class="ti ti-school text-base"></i>
                        </span>
                        <input type="text" id="kelas" name="kelas" value="{{ old('kelas') }}" required
                            placeholder="Contoh: Kelas VII, Kelas VIII, atau Kelas IX"
                            class="w-full pl-10 pr-4 py-2.5 bg-slate-50/50 border border-slate-300 rounded-xl text-sm focus:bg-white focus:ring-2 focus:ring-blue-500/20 focus:border-blue-600 outline-none transition-all">
                    </div>
                </div>

                <!-- Input Jumlah Siswa (Laki-laki & Perempuan) -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label for="male_count" class="block text-xs sm:text-sm font-bold text-slate-700 mb-1.5">Jumlah
                            Siswa Laki-laki</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 text-slate-400">
                                <i class="ti ti-user text-base"></i>
                            </span>
                            <input type="number" id="male_count" name="male_count"
                                value="{{ old('male_count', $demographic->male_count ?? '') }}" min="0"
                                placeholder="0" required
                                class="w-full pl-10 pr-4 py-2.5 bg-slate-50/50 border border-slate-300 rounded-xl text-sm focus:bg-white focus:ring-2 focus:ring-blue-500/20 focus:border-blue-600 outline-none transition-all">
                        </div>
                    </div>
                    <div>
                        <label for="female_count" class="block text-xs sm:text-sm font-bold text-slate-700 mb-1.5">Jumlah
                            Siswa Perempuan</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 text-slate-400">
                                <i class="ti ti-user text-base"></i>
                            </span>
                            <input type="number" id="female_count" name="female_count"
                                value="{{ old('female_count', $demographic->female_count ?? '') }}" min="0"
                                placeholder="0" required
                                class="w-full pl-10 pr-4 py-2.5 bg-slate-50/50 border border-slate-300 rounded-xl text-sm focus:bg-white focus:ring-2 focus:ring-blue-500/20 focus:border-blue-600 outline-none transition-all">
                        </div>
                    </div>
                </div>

                <!-- Live Preview Chart (Pratinjau Grafik Interaktif) -->
                <div class="p-4 bg-slate-50 rounded-2xl border border-slate-200 space-y-3">
                    <div class="flex items-center justify-between text-xs font-bold text-slate-700">
                        <span class="flex items-center gap-1.5">
                            <i class="ti ti-chart-bar text-blue-600 text-base"></i> Pratinjau Grafik Perbandingan
                        </span>
                        <span id="total-students" class="text-slate-500 font-semibold">Total: 0 Siswa</span>
                    </div>

                    <!-- Batang Visualisasi -->
                    <div class="space-y-2">
                        <!-- Laki-laki -->
                        <div>
                            <div class="flex justify-between text-[11px] text-slate-600 mb-1 font-medium">
                                <span class="text-blue-700 font-bold">Laki-laki (<span id="preview-male">0</span>)</span>
                                <span id="percent-male">0%</span>
                            </div>
                            <div class="w-full bg-slate-200 h-2.5 rounded-full overflow-hidden">
                                <div id="bar-male" class="bg-blue-600 h-full w-0 transition-all duration-300 rounded-full">
                                </div>
                            </div>
                        </div>

                        <!-- Perempuan -->
                        <div>
                            <div class="flex justify-between text-[11px] text-slate-600 mb-1 font-medium">
                                <span class="text-pink-600 font-bold">Perempuan (<span id="preview-female">0</span>)</span>
                                <span id="percent-female">0%</span>
                            </div>
                            <div class="w-full bg-slate-200 h-2.5 rounded-full overflow-hidden">
                                <div id="bar-female"
                                    class="bg-pink-500 h-full w-0 transition-all duration-300 rounded-full"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Urutan Tampil -->
                <div>
                    <label for="sort_order" class="block text-xs sm:text-sm font-bold text-slate-700 mb-1.5">Urutan
                        Tampil</label>
                    <input type="number" id="sort_order" name="sort_order" value="{{ old('sort_order', 0) }}"
                        class="w-full px-4 py-2.5 bg-slate-50/50 border border-slate-300 rounded-xl text-sm focus:bg-white focus:ring-2 focus:ring-blue-500/20 focus:border-blue-600 outline-none transition-all">
                    <p class="text-[11px] text-slate-400 mt-1">Semakin kecil angkanya, maka kelas akan tampil lebih dulu.
                    </p>
                </div>

                <!-- Tombol Submit -->
                <div class="pt-2">
                    <button type="submit"
                        class="w-full flex items-center justify-center gap-2 py-3 bg-blue-600 hover:bg-blue-700 text-white font-bold text-sm rounded-xl shadow-sm transition-all cursor-pointer">
                        <i class="ti ti-device-floppy text-base"></i>
                        <span>Simpan Data Demografi</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
