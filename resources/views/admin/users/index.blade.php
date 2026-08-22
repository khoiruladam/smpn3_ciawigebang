@extends('layouts.admin')

@section('title', 'Kelola Pengguna')
@section('header_title', 'Kelola Pengguna')

@section('content')

    <!-- Header Bagian Atas Tabel -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
        <div>
            <h2 class="text-base font-bold text-slate-900">Daftar Pengguna Sistem</h2>
            <p class="text-xs sm:text-sm text-slate-500 mt-0.5">Kelola akun administrator dan operator yang memiliki hak
                akses ke panel ini.</p>
        </div>
        <a href="{{ route('admin.users.create') }}"
            class="inline-flex items-center justify-center gap-2 px-4 py-2.5 bg-blue-600 hover:bg-blue-700 text-white text-xs sm:text-sm font-semibold rounded-xl shadow-xs transition-all shrink-0">
            <i class="ti ti-user-plus text-base" aria-hidden="true"></i>
            <span>Tambah Operator Baru</span>
        </a>
    </div>

    <!-- Tabel Data Pengguna -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-xs overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead
                    class="bg-slate-50/70 border-b border-slate-200 text-xs font-bold uppercase tracking-wider text-slate-600">
                    <tr>
                        <th class="px-6 py-4">Nama Lengkap</th>
                        <th class="px-6 py-4">Alamat Email</th>
                        <th class="px-6 py-4">Role Akses</th>
                        <th class="px-6 py-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-sm">
                    @forelse ($users as $user)
                        <tr class="hover:bg-slate-50/60 transition-colors">
                            <td class="px-6 py-4 font-semibold text-slate-900">
                                <div class="flex items-center gap-2.5">
                                    <div
                                        class="w-8 h-8 rounded-lg bg-slate-100 text-slate-600 flex items-center justify-center font-bold text-xs uppercase shrink-0 border border-slate-200">
                                        {{ substr($user->name, 0, 1) }}
                                    </div>
                                    <div>
                                        <span>{{ $user->name }}</span>
                                        @if ($user->id === auth()->id())
                                            <span
                                                class="ml-1.5 text-[10px] font-bold px-2 py-0.5 bg-slate-100 text-slate-600 border border-slate-200 rounded-md">Akun
                                                Anda</span>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-slate-600 font-medium">
                                {{ $user->email }}
                            </td>
                            <td class="px-6 py-4">
                                @if ($user->role === 'admin')
                                    <span
                                        class="inline-flex items-center gap-1.5 text-xs font-bold px-3 py-1 bg-blue-50 border border-blue-200 text-blue-700 rounded-full">
                                        <span class="w-1.5 h-1.5 rounded-full bg-blue-600"></span> Admin
                                    </span>
                                @else
                                    <span
                                        class="inline-flex items-center gap-1.5 text-xs font-bold px-3 py-1 bg-amber-50 border border-amber-200 text-amber-700 rounded-full">
                                        <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span> Operator
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex items-center justify-end gap-1.5">
                                    <a href="{{ route('admin.users.edit', $user) }}"
                                        class="inline-flex items-center gap-1 px-3 py-1.5 text-xs font-semibold text-slate-700 bg-slate-50 hover:bg-blue-50 hover:text-blue-600 border border-slate-200 hover:border-blue-200 rounded-lg transition-all">
                                        <i class="ti ti-pencil text-sm" aria-hidden="true"></i> Edit
                                    </a>

                                    @if ($user->role !== 'admin' && $user->id !== auth()->id())
                                        <!-- Tombol Hapus memicu Modal Global di Layout -->
                                        <button type="button"
                                            onclick="openDeleteModal('{{ route('admin.users.destroy', $user) }}', 'pengguna {{ $user->name }}')"
                                            class="inline-flex items-center gap-1 px-3 py-1.5 text-xs font-semibold text-rose-600 bg-rose-50/50 hover:bg-rose-600 hover:text-white border border-rose-200 hover:border-rose-600 rounded-lg transition-all cursor-pointer">
                                            <i class="ti ti-trash text-sm" aria-hidden="true"></i> Hapus
                                        </button>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-12 text-center text-slate-400">
                                <div class="flex flex-col items-center justify-center gap-2">
                                    <i class="ti ti-folder-open text-3xl text-slate-300"></i>
                                    <p class="text-sm font-medium">Belum ada data pengguna yang terdaftar.</p>
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
        {{ $users->links() }}
    </div>

@endsection
