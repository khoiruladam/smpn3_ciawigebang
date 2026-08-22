@extends('layouts.admin')

@section('title', 'Manajemen Guru & Staff')
@section('header_title', 'Daftar Guru & Staff')

@section('content')
    <div class="flex justify-between items-center mb-6">
        <a href="{{ route('admin.guru.create') }}"
            class="inline-flex items-center gap-2 px-4 py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-bold text-sm rounded-xl shadow-sm transition-all">
            <i class="ti ti-plus text-base"></i> Tambah Guru / Staff
        </a>
    </div>

    <div class="bg-white rounded-2xl border border-slate-200 overflow-hidden shadow-xs">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-slate-50 border-b border-slate-200 text-slate-600 text-xs uppercase font-bold">
                    <th class="py-3.5 px-4">Foto</th>
                    <th class="py-3.5 px-4">Nama & Sub</th>
                    <th class="py-3.5 px-4">Jabatan</th>
                    <th class="py-3.5 px-4">Kategori</th>
                    <th class="py-3.5 px-4 text-center">Status</th>
                    <th class="py-3.5 px-4 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100 text-sm">
                @forelse($gurus as $g)
                    <tr class="hover:bg-slate-50/50 transition-colors">
                        <td class="py-3 px-4">
                            <img src="{{ $g->image ? Storage::url($g->image) : 'https://via.placeholder.com/150' }}"
                                class="w-10 h-10 rounded-full object-cover border border-slate-200">
                        </td>
                        <td class="py-3 px-4">
                            <div class="font-bold text-slate-900">{{ $g->name }}</div>
                            <div class="text-xs text-slate-500">{{ $g->sub ?? '-' }}</div>
                        </td>
                        <td class="py-3 px-4 text-slate-700 font-medium">{{ $g->jabatan }}</td>
                        <td class="py-3 px-4">
                            <span class="px-2.5 py-1 text-xs font-bold rounded-lg uppercase bg-slate-100 text-slate-700">
                                {{ $g->category }}
                            </span>
                        </td>
                        <td class="py-3 px-4 text-center">
                            <span
                                class="px-2.5 py-1 text-xs font-bold rounded-full {{ $g->is_published ? 'bg-emerald-50 text-emerald-600 border border-emerald-200' : 'bg-slate-100 text-slate-500' }}">
                                {{ $g->is_published ? 'Aktif' : 'Draft' }}
                            </span>
                        </td>
                        <td class="py-3 px-4 text-right space-x-2">
                            <a href="{{ route('admin.guru.edit', $g) }}"
                                class="inline-flex items-center justify-center w-8 h-8 bg-blue-50 text-blue-600 rounded-lg hover:bg-blue-100">
                                <i class="ti ti-edit text-sm"></i>
                            </a>
                            <form action="{{ route('admin.guru.destroy', $g) }}" method="POST" class="inline-block"
                                onsubmit="return confirm('Yakin ingin menghapus data ini?')">
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
                        <td colspan="6" class="text-center py-8 text-slate-400 text-sm">Belum ada data guru/staff.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        <div class="p-4 border-t border-slate-100">
            {{ $gurus->links() }}
        </div>
    </div>
@endsection
