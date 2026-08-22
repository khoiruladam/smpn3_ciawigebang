@extends('layouts.admin')

@section('title', 'Kelola SSK')
@section('header_title', 'Sekolah Siaga Kependudukan (SSK)')

@section('content')

    <!-- SEKSI 1: KARTU STATISTIK -->
    <div class="space-y-4 mb-10">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h2 class="text-base font-bold text-slate-900">Kartu Statistik SSK</h2>
                <p class="text-xs sm:text-sm text-slate-500 mt-0.5">Kelola ringkasan angka statistik yang tampil di bagian
                    atas halaman utama.</p>
            </div>
            <a href="{{ route('admin.ssk.stats.create') }}"
                class="inline-flex items-center justify-center gap-2 px-4 py-2.5 bg-blue-600 hover:bg-blue-700 text-white text-xs sm:text-sm font-semibold rounded-xl shadow-xs transition-all shrink-0">
                <i class="ti ti-plus text-base" aria-hidden="true"></i>
                <span>Tambah Kartu Statistik</span>
            </a>
        </div>

        <div class="bg-white rounded-2xl border border-slate-200 shadow-xs overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead
                        class="bg-slate-50/70 border-b border-slate-200 text-xs font-bold uppercase tracking-wider text-slate-600">
                        <tr>
                            <th class="px-6 py-4">Label Statistik</th>
                            <th class="px-6 py-4">Nilai</th>
                            <th class="px-6 py-4">Keterangan</th>
                            <th class="px-6 py-4">Urutan</th>
                            <th class="px-6 py-4 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-sm">
                        @forelse ($stats as $stat)
                            <tr class="hover:bg-slate-50/60 transition-colors">
                                <td class="px-6 py-4 font-semibold text-slate-900">
                                    <div class="flex items-center gap-2.5">
                                        <div
                                            class="w-8 h-8 rounded-lg bg-blue-50 text-blue-600 border border-blue-200 flex items-center justify-center shrink-0">
                                            <i class="ti {{ $stat->icon }} text-base" aria-hidden="true"></i>
                                        </div>
                                        <span>{{ $stat->label }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 font-bold text-slate-700">
                                    {{ $stat->value }}{{ $stat->suffix }}
                                </td>
                                <td class="px-6 py-4 text-slate-500 text-xs">
                                    {{ $stat->sub ?? '-' }}
                                </td>
                                <td class="px-6 py-4 text-slate-500 text-xs font-medium">
                                    <span
                                        class="px-2 py-1 bg-slate-100 rounded-md border border-slate-200">{{ $stat->sort_order }}</span>
                                </td>
                                <td class="px-6 py-4 text-right whitespace-nowrap">
                                    <div class="flex items-center justify-end gap-1.5">
                                        <a href="{{ route('admin.ssk.stats.edit', $stat) }}"
                                            class="inline-flex items-center gap-1 px-3 py-1.5 text-xs font-semibold text-slate-700 bg-slate-50 hover:bg-blue-50 hover:text-blue-600 border border-slate-200 hover:border-blue-200 rounded-lg transition-all">
                                            <i class="ti ti-pencil text-sm" aria-hidden="true"></i> Edit
                                        </a>
                                        <button type="button"
                                            onclick="openDeleteModal('{{ route('admin.ssk.stats.destroy', $stat) }}', 'kartu statistik {{ $stat->label }}')"
                                            class="inline-flex items-center gap-1 px-3 py-1.5 text-xs font-semibold text-rose-600 bg-rose-50/50 hover:bg-rose-600 hover:text-white border border-rose-200 hover:border-rose-600 rounded-lg transition-all cursor-pointer">
                                            <i class="ti ti-trash text-sm" aria-hidden="true"></i> Hapus
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-12 text-center text-slate-400">
                                    <div class="flex flex-col items-center justify-center gap-2">
                                        <i class="ti ti-chart-bar-off text-3xl text-slate-300"></i>
                                        <p class="text-sm font-medium">Belum ada kartu statistik yang ditambahkan.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- SEKSI 2: DATA DEMOGRAFI (GRAFIK) -->
    <div class="space-y-4">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h2 class="text-base font-bold text-slate-900">Data Demografi per Kelas</h2>
                <p class="text-xs sm:text-sm text-slate-500 mt-0.5">Kelola jumlah siswa laki-laki dan perempuan untuk
                    visualisasi grafik.</p>
            </div>
            <a href="{{ route('admin.ssk.demographics.create') }}"
                class="inline-flex items-center justify-center gap-2 px-4 py-2.5 bg-blue-600 hover:bg-blue-700 text-white text-xs sm:text-sm font-semibold rounded-xl shadow-xs transition-all shrink-0">
                <i class="ti ti-plus text-base" aria-hidden="true"></i>
                <span>Tambah Data Kelas</span>
            </a>
        </div>

        <div class="bg-white rounded-2xl border border-slate-200 shadow-xs overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead
                        class="bg-slate-50/70 border-b border-slate-200 text-xs font-bold uppercase tracking-wider text-slate-600">
                        <tr>
                            <th class="px-6 py-4">Tingkat Kelas</th>
                            <th class="px-6 py-4">Jumlah Laki-laki</th>
                            <th class="px-6 py-4">Jumlah Perempuan</th>
                            <th class="px-6 py-4">Urutan</th>
                            <th class="px-6 py-4 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-sm">
                        @forelse ($demographics as $d)
                            <tr class="hover:bg-slate-50/60 transition-colors">
                                <td class="px-6 py-4 font-semibold text-slate-900">
                                    <div class="flex items-center gap-2.5">
                                        <div
                                            class="w-8 h-8 rounded-lg bg-indigo-50 text-indigo-600 border border-indigo-200 flex items-center justify-center shrink-0">
                                            <i class="ti ti-school text-base" aria-hidden="true"></i>
                                        </div>
                                        <span>{{ $d->kelas }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-slate-700 font-medium">
                                    <span
                                        class="inline-flex items-center gap-1.5 px-2.5 py-1 bg-blue-50 text-blue-700 rounded-lg text-xs font-bold border border-blue-100">
                                        <i class="ti ti-user"></i> {{ $d->male_count }} Siswa
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-slate-700 font-medium">
                                    <span
                                        class="inline-flex items-center gap-1.5 px-2.5 py-1 bg-pink-50 text-pink-700 rounded-lg text-xs font-bold border border-pink-100">
                                        <i class="ti ti-user"></i> {{ $d->female_count }} Siswi
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-slate-500 text-xs font-medium">
                                    <span
                                        class="px-2 py-1 bg-slate-100 rounded-md border border-slate-200">{{ $d->sort_order }}</span>
                                </td>
                                <td class="px-6 py-4 text-right whitespace-nowrap">
                                    <div class="flex items-center justify-end gap-1.5">
                                        <a href="{{ route('admin.ssk.demographics.edit', $d) }}"
                                            class="inline-flex items-center gap-1 px-3 py-1.5 text-xs font-semibold text-slate-700 bg-slate-50 hover:bg-blue-50 hover:text-blue-600 border border-slate-200 hover:border-blue-200 rounded-lg transition-all">
                                            <i class="ti ti-pencil text-sm" aria-hidden="true"></i> Edit
                                        </a>
                                        <button type="button"
                                            onclick="openDeleteModal('{{ route('admin.ssk.demographics.destroy', $d) }}', 'data kelas {{ $d->kelas }}')"
                                            class="inline-flex items-center gap-1 px-3 py-1.5 text-xs font-semibold text-rose-600 bg-rose-50/50 hover:bg-rose-600 hover:text-white border border-rose-200 hover:border-rose-600 rounded-lg transition-all cursor-pointer">
                                            <i class="ti ti-trash text-sm" aria-hidden="true"></i> Hapus
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-12 text-center text-slate-400">
                                    <div class="flex flex-col items-center justify-center gap-2">
                                        <i class="ti ti-users text-3xl text-slate-300"></i>
                                        <p class="text-sm font-medium">Belum ada data demografi kelas yang terdaftar.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

@endsection
