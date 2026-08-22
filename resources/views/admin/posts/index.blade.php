@extends('layouts.admin')

@section('title', 'Manajemen Berita')
@section('header_title', 'Daftar Berita & Artikel Sekolah')

@section('content')
    <div class="flex justify-between items-center mb-6">
        <a href="{{ route('admin.posts.create') }}"
            class="inline-flex items-center gap-2 px-4 py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-bold text-sm rounded-xl shadow-sm transition-all">
            <i class="ti ti-plus text-base"></i> Tulis Berita Baru
        </a>
    </div>

    <div class="bg-white rounded-2xl border border-slate-200 overflow-hidden shadow-xs">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-slate-50 border-b border-slate-200 text-slate-600 text-xs uppercase font-bold">
                    <th class="py-3.5 px-4">Cover</th>
                    <th class="py-3.5 px-4">Judul & Ringkasan</th>
                    <th class="py-3.5 px-4">Kategori</th>
                    <th class="py-3.5 px-4 text-center">Status</th>
                    <th class="py-3.5 px-4 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100 text-sm">
                @forelse($posts as $item)
                    <tr class="hover:bg-slate-50/50 transition-colors">
                        <td class="py-3 px-4">
                            @if ($item->image)
                                <img src="{{ Storage::url($item->image) }}"
                                    class="w-16 h-12 rounded-lg object-cover border border-slate-200">
                            @else
                                <div
                                    class="w-16 h-12 rounded-lg bg-slate-100 flex items-center justify-center text-slate-400 text-xs">
                                    No Cover</div>
                            @endif
                        </td>
                        <td class="py-3 px-4 max-w-md">
                            <div class="font-bold text-slate-900 line-clamp-1">{{ $item->title }}</div>
                            <div class="text-xs text-slate-500 line-clamp-1">{{ $item->excerpt }}</div>
                        </td>
                        <td class="py-3 px-4">
                            <span class="px-2.5 py-1 text-xs font-bold rounded-lg bg-slate-100 text-slate-700 uppercase">
                                {{ $item->category }}
                            </span>
                        </td>
                        <td class="py-3 px-4 text-center">
                            <span
                                class="px-2.5 py-1 text-xs font-bold rounded-full {{ $item->is_published ? 'bg-emerald-50 text-emerald-600 border border-emerald-200' : 'bg-slate-100 text-slate-500' }}">
                                {{ $item->is_published ? 'Publikasi' : 'Draft' }}
                            </span>
                        </td>
                        <td class="py-3 px-4 text-right space-x-2">
                            <a href="{{ route('admin.posts.edit', $item) }}"
                                class="inline-flex items-center justify-center w-8 h-8 bg-blue-50 text-blue-600 rounded-lg hover:bg-blue-100">
                                <i class="ti ti-edit text-sm"></i>
                            </a>
                            <form action="{{ route('admin.posts.destroy', $item) }}" method="POST" class="inline-block"
                                onsubmit="return confirm('Yakin ingin menghapus berita ini?')">
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
                        <td colspan="5" class="text-center py-8 text-slate-400 text-sm">Belum ada berita atau artikel.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        <div class="p-4 border-t border-slate-100">
            {{ $posts->links() }}
        </div>
    </div>
@endsection
