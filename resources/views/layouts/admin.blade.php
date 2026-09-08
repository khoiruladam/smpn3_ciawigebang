{{-- resources/views/layouts/admin.blade.php --}}
<!DOCTYPE html>
<html lang="id" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="robots" content="noindex, nofollow">
    <meta name="description" content="Panel Administrasi Internal — {{ config('app.name', 'Sistem Sekolah') }}">
    <title>@yield('title', 'Dashboard Admin') — {{ config('app.name', 'SMPN 3 Ciawigebang') }}</title>

    <!-- Google Fonts & Tabler Icons -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=DM+Sans:opsz,wght@9..40,300;9..40,400;9..40,500;9..40,600;9..40,700&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/dist/tabler-icons.min.css">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- SortableJS CDN untuk drag-and-drop urutan tampil --}}
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.6/Sortable.min.js" defer></script>
    {{-- Kompresi gambar otomatis di sisi client --}}
    <script src="{{ asset('js/image-compressor.js') }}" defer></script>

    @stack('styles')
</head>

<body
    class="bg-slate-100 text-slate-800 font-sans antialiased min-h-screen flex flex-col selection:bg-blue-600 selection:text-white">

    @php
        // Mengecek role secara dinamis dari database user yang sedang login
        $isAdmin = auth()->check() && auth()->user()->role === 'admin';
    @endphp

    <div class="min-h-screen flex flex-col lg:flex-row relative">

        <!-- Backdrop Overlay untuk Mobile Sidebar -->
        <div id="sidebar-overlay"
            class="fixed inset-0 bg-slate-950/60 z-40 hidden lg:hidden transition-opacity duration-300"></div>

        <!-- Sidebar Navigasi Kiri -->
        <aside id="admin-sidebar"
            class="fixed inset-y-0 left-0 z-50 w-64 bg-slate-900 text-slate-300 flex flex-col justify-between shrink-0 border-r border-slate-800 shadow-2xl lg:shadow-sm transform -translate-x-full lg:translate-x-0 transition-transform duration-300 ease-in-out">
            <div>
                <!-- Brand / Logo Sekolah di Sidebar -->
                <div class="h-20 px-6 flex items-center justify-between border-b border-slate-800/80 bg-slate-950/40">
                    <div class="flex items-center gap-3.5">
                        <div
                            class="w-10 h-10 rounded-xl bg-blue-600 text-white flex items-center justify-center font-bold text-lg shadow-md">
                            <i class="ti ti-school"></i>
                        </div>
                        <div class="flex flex-col">
                            <span class="font-bold text-white text-sm tracking-tight">SMPN 3 Ciawigebang</span>
                            <span class="text-[11px] text-blue-400 font-semibold tracking-wider uppercase">
                                Panel {{ $isAdmin ? 'Admin' : 'Operator' }}
                            </span>
                        </div>
                    </div>
                    <!-- Tombol Tutup Sidebar Khusus HP -->
                    <button id="sidebar-close-btn" class="lg:hidden text-slate-400 hover:text-white p-1 rounded-lg">
                        <i class="ti ti-x text-xl"></i>
                    </button>
                </div>

                <!-- Menu Navigasi -->
                <nav class="p-4 space-y-1.5 text-sm font-medium overflow-y-auto max-h-[calc(100vh-160px)]">

                    <a href="{{ route('admin.dashboard') }}"
                        class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl transition-all {{ request()->routeIs('admin.dashboard') ? 'bg-blue-600 text-white shadow-md font-semibold' : 'hover:bg-slate-800 hover:text-white text-slate-300' }}">
                        <i class="ti ti-dashboard text-lg"></i>
                        <span>Dashboard Utama</span>
                    </a>

                    <div class="pt-5 pb-1 px-3.5 text-[10px] font-bold uppercase tracking-wider text-slate-400">
                        Kelola Konten
                    </div>

                    <a href="{{ route('admin.posts.index') }}"
                        class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl hover:bg-slate-800 hover:text-white text-slate-300 transition-all">
                        <i class="ti ti-news text-lg"></i>
                        <span>Berita &amp; Pengumuman</span>
                    </a>

                    <a href="{{ route('admin.gallery.index') }}"
                        class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl hover:bg-slate-800 hover:text-white text-slate-300 transition-all">
                        <i class="ti ti-photo text-lg"></i>
                        <span>Galeri Foto</span>
                    </a>

                    <a href="{{ route('admin.guru.index') }}"
                        class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl hover:bg-slate-800 hover:text-white text-slate-300 transition-all">
                        <i class="ti ti-users-group text-lg"></i>
                        <span>Data Guru &amp; Staff</span>
                    </a>

                    <a href="{{ route('admin.prestasi.index') }}"
                        class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl hover:bg-slate-800 hover:text-white text-slate-300 transition-all">
                        <i class="ti ti-trophy text-lg"></i>
                        <span>Prestasi</span>
                    </a>

                    <a href="{{ route('admin.ekskul.index') }}"
                        class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl hover:bg-slate-800 hover:text-white text-slate-300 transition-all">
                        <i class="ti ti-ball-basketball text-lg"></i>
                        <span>Ekstrakurikuler</span>
                    </a>

                    <a href="{{ route('admin.facilities.index') }}"
                        class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl hover:bg-slate-800 hover:text-white text-slate-300 transition-all">
                        <i class="ti ti-building text-lg"></i>
                        <span>Fasilitas</span>
                    </a>

                    <div class="pt-5 pb-1 px-3.5 text-[10px] font-bold uppercase tracking-wider text-slate-400">
                        Administrasi
                    </div>

                    <!-- Data SSK (Bisa diakses Admin & Operator) -->
                    <a href="{{ route('admin.ssk.index') }}"
                        class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl {{ request()->routeIs('admin.ssk.*') ? 'bg-blue-600 text-white shadow-md font-semibold' : 'hover:bg-slate-800 hover:text-white text-slate-300' }} transition-all">
                        <i class="ti ti-file-text text-lg"></i>
                        <span>Data SSK</span>
                    </a>

                    <!-- Pesan Masuk (Bisa diakses Admin & Operator) -->
                    <a href="{{ route('admin.messages.index') }}"
                        class="flex items-center justify-between gap-3 px-3.5 py-2.5 rounded-xl {{ request()->routeIs('admin.messages.*') ? 'bg-blue-600 text-white shadow-md font-semibold' : 'hover:bg-slate-800 hover:text-white text-slate-300' }} transition-all">
                        <span class="flex items-center gap-3">
                            <i class="ti ti-mail text-lg"></i>
                            <span>Pesan Masuk</span>
                        </span>

                        <!-- Badge Angka Real-time -->
                        @if (isset($unreadMessagesCount) && $unreadMessagesCount > 0)
                            <span
                                class="text-[10px] font-bold bg-rose-500 text-white rounded-full px-2 py-0.5 animate-pulse">
                                {{ $unreadMessagesCount }}
                            </span>
                        @endif
                    </a>

                    <!-- HANYA ADMIN YANG BISA MELIHAT MENU DI BAWAH INI -->
                    @if ($isAdmin)
                        <a href="{{ route('admin.settings.index') }}"
                            class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl {{ request()->routeIs('admin.settings.*') ? 'bg-blue-600 text-white shadow-md font-semibold' : 'hover:bg-slate-800 hover:text-white text-slate-300' }} transition-all">
                            <i class="ti ti-settings text-lg"></i>
                            <span>Pengaturan Sekolah</span>
                        </a>

                        <a href="{{ route('admin.users.index') }}"
                            class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl {{ request()->routeIs('admin.users.*') ? 'bg-blue-600 text-white shadow-md font-semibold' : 'hover:bg-slate-800 hover:text-white text-slate-300' }} transition-all">
                            <i class="ti ti-users text-lg"></i>
                            <span>Kelola Pengguna</span>
                        </a>
                    @endif

                    <div class="pt-5 pb-1 px-3.5 text-[10px] font-bold uppercase tracking-wider text-slate-400">
                        Lainnya
                    </div>

                    <a href="{{ route('home') }}" target="_blank"
                        class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl hover:bg-slate-800 hover:text-white text-slate-300 transition-all">
                        <i class="ti ti-world text-lg"></i>
                        <span>Lihat Website Utama</span>
                    </a>
                </nav>
            </div>

            <!-- Profil Singkat / Tombol Keluar -->
            <div class="p-4 border-t border-slate-800 bg-slate-950/20">
                <div
                    class="flex items-center justify-between gap-3 p-3 rounded-xl bg-slate-800/80 border border-slate-700/60 mb-3 shadow-inner">
                    <div class="flex items-center gap-2.5 overflow-hidden">
                        <div
                            class="w-9 h-9 rounded-lg {{ $isAdmin ? 'bg-blue-600/30 text-blue-400' : 'bg-amber-500/30 text-amber-400' }} flex items-center justify-center font-bold text-sm shrink-0">
                            <i class="ti ti-user"></i>
                        </div>
                        <div class="flex flex-col truncate">
                            <span
                                class="text-xs font-bold text-white truncate">{{ auth()->user()->name ?? ($isAdmin ? 'Administrator' : 'Bpk/Ibu Guru') }}</span>
                            <span
                                class="text-[11px] text-slate-400 truncate">{{ auth()->user()->email ?? 'user@school.sch.id' }}</span>
                        </div>
                    </div>
                </div>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                        class="w-full flex items-center justify-center gap-2 px-3.5 py-2.5 rounded-xl bg-rose-500/10 hover:bg-rose-600 text-rose-400 hover:text-white text-xs font-semibold border border-rose-500/20 transition-all cursor-pointer shadow-sm">
                        <i class="ti ti-logout text-base"></i>
                        <span>Keluar Sistem</span>
                    </button>
                </form>
            </div>
        </aside>

        <!-- Konten Utama Kanan -->
        <div class="flex-1 flex flex-col min-w-0 lg:ml-64">

            <!-- Header Navigasi Atas -->
            <header
                class="h-20 bg-white border-b border-slate-200 px-4 sm:px-8 flex items-center justify-between shrink-0 sticky top-0 z-30 shadow-xs">
                <div class="flex items-center gap-3">
                    <button id="sidebar-toggle-btn"
                        class="lg:hidden text-slate-700 hover:text-blue-600 p-2 rounded-xl bg-slate-50 border border-slate-200 transition-colors">
                        <i class="ti ti-menu-2 text-xl"></i>
                    </button>

                    <h1 class="font-serif text-base sm:text-xl font-bold text-slate-900 truncate">
                        @yield('header_title', 'Dashboard Panel')
                    </h1>
                </div>

                <div class="flex items-center gap-3 sm:gap-5">
                    <div
                        class="hidden sm:flex items-center gap-2 text-xs font-medium text-slate-500 bg-slate-50 border border-slate-200 px-3.5 py-2 rounded-xl">
                        <i class="ti ti-calendar-event text-blue-600 text-base"></i>
                        <span id="live-clock">-</span>
                    </div>

                    <span
                        class="text-xs font-bold px-3 py-1 sm:px-3.5 sm:py-1.5 {{ $isAdmin ? 'bg-blue-50 border-blue-200 text-blue-700' : 'bg-amber-50 border-amber-200 text-amber-700' }} border rounded-xl shadow-2xs whitespace-nowrap">
                        {{ $isAdmin ? 'Admin' : 'Operator' }}
                    </span>
                </div>
            </header>

            <!-- Area Isi Konten Utama -->
            <!-- Area Isi Konten Utama -->
            <main class="flex-1 p-4 sm:p-6 lg:p-8 max-w-7xl w-full mx-auto">

                <!-- GLOBAL FLASH ALERT SUKSES (Polesan UI Lebih Tegas & Jelas) -->
                @if (session('success'))
                    <div
                        class="mb-6 p-4 bg-emerald-50 border-2 border-emerald-500/30 rounded-2xl text-emerald-900 text-sm flex items-center justify-between gap-3 shadow-sm animate-fade-in">
                        <div class="flex items-center gap-3.5">
                            <div
                                class="w-10 h-10 rounded-xl bg-emerald-600 text-white flex items-center justify-center shrink-0 shadow-sm">
                                <i class="ti ti-circle-check text-xl"></i>
                            </div>
                            <div>
                                <span
                                    class="font-bold block text-xs uppercase tracking-wider text-emerald-700 mb-0.5">Berhasil!</span>
                                <span class="text-xs sm:text-sm font-semibold">{{ session('success') }}</span>
                            </div>
                        </div>
                        <button type="button" onclick="this.parentElement.remove();"
                            class="text-emerald-600 hover:text-emerald-900 p-1.5 rounded-lg hover:bg-emerald-100/60 transition-colors cursor-pointer">
                            <i class="ti ti-x text-base"></i>
                        </button>
                    </div>
                @endif

                <!-- GLOBAL FLASH ALERT ERROR -->
                @if (session('error'))
                    <div
                        class="mb-6 p-4 bg-rose-50 border-2 border-rose-500/30 rounded-2xl text-rose-900 text-sm flex items-center justify-between gap-3 shadow-sm animate-fade-in">
                        <div class="flex items-center gap-3.5">
                            <div
                                class="w-10 h-10 rounded-xl bg-rose-600 text-white flex items-center justify-center shrink-0 shadow-sm">
                                <i class="ti ti-alert-circle text-xl"></i>
                            </div>
                            <div>
                                <span
                                    class="font-bold block text-xs uppercase tracking-wider text-rose-700 mb-0.5">Perhatian!</span>
                                <span class="text-xs sm:text-sm font-semibold">{{ session('error') }}</span>
                            </div>
                        </div>
                        <button type="button" onclick="this.parentElement.remove();"
                            class="text-rose-600 hover:text-rose-900 p-1.5 rounded-lg hover:bg-rose-100/60 transition-colors cursor-pointer">
                            <i class="ti ti-x text-base"></i>
                        </button>
                    </div>
                @endif

                @yield('content')
            </main>

            <!-- Footer Panel Admin -->
            <footer
                class="bg-white border-t border-slate-200 py-4 px-6 text-center text-xs text-slate-500 font-medium">
                &copy; {{ date('Y') }} SMPN 3 Ciawigebang. Hak Cipta Dilindungi.
            </footer>
        </div>

    </div>

    <!-- ======================================================= -->
    <!-- GLOBAL MODAL KONFIRMASI HAPUS (Bisa dipakai di semua halaman) -->
    <!-- ======================================================= -->
    <div id="delete-modal"
        class="fixed inset-0 bg-slate-950/60 z-50 flex items-center justify-center p-4 opacity-0 pointer-events-none transition-opacity duration-200">
        <div class="bg-white rounded-3xl max-w-md w-full p-6 sm:p-7 shadow-2xl border border-slate-100 transform scale-95 transition-transform duration-200"
            id="delete-modal-box">
            <div
                class="w-12 h-12 rounded-2xl bg-rose-50 text-rose-600 flex items-center justify-center text-2xl mb-4 border border-rose-100">
                <i class="ti ti-alert-triangle"></i>
            </div>
            <h3 class="text-base sm:text-lg font-bold text-slate-900 mb-1">Konfirmasi Hapus Data</h3>
            <p class="text-xs sm:text-sm text-slate-500 mb-6" id="delete-modal-text">
                Apakah Anda yakin ingin menghapus data ini? Tindakan ini tidak dapat dibatalkan.
            </p>
            <div class="flex items-center justify-end gap-3">
                <button type="button" onclick="closeDeleteModal()"
                    class="px-4 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs sm:text-sm font-semibold rounded-xl transition-all cursor-pointer">
                    Batal
                </button>
                <form id="delete-modal-form" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                        class="px-4 py-2.5 bg-rose-600 hover:bg-rose-700 text-white text-xs sm:text-sm font-semibold rounded-xl shadow-sm transition-all cursor-pointer">
                        Ya, Hapus Sekarang
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- Script Global -->
    @push('scripts')
        <script>
            // 1. Script Toggle Sidebar Mobile
            const sidebarToggleBtn = document.getElementById('sidebar-toggle-btn');
            const sidebarCloseBtn = document.getElementById('sidebar-close-btn');
            const adminSidebar = document.getElementById('admin-sidebar');
            const sidebarOverlay = document.getElementById('sidebar-overlay');

            function toggleSidebar() {
                adminSidebar.classList.toggle('-translate-x-full');
                sidebarOverlay.classList.toggle('hidden');
                document.body.classList.toggle('overflow-hidden');
            }

            if (sidebarToggleBtn) sidebarToggleBtn.addEventListener('click', toggleSidebar);
            if (sidebarCloseBtn) sidebarCloseBtn.addEventListener('click', toggleSidebar);
            if (sidebarOverlay) sidebarOverlay.addEventListener('click', toggleSidebar);

            // 2. Script Live Clock & Tanggal Otomatis
            function updateClock() {
                const now = new Date();
                const optionsDate = {
                    weekday: 'long',
                    day: 'numeric',
                    month: 'long',
                    year: 'numeric'
                };
                const dateString = now.toLocaleDateString('id-ID', optionsDate);
                const timeString = now.toLocaleTimeString('id-ID', {
                    hour: '2-digit',
                    minute: '2-digit',
                    second: '2-digit'
                }).replace(/\./g, ':');

                const clockElement = document.getElementById('live-clock');
                if (clockElement) {
                    clockElement.textContent = `${dateString} | ${timeString}`;
                }
            }
            setInterval(updateClock, 1000);
            updateClock();

            // 3. Global Modal Konfirmasi Hapus (Bisa dipanggil dari halaman manapun)
            function openDeleteModal(deleteUrl, itemName) {
                const modal = document.getElementById('delete-modal');
                const modalBox = document.getElementById('delete-modal-box');
                const deleteForm = document.getElementById('delete-modal-form');
                const deleteText = document.getElementById('delete-modal-text');

                deleteForm.action = deleteUrl;
                deleteText.textContent = `Apakah Anda yakin ingin menghapus ${itemName}? Tindakan ini bersifat permanen.`;

                modal.classList.remove('opacity-0', 'pointer-events-none');
                modalBox.classList.remove('scale-95');
                modalBox.classList.add('scale-100');
            }

            function closeDeleteModal() {
                const modal = document.getElementById('delete-modal');
                const modalBox = document.getElementById('delete-modal-box');

                modal.classList.add('opacity-0', 'pointer-events-none');
                modalBox.classList.remove('scale-100');
                modalBox.classList.add('scale-95');
            }
        </script>
    @endpush

    @stack('scripts')

    {{-- Inisialisasi SortableJS untuk preview urutan --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var sortableEl = document.getElementById('sortable-preview');
            if (sortableEl && typeof Sortable !== 'undefined') {
                Sortable.create(sortableEl, {
                    animation: 200,
                    ghostClass: 'opacity-30',
                    chosenClass: 'ring-2 ring-blue-400 shadow-lg',
                    dragClass: 'rotate-2',
                    onEnd: function() {
                        // Ambil urutan baru
                        var items = sortableEl.querySelectorAll('.sort-item');
                        var order = [];
                        items.forEach(function(item, index) {
                            order.push(item.dataset.id);
                            // Update nomor visual
                            var numEl = item.querySelector('.sort-number');
                            if (numEl) numEl.textContent = index + 1;
                        });

                        // Kirim ke server via AJAX
                        var url = sortableEl.dataset.reorderUrl;
                        var token = document.querySelector('meta[name="csrf-token"]');
                        if (!token) {
                            token = document.querySelector('input[name="_token"]');
                            token = token ? token.value : '';
                        } else {
                            token = token.content;
                        }

                        fetch(url, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': token,
                                'Accept': 'application/json'
                            },
                            body: JSON.stringify({ order: order })
                        }).then(function(res) {
                            if (res.ok) {
                                var status = document.getElementById('sort-status');
                                if (status) {
                                    status.classList.remove('hidden');
                                    setTimeout(function() { status.classList.add('hidden'); }, 2000);
                                }
                            }
                        }).catch(function(err) {
                            console.error('Reorder failed:', err);
                        });
                    }
                });
            }
        });
    </script>
</body>

</html>
