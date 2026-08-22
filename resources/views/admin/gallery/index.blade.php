@extends('layouts.admin')

@section('title', 'Manajemen Galeri')
@section('header_title', 'Daftar Dokumentasi Galeri')

@section('content')
    <div class="flex justify-between items-center mb-6">
        <a href="{{ route('admin.gallery.create') }}"
            class="inline-flex items-center gap-2 px-4 py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-bold text-sm rounded-xl shadow-sm transition-all">
            <i class="ti ti-plus text-base"></i> Tambah Foto Galeri
        </a>
    </div>

    <div class="bg-white rounded-2xl border border-slate-200 overflow-hidden shadow-xs">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-slate-50 border-b border-slate-200 text-slate-600 text-xs uppercase font-bold">
                    <th class="py-3.5 px-4">Foto</th>
                    <th class="py-3.5 px-4">Keterangan / Caption</th>
                    <th class="py-3.5 px-4">Kategori</th>
                    <th class="py-3.5 px-4 text-center">Momen Utama</th>
                    <th class="py-3.5 px-4 text-center">Status</th>
                    <th class="py-3.5 px-4 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100 text-sm">
                @forelse($galleries as $item)
                    <tr class="hover:bg-slate-50/50 transition-colors">
                        <td class="py-3 px-4">
                            <img src="{{ Storage::url($item->image) }}"
                                class="w-16 h-12 rounded-lg object-cover border border-slate-200">
                        </td>
                        <td class="py-3 px-4">
                            <div class="font-bold text-slate-900 line-clamp-1">{{ $item->title }}</div>
                            <div class="text-xs text-slate-500 line-clamp-1">{{ $item->caption }}</div>
                        </td>
                        <td class="py-3 px-4">
                            <span class="px-2.5 py-1 text-xs font-bold rounded-lg uppercase bg-slate-100 text-slate-700">
                                {{ $item->category }}
                            </span>
                        </td>
                        <td class="py-3 px-4 text-center">
                            @if ($item->is_featured)
                                <span
                                    class="px-2 py-0.5 text-[10px] font-bold bg-amber-100 text-amber-700 rounded-md">Ya</span>
                            @else
                                <span class="text-xs text-slate-400">-</span>
                            @endif
                        </td>
                        <td class="py-3 px-4 text-center">
                            <span
                                class="px-2.5 py-1 text-xs font-bold rounded-full {{ $item->is_published ? 'bg-emerald-50 text-emerald-600 border border-emerald-200' : 'bg-slate-100 text-slate-500' }}">
                                {{ $item->is_published ? 'Aktif' : 'Draft' }}
                            </span>
                        </td>
                        <td class="py-3 px-4 text-right space-x-2">
                            <a href="{{ route('admin.gallery.edit', $item) }}"
                                class="inline-flex items-center justify-center w-8 h-8 bg-blue-50 text-blue-600 rounded-lg hover:bg-blue-100">
                                <i class="ti ti-edit text-sm"></i>
                            </a>
                            <form action="{{ route('admin.gallery.destroy', $item) }}" method="POST" class="inline-block"
                                onsubmit="return confirm('Yakin ingin menghapus foto ini?')">
                                @csrf @method('DELETE')
                                <button type="submit"
                                    class="inline-flex items-center justify-center w-8 h-8 bg-rose-50 text-rose-600 rounded-lg hover:bg-rose-100 cursor-pointer">
                                    <i class="ti ti-trash text-sm"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center py-8 text-slate-400 text-sm">Belum ada dokumentasi galeri.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        <div class="p-4 border-t border-slate-100">
            {{ $galleries->links() }}
        </div>
    </div>
@endsection
