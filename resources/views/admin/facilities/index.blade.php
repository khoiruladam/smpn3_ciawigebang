@extends('layouts.admin')

@section('title', 'Kelola Fasilitas')
@section('header_title', 'Kelola Fasilitas Sekolah')

@section('content')

    <!-- Header Bagian Atas Tabel -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
        <div>
            <h2 class="text-base font-bold text-slate-900">Daftar Sarana & Prasarana</h2>
            <p class="text-xs sm:text-sm text-slate-500 mt-0.5">Kelola informasi fasilitas sekolah, gambar sampul, galeri
                foto, dan status publikasinya.</p>
        </div>
        <a href="{{ route('admin.facilities.create') }}"
            class="inline-flex items-center justify-center gap-2 px-4 py-2.5 bg-blue-600 hover:bg-blue-700 text-white text-xs sm:text-sm font-semibold rounded-xl shadow-xs transition-all shrink-0">
            <i class="ti ti-plus text-base" aria-hidden="true"></i>
            <span>Tambah Fasilitas Baru</span>
        </a>
    </div>

    <!-- Tabel Data Fasilitas -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-xs overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead
                    class="bg-slate-50/70 border-b border-slate-200 text-xs font-bold uppercase tracking-wider text-slate-600">
                    <tr>
                        <th class="px-6 py-4">Sampul</th>
                        <th class="px-6 py-4">Nama Fasilitas</th>
                        <th class="px-6 py-4">Kategori / Tag</th>
                        <th class="px-6 py-4">Galeri Foto</th>
                        <th class="px-6 py-4">Status</th>
                        <th class="px-6 py-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-sm">
                    @forelse ($facilities as $facility)
                        <tr class="hover:bg-slate-50/60 transition-colors">
                            <!-- Foto Sampul -->
                            <td class="px-6 py-4">
                                @if ($facility->cover_image || $facility->image)
                                    <img src="{{ Storage::url($facility->cover_image ?? $facility->image) }}"
                                        alt="{{ $facility->name }}"
                                        class="w-14 h-12 rounded-xl object-cover border border-slate-200 shadow-2xs">
                                @else
                                    <div
                                        class="w-14 h-12 rounded-xl bg-slate-100 border border-slate-200 flex items-center justify-center text-slate-400">
                                        <i class="ti ti-photo text-xl"></i>
                                    </div>
                                @endif
                            </td>

                            <!-- Nama Fasilitas -->
                            <td class="px-6 py-4 font-semibold text-slate-900">
                                <div class="flex items-center gap-2.5">
                                    <div
                                        class="w-8 h-8 rounded-lg bg-blue-50 text-blue-600 border border-blue-100 flex items-center justify-center shrink-0">
                                        <i class="ti {{ $facility->icon ?? 'ti-building' }} text-base"
                                            aria-hidden="true"></i>
                                    </div>
                                    <div>
                                        <span>{{ $facility->name }}</span>
                                        <span
                                            class="block text-[11px] font-normal text-slate-400 font-mono mt-0.5">/{{ $facility->slug }}</span>
                                    </div>
                                </div>
                            </td>

                            <!-- Tag / Kategori -->
                            <td class="px-6 py-4 text-slate-600">
                                @if ($facility->tag)
                                    <span
                                        class="inline-flex items-center px-2.5 py-1 bg-slate-100 border border-slate-200 text-slate-700 rounded-md text-xs font-medium">
                                        {{ $facility->tag }}
                                    </span>
                                @else
                                    <span class="text-slate-400">-</span>
                                @endif
                            </td>

                            <!-- Jumlah Galeri Foto -->
                            <td class="px-6 py-4 text-slate-600 font-medium">
                                @php
                                    $galleryCount = 0;
                                    if (is_countable($facility->images)) {
                                        $galleryCount = count($facility->images);
                                    } elseif (is_string($facility->images) && !empty($facility->images)) {
                                        $decoded = json_decode($facility->images, true);
                                        $galleryCount = is_array($decoded) ? count($decoded) : 0;
                                    }
                                @endphp
                                <span class="inline-flex items-center gap-1.5 text-xs text-slate-600">
                                    <i class="ti ti-photo-album text-base text-slate-400"></i>
                                    <span>{{ $galleryCount }} Foto</span>
                                </span>
                            </td>

                            <!-- Status Tayang -->
                            <td class="px-6 py-4">
                                @if ($facility->is_published ?? true)
                                    <span
                                        class="inline-flex items-center gap-1.5 text-xs font-bold px-3 py-1 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-full">
                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> Tayang
                                    </span>
                                @else
                                    <span
                                        class="inline-flex items-center gap-1.5 text-xs font-bold px-3 py-1 bg-slate-100 border border-slate-200 text-slate-500 rounded-full">
                                        <span class="w-1.5 h-1.5 rounded-full bg-slate-400"></span> Draft
                                    </span>
                                @endif
                            </td>

                            <!-- Tombol Aksi -->
                            <td class="px-6 py-4 text-right whitespace-nowrap">
                                <div class="flex items-center justify-end gap-1.5">
                                    <a href="{{ route('facilities.show', $facility) }}" target="_blank"
                                        class="inline-flex items-center gap-1 px-3 py-1.5 text-xs font-semibold text-slate-700 bg-slate-50 hover:bg-slate-100 border border-slate-200 rounded-lg transition-all"
                                        title="Pratinjau Halaman">
                                        <i class="ti ti-eye text-sm" aria-hidden="true"></i> Lihat
                                    </a>

                                    <a href="{{ route('admin.facilities.edit', $facility) }}"
                                        class="inline-flex items-center gap-1 px-3 py-1.5 text-xs font-semibold text-slate-700 bg-slate-50 hover:bg-blue-50 hover:text-blue-600 border border-slate-200 hover:border-blue-200 rounded-lg transition-all">
                                        <i class="ti ti-pencil text-sm" aria-hidden="true"></i> Edit
                                    </a>

                                    <button type="button"
                                        onclick="openDeleteModal('{{ route('admin.facilities.destroy', $facility) }}', 'fasilitas {{ $facility->name }}')"
                                        class="inline-flex items-center gap-1 px-3 py-1.5 text-xs font-semibold text-rose-600 bg-rose-50/50 hover:bg-rose-600 hover:text-white border border-rose-200 hover:border-rose-600 rounded-lg transition-all cursor-pointer">
                                        <i class="ti ti-trash text-sm" aria-hidden="true"></i> Hapus
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center text-slate-400">
                                <div class="flex flex-col items-center justify-center gap-2">
                                    <i class="ti ti-building-community text-3xl text-slate-300"></i>
                                    <p class="text-sm font-medium">Belum ada data fasilitas yang ditambahkan.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Paginasi -->
    <div class="mt-6">
        {{ $facilities->links() }}
    </div>

@endsection
