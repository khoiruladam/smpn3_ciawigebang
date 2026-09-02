@extends('layouts.admin')

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-8">

        <!-- Welcome Header -->
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h1 class="font-bold text-3xl text-slate-900">Dashboard Admin</h1>
                <p class="text-slate-500">Selamat datang kembali! Ini ringkasan aktivitas hari ini.</p>
            </div>
            <div class="text-right">
                <p class="text-xs font-bold text-slate-400 uppercase">Tanggal</p>
                <p class="text-sm font-semibold text-slate-700">{{ date('d F Y') }}</p>
            </div>
        </div>

        <!-- Statistik Utama -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            @php
                $cards = [
                    [
                        'title' => 'Total Berita',
                        'value' => $stats['total_berita'],
                        'icon' => 'ti-news',
                        'color' => 'blue',
                    ],
                    [
                        'title' => 'Data Guru',
                        'value' => $stats['total_guru'],
                        'icon' => 'ti-users',
                        'color' => 'emerald',
                    ],
                    [
                        'title' => 'Prestasi',
                        'value' => $stats['total_prestasi'],
                        'icon' => 'ti-award',
                        'color' => 'amber',
                    ],
                    [
                        'title' => 'Pesan Masuk',
                        'value' => $stats['total_pesan'],
                        'icon' => 'ti-mail',
                        'color' => 'rose',
                    ],
                ];
            @endphp

            @foreach ($cards as $card)
                <div
                    class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm flex items-center gap-4 hover:shadow-md transition-shadow">
                    <div
                        class="w-14 h-14 bg-{{ $card['color'] }}-100 text-{{ $card['color'] }}-600 rounded-2xl flex items-center justify-center text-2xl">
                        <i class="ti {{ $card['icon'] }}"></i>
                    </div>
                    <div>
                        <p class="text-slate-500 text-xs font-bold uppercase tracking-wider">{{ $card['title'] }}</p>
                        <h3 class="text-2xl font-black text-slate-900">{{ $card['value'] }}</h3>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Main Content Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

            <!-- Tabel Berita Terbaru -->
            <div class="lg:col-span-2 bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
                <div class="p-6 border-b border-slate-100 flex items-center justify-between">
                    <h3 class="font-bold text-slate-900 flex items-center gap-2"><i class="ti ti-news text-blue-600"></i>
                        Berita Terbaru</h3>
                    <a href="#" class="text-xs font-bold text-blue-600 hover:underline">Lihat Semua</a>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm">
                        <thead class="bg-slate-50 text-slate-500 text-xs uppercase">
                            <tr>
                                <th class="px-6 py-4">Judul</th>
                                <th class="px-6 py-4">Tanggal</th>
                                <th class="px-6 py-4">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @forelse($latestPosts as $post)
                                <tr>
                                    <td class="px-6 py-4 font-medium text-slate-900">{{ Str::limit($post->title, 40) }}</td>
                                    <td class="px-6 py-4 text-slate-500">{{ $post->created_at->format('d M Y') }}</td>
                                    <td class="px-6 py-4"><span
                                            class="px-2 py-1 bg-green-50 text-green-700 text-[10px] font-bold rounded-lg uppercase">Publish</span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="px-6 py-4 text-center text-slate-400">Belum ada berita.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Pesan Masuk & Sidebar -->
            <div class="lg:col-span-1 space-y-6">
                <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm">
                    <h3 class="font-bold text-slate-900 mb-4 flex items-center gap-2">
                        <i class="ti ti-mail text-rose-600"></i> Pesan Terbaru
                    </h3>
                    <div class="space-y-4">
                        @forelse($latestMessages as $msg)
                            <div class="p-3 bg-slate-50 rounded-xl border border-slate-100">
                                <p class="text-xs font-bold text-slate-900">{{ $msg->name ?? 'Pengunjung' }}</p>
                                <p class="text-[11px] text-slate-500 mt-0.5 truncate">{{ $msg->message ?? '-' }}</p>
                            </div>
                        @empty
                            <p class="text-xs text-slate-400 text-center py-4">Tidak ada pesan baru.</p>
                        @endforelse
                    </div>
                </div>

                <!-- Quick Access -->
                @if (auth()->user()->role === 'admin')
                    <div class="bg-blue-600 p-6 rounded-2xl shadow-lg text-white">
                        <h3 class="font-bold text-white mb-2 flex items-center gap-2">
                            <i class="ti ti-settings"></i> Shortcut Admin
                        </h3>
                        <p class="text-blue-100 text-xs mb-4">Akses cepat ke pengaturan sistem.</p>
                        <a href="{{ route('admin.settings.index') }}"
                            class="block w-full text-center py-2 bg-white/10 hover:bg-white/20 rounded-xl text-xs font-bold transition-all">
                            Buka Pengaturan
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
