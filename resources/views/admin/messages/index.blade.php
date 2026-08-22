@extends('layouts.admin')

@section('title', 'Pesan Masuk')
@section('header_title', 'Pesan Masuk')

@section('content')

    <!-- Header Deskripsi & Informasi Jumlah Pesan -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
        <div>
            <h2 class="text-base font-bold text-slate-900">Kotak Masuk Pesan Pengunjung</h2>
            <p class="text-xs sm:text-sm text-slate-500 mt-0.5">Daftar aspirasi, pertanyaan, atau saran yang dikirim melalui
                formulir kontak website.</p>
        </div>

        @if ($unreadCount > 0)
            <div
                class="inline-flex items-center gap-2 px-3.5 py-2 bg-rose-50 border border-rose-200 rounded-xl text-rose-700 text-xs font-semibold shrink-0">
                <i class="ti ti-bell-ringing text-base animate-bounce"></i>
                <span>{{ $unreadCount }} Pesan Belum Dibaca</span>
            </div>
        @endif
    </div>

    <!-- Tabel Data Pesan -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-xs overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead
                    class="bg-slate-50/70 border-b border-slate-200 text-xs font-bold uppercase tracking-wider text-slate-600">
                    <tr>
                        <th class="px-6 py-4">Pengirim</th>
                        <th class="px-6 py-4">Cuplikan Pesan</th>
                        <th class="px-6 py-4">Tanggal Masuk</th>
                        <th class="px-6 py-4">Status</th>
                        <th class="px-6 py-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-sm">
                    @forelse ($messages as $message)
                        <tr
                            class="hover:bg-slate-50/60 transition-colors {{ !$message->is_read ? 'bg-blue-50/20 font-medium' : '' }}">
                            <!-- Pengirim -->
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-2.5">
                                    <div
                                        class="w-8 h-8 rounded-lg {{ $message->is_anonymous ? 'bg-slate-100 text-slate-500 border border-slate-200' : 'bg-blue-50 text-blue-600 border border-blue-200' }} flex items-center justify-center font-bold text-xs shrink-0">
                                        <i class="ti {{ $message->is_anonymous ? 'ti-user-off' : 'ti-user' }}"></i>
                                    </div>
                                    <div class="truncate">
                                        <div class="text-slate-900 font-semibold truncate">{{ $message->displayName() }}
                                        </div>
                                        @if (!$message->is_anonymous && $message->email)
                                            <div class="text-xs text-slate-400 truncate">{{ $message->email }}</div>
                                        @else
                                            <div class="text-[11px] text-slate-400 italic">Pengirim Anonim</div>
                                        @endif
                                    </div>
                                </div>
                            </td>

                            <!-- Cuplikan Pesan -->
                            <td class="px-6 py-4 text-slate-600 max-w-xs truncate">
                                {{ Str::limit($message->message, 50) }}
                            </td>

                            <!-- Tanggal -->
                            <td class="px-6 py-4 text-slate-500 text-xs whitespace-nowrap">
                                <div class="flex items-center gap-1.5">
                                    <i class="ti ti-calendar text-slate-400"></i>
                                    <span>{{ $message->created_at->translatedFormat('d M Y, H:i') }}</span>
                                </div>
                            </td>

                            <!-- Status -->
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if ($message->is_read)
                                    <span
                                        class="inline-flex items-center gap-1.5 text-xs font-semibold px-3 py-1 bg-slate-100 text-slate-600 border border-slate-200 rounded-full">
                                        <span class="w-1.5 h-1.5 rounded-full bg-slate-400"></span> Dibaca
                                    </span>
                                @else
                                    <span
                                        class="inline-flex items-center gap-1.5 text-xs font-bold px-3 py-1 bg-rose-50 border border-rose-200 text-rose-700 rounded-full">
                                        <span class="w-1.5 h-1.5 rounded-full bg-rose-600 animate-pulse"></span> Belum
                                        Dibaca
                                    </span>
                                @endif
                            </td>

                            <!-- Aksi -->
                            <td class="px-6 py-4 text-right whitespace-nowrap">
                                <div class="flex items-center justify-end gap-1.5">
                                    <a href="{{ route('admin.messages.show', $message) }}"
                                        class="inline-flex items-center gap-1 px-3 py-1.5 text-xs font-semibold text-slate-700 bg-slate-50 hover:bg-blue-50 hover:text-blue-600 border border-slate-200 hover:border-blue-200 rounded-lg transition-all">
                                        <i class="ti ti-eye text-sm" aria-hidden="true"></i> Baca
                                    </a>

                                    <!-- Tombol Hapus memicu Modal Global di Layout -->
                                    <button type="button"
                                        onclick="openDeleteModal('{{ route('admin.messages.destroy', $message) }}', 'pesan dari {{ $message->displayName() }}')"
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
                                    <i class="ti ti-inbox text-3xl text-slate-300"></i>
                                    <p class="text-sm font-medium">Belum ada pesan masuk saat ini.</p>
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
        {{ $messages->links() }}
    </div>

@endsection
