@extends('layouts.admin')

@section('content')
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-8">

        <!-- Header & Tombol Simpan Mengambang/Sticky di Atas -->
        <div
            class="flex flex-col sm:flex-row justify-between items-start sm:items-center border-b pb-5 gap-4 backdrop-blur-md sticky top-0 z-30 pt-2">
            <div>
                <h1 class="font-bold text-2xl text-slate-900">Pengaturan Sekolah</h1>
                <p class="text-xs sm:text-sm text-slate-500">Kelola identitas, konten beranda, profil, dan aset visual
                    website.</p>
            </div>
            <button type="submit" form="settings-form"
                class="px-6 py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-bold text-sm rounded-xl flex items-center gap-2 transition-all shadow-md shrink-0 cursor-pointer">
                <i class="ti ti-device-floppy text-lg"></i> Simpan Perubahan
            </button>
        </div>

        @if (session('success'))
            <div
                class="p-4 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-xl flex items-center gap-2 shadow-sm text-sm">
                <i class="ti ti-check text-lg"></i> {{ session('success') }}
            </div>
        @endif

        <form id="settings-form" action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data"
            class="space-y-6">
            @csrf
            @method('PUT')

            <!-- KELOMPOK 1: IDENTITAS & INFORMASI UTAMA -->
            <div class="bg-white p-6 sm:p-8 border border-slate-200 rounded-2xl shadow-sm space-y-6">
                <div class="border-b pb-4">
                    <h3 class="font-bold text-lg text-slate-900 flex items-center gap-2">
                        <i class="ti ti-school text-blue-600"></i> Identitas & Informasi Utama
                    </h3>
                    <p class="text-xs text-slate-500 mt-1">Logo, informasi kontak, dan Google Maps.</p>
                </div>

                <div class="space-y-5">
                    <!-- Logo Sekolah -->
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase mb-2">Logo Sekolah</label>
                        <div class="flex items-center gap-4">
                            <div
                                class="w-16 h-16 shrink-0 rounded-xl bg-slate-50 border border-slate-200 flex items-center justify-center overflow-hidden">
                                <img id="preview-logo" src="{{ setting('logo') ? Storage::url(setting('logo')) : '' }}"
                                    class="{{ setting('logo') ? '' : 'hidden' }} max-w-full max-h-full object-contain p-1">
                            </div>
                            <div class="flex-1">
                                <input type="file" name="logo" accept="image/*"
                                    onchange="processImage(event, 'preview-logo')"
                                    class="w-full text-xs text-slate-500 file:mr-3 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-blue-700 file:bg-blue-50 hover:file:bg-blue-100 cursor-pointer">
                                <p class="text-[10px] text-slate-400 mt-1.5">Max: 2MB. (Auto compress ke WebP)</p>
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Nama Sekolah</label>
                            <input type="text" name="school_name" value="{{ setting('school_name') }}"
                                class="w-full px-4 py-2.5 text-sm border border-slate-200 rounded-xl outline-none focus:border-blue-500">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Telepon</label>
                            <input type="text" name="footer_phone" value="{{ setting('footer_phone') }}"
                                class="w-full px-4 py-2.5 text-sm border border-slate-200 rounded-xl outline-none focus:border-blue-500">
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Alamat Sekolah</label>
                        <input type="text" name="footer_address" value="{{ setting('footer_address') }}"
                            class="w-full px-4 py-2.5 text-sm border border-slate-200 rounded-xl outline-none focus:border-blue-500">
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Email Resmi</label>
                            <input type="text" name="footer_email" value="{{ setting('footer_email') }}"
                                class="w-full px-4 py-2.5 text-sm border border-slate-200 rounded-xl outline-none focus:border-blue-500">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Jam Layanan
                                (Weekday)</label>
                            <input type="text" name="operational_weekday" value="{{ setting('operational_weekday') }}"
                                class="w-full px-4 py-2.5 text-sm border border-slate-200 rounded-xl outline-none focus:border-blue-500"
                                placeholder="Senin - Jumat (07.00 - 15.00)">
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Deskripsi Singkat
                            Footer</label>
                        <textarea name="footer_about" rows="2"
                            class="w-full px-4 py-2.5 text-sm border border-slate-200 rounded-xl outline-none focus:border-blue-500">{{ setting('footer_about') }}</textarea>
                    </div>

                    <!-- Google Maps -->
                    <div class="pt-2 border-t border-slate-100">
                        <label class="block text-xs font-bold text-slate-700 uppercase mb-1">
                            <i class="ti ti-map text-blue-600"></i> Google Maps Embed URL (Iframe Source)
                        </label>
                        <input type="text" name="footer_map_url" value="{{ setting('footer_map_url') }}"
                            class="w-full px-4 py-2.5 text-sm border border-slate-200 rounded-xl outline-none focus:border-blue-500"
                            placeholder="Contoh: https://www.google.com/maps/embed?pb=...">
                        <p class="text-[11px] text-slate-400 mt-1">Salin link di dalam atribut <code>src="..."</code> dari
                            Google Maps.</p>
                    </div>
                </div>
            </div>

            <!-- KELOMPOK 2: BERANDA (HERO SECTION) -->
            <div class="bg-white p-6 sm:p-8 border border-slate-200 rounded-2xl shadow-sm space-y-6">
                <div class="border-b pb-4">
                    <h3 class="font-bold text-lg text-slate-900 flex items-center gap-2">
                        <i class="ti ti-layout-board text-blue-600"></i> Beranda (Hero Section)
                    </h3>
                    <p class="text-xs text-slate-500 mt-1">Kontrol tampilan banner utama website.</p>
                </div>

                <div class="space-y-5">
                    <!-- Background Hero -->
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase mb-2">Background Hero
                            (Banner)</label>
                        <div
                            class="w-full h-40 rounded-xl bg-slate-50 border border-slate-200 flex items-center justify-center overflow-hidden mb-2 relative">
                            <img id="preview-hero" src="{{ setting('bg_hero') ? Storage::url(setting('bg_hero')) : '' }}"
                                class="{{ setting('bg_hero') ? '' : 'hidden' }} w-full h-full object-cover">
                            <span id="placeholder-hero"
                                class="{{ setting('bg_hero') ? 'hidden' : 'text-slate-400 text-xs' }}">Belum ada
                                gambar</span>
                        </div>
                        <input type="file" name="bg_hero" accept="image/*"
                            onchange="processImage(event, 'preview-hero', 'placeholder-hero')"
                            class="w-full text-xs text-slate-500 file:mr-3 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-blue-700 file:bg-blue-50 hover:file:bg-blue-100 cursor-pointer">
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Judul Baris 1</label>
                            <input type="text" name="hero_title_1" value="{{ setting('hero_title_1') }}"
                                class="w-full px-4 py-2.5 text-sm border border-slate-200 rounded-xl outline-none focus:border-blue-500">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Judul Baris 2 (Warna
                                Biru)</label>
                            <input type="text" name="hero_title_2" value="{{ setting('hero_title_2') }}"
                                class="w-full px-4 py-2.5 text-sm border border-slate-200 rounded-xl outline-none focus:border-blue-500">
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Teks Animasi Mengetik</label>
                        <textarea name="hero_description" rows="2"
                            class="w-full px-4 py-2.5 text-sm border border-slate-200 rounded-xl outline-none focus:border-blue-500">{{ setting('hero_description') }}</textarea>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div class="bg-slate-50 p-4 rounded-xl border space-y-2">
                            <label class="block text-xs font-bold text-slate-700 uppercase">Tombol 1</label>
                            <input type="text" name="hero_btn1_text" value="{{ setting('hero_btn1_text') }}"
                                class="w-full px-3 py-2 text-xs border rounded-lg bg-white outline-none"
                                placeholder="Teks Tombol (Mis: INFO PPDB)">
                            <input type="text" name="hero_btn1_link" value="{{ setting('hero_btn1_link') }}"
                                class="w-full px-3 py-2 text-xs border rounded-lg bg-white outline-none"
                                placeholder="Link (Mis: #ssk)">
                        </div>
                        <div class="bg-slate-50 p-4 rounded-xl border space-y-2">
                            <label class="block text-xs font-bold text-slate-700 uppercase">Tombol 2</label>
                            <input type="text" name="hero_btn2_text" value="{{ setting('hero_btn2_text') }}"
                                class="w-full px-3 py-2 text-xs border rounded-lg bg-white outline-none"
                                placeholder="Teks Tombol (Mis: JELAJAHI)">
                            <input type="text" name="hero_btn2_link" value="{{ setting('hero_btn2_link') }}"
                                class="w-full px-3 py-2 text-xs border rounded-lg bg-white outline-none"
                                placeholder="Link (Mis: #profil)">
                        </div>
                    </div>
                </div>
            </div>

            <!-- KELOMPOK 3: PROFIL & LANDASAN UTAMA (DINAMIS) -->
            <div class="bg-white p-6 sm:p-8 border border-slate-200 rounded-2xl shadow-sm space-y-6">
                <div class="border-b pb-4 flex items-center justify-between">
                    <div>
                        <h3 class="font-bold text-lg text-slate-900 flex items-center gap-2">
                            <i class="ti ti-building text-blue-600"></i> Profil & Landasan Utama (Visi, Misi, dll)
                        </h3>
                        <p class="text-xs text-slate-500 mt-1">Tambah, ubah, atau hapus kartu informasi profil pada halaman
                            beranda.</p>
                    </div>
                    <button type="button" onclick="addProfilRow()"
                        class="px-3.5 py-2 bg-blue-50 text-blue-700 text-xs font-bold rounded-xl hover:bg-blue-100 transition-all flex items-center gap-1 shrink-0">
                        <i class="ti ti-plus"></i> Tambah Poin
                    </button>
                </div>

                <div id="profil-container" class="space-y-4">
                    @php
                        $defaultProfil = setting('profil_points_data')
                            ? json_decode(setting('profil_points_data'), true)
                            : [
                                [
                                    'icon' => 'ti-target-arrow',
                                    'label' => 'Visi Sekolah',
                                    'text' =>
                                        'Terwujudnya peserta didik yang unggul dalam prestasi, berkarakter mulia, menguasai teknologi, dan berwawasan lingkungan.',
                                    'icon_bg' => 'bg-blue-50 text-blue-600 border-blue-100',
                                    'badge' => 'Fokus Utama',
                                    'keterangan' =>
                                        'Landasan utama arah pengembangan kurikulum dan pembinaan karakter di sekolah.',
                                ],
                                [
                                    'icon' => 'ti-list-check',
                                    'label' => 'Misi Sekolah',
                                    'text' =>
                                        'Menyelenggarakan pembelajaran inovatif berbasis TIK, menguatkan profil pelajar Pancasila, serta membangun sinergi dengan masyarakat.',
                                    'icon_bg' => 'bg-emerald-50 text-emerald-600 border-emerald-100',
                                    'badge' => 'Implementasi',
                                    'keterangan' =>
                                        'Langkah strategis harian untuk merealisasikan visi pendidikan melalui kegiatan akademik & non-akademik.',
                                ],
                                [
                                    'icon' => 'ti-award',
                                    'label' => 'Akreditasi A',
                                    'text' =>
                                        'Terakreditasi A (Unggul) oleh Badan Akreditasi Nasional Sekolah/Madrasah (BAN-S/M) dengan nilai mutu pendidikan tinggi.',
                                    'icon_bg' => 'bg-amber-50 text-amber-600 border-amber-100',
                                    'badge' => 'Standar Mutu',
                                    'keterangan' =>
                                        'Pengakuan resmi atas kualitas sarana, prasarana, pengajar, dan manajemen sekolah.',
                                ],
                            ];
                    @endphp

                    @foreach ($defaultProfil as $index => $p)
                        <div class="profil-row bg-slate-50 p-4 sm:p-5 rounded-2xl border border-slate-200 space-y-4">
                            <div class="flex items-center justify-between border-b border-slate-200 pb-3">
                                <span class="font-bold text-xs text-slate-700 uppercase tracking-wide">Kartu Profil
                                    #{{ $index + 1 }}</span>
                                <button type="button" onclick="this.closest('.profil-row').remove()"
                                    class="text-rose-600 hover:text-rose-800 text-xs font-semibold flex items-center gap-1 cursor-pointer">
                                    <i class="ti ti-trash"></i> Hapus Kartu
                                </button>
                            </div>
                            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                                <div>
                                    <label class="block text-xs font-bold text-slate-600 uppercase mb-1">Judul /
                                        Label</label>
                                    <input type="text" name="profil[{{ $index }}][label]"
                                        value="{{ $p['label'] }}"
                                        class="w-full px-3.5 py-2 text-xs border border-slate-200 rounded-xl bg-white outline-none focus:border-blue-500"
                                        placeholder="Visi Sekolah">
                                </div>
                                <div>
                                    <label class="block text-xs font-bold text-slate-600 uppercase mb-1">Badge (Label
                                        Kecil)</label>
                                    <input type="text" name="profil[{{ $index }}][badge]"
                                        value="{{ $p['badge'] }}"
                                        class="w-full px-3.5 py-2 text-xs border border-slate-200 rounded-xl bg-white outline-none focus:border-blue-500"
                                        placeholder="Fokus Utama">
                                </div>
                                <div>
                                    <label class="block text-xs font-bold text-slate-600 uppercase mb-1">Icon (Tabler
                                        Icons)</label>
                                    <input type="text" name="profil[{{ $index }}][icon]"
                                        value="{{ $p['icon'] }}"
                                        class="w-full px-3.5 py-2 text-xs border border-slate-200 rounded-xl bg-white outline-none focus:border-blue-500"
                                        placeholder="ti-target-arrow">
                                </div>
                            </div>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-xs font-bold text-slate-600 uppercase mb-1">Teks Deskripsi
                                        Utama</label>
                                    <textarea name="profil[{{ $index }}][text]" rows="3"
                                        class="w-full px-3.5 py-2 text-xs border border-slate-200 rounded-xl bg-white outline-none focus:border-blue-500">{{ $p['text'] }}</textarea>
                                </div>
                                <div>
                                    <label class="block text-xs font-bold text-slate-600 uppercase mb-1">Keterangan
                                        Tambahan (Bawah)</label>
                                    <textarea name="profil[{{ $index }}][keterangan]" rows="3"
                                        class="w-full px-3.5 py-2 text-xs border border-slate-200 rounded-xl bg-white outline-none focus:border-blue-500">{{ $p['keterangan'] }}</textarea>
                                </div>
                                <input type="hidden" name="profil[{{ $index }}][icon_bg]"
                                    value="{{ $p['icon_bg'] ?? 'bg-blue-50 text-blue-600 border-blue-100' }}">
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- KELOMPOK 4: FITUR UNGGULAN DINAMIS -->
            <div class="bg-white p-6 sm:p-8 border border-slate-200 rounded-2xl shadow-sm space-y-6">
                <div class="border-b pb-4 flex items-center justify-between">
                    <div>
                        <h3 class="font-bold text-lg text-slate-900 flex items-center gap-2">
                            <i class="ti ti-apps text-blue-600"></i> Fitur Unggulan
                        </h3>
                        <p class="text-xs text-slate-500 mt-1">Atur kotak fitur melayang di beranda.</p>
                    </div>
                    <div class="flex gap-2">
                        <a href="https://tabler.io/icons" target="_blank"
                            class="px-3 py-2 bg-slate-100 text-slate-700 text-xs font-bold rounded-xl hover:bg-slate-200 transition-all flex items-center gap-1">
                            <i class="ti ti-external-link"></i> Daftar Icon
                        </a>
                        <button type="button" onclick="addFeatureRow()"
                            class="px-3.5 py-2 bg-blue-50 text-blue-700 text-xs font-bold rounded-xl hover:bg-blue-100 transition-all flex items-center gap-1">
                            <i class="ti ti-plus"></i> Tambah Fitur
                        </button>
                    </div>
                </div>

                <div id="features-container" class="space-y-3">
                    @php
                        $defaultFeatures = setting('features_data')
                            ? json_decode(setting('features_data'), true)
                            : [
                                [
                                    'icon' => 'ti-device-laptop',
                                    'title' => 'Kelas Digital',
                                    'desc' => 'Pembelajaran TIK',
                                ],
                                ['icon' => 'ti-users', 'title' => 'Pengajar Kompeten', 'desc' => 'Guru berpengalaman'],
                                [
                                    'icon' => 'ti-shield-check',
                                    'title' => 'Lingkungan Aman',
                                    'desc' => 'Kondusif & ramah',
                                ],
                                [
                                    'icon' => 'ti-heart-handshake',
                                    'title' => 'Karakter Unggul',
                                    'desc' => 'Nilai Pancasila',
                                ],
                                ['icon' => 'ti-flask', 'title' => 'Lab Lengkap', 'desc' => 'IPA, Komputer & Bahasa'],
                            ];
                    @endphp

                    @foreach ($defaultFeatures as $index => $feat)
                        <div class="feature-row bg-slate-50 p-4 rounded-xl border border-slate-200 space-y-3">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-3">
                                    <div
                                        class="w-8 h-8 bg-white rounded-lg border border-slate-200 flex items-center justify-center text-blue-600 shadow-sm">
                                        <i id="prev-icon-{{ $index }}" class="ti {{ $feat['icon'] }}"></i>
                                    </div>
                                    <span class="font-bold text-xs text-slate-700">Kotak Fitur #{{ $index + 1 }}</span>
                                </div>
                                <button type="button" onclick="this.closest('.feature-row').remove()"
                                    class="text-rose-600 hover:text-rose-800 text-xs font-semibold flex items-center gap-1 cursor-pointer">
                                    <i class="ti ti-trash"></i> Hapus
                                </button>
                            </div>
                            <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                                <input type="text" name="features[{{ $index }}][icon]"
                                    id="input-icon-{{ $index }}"
                                    oninput="updateIconDisplay('input-icon-{{ $index }}', 'prev-icon-{{ $index }}')"
                                    value="{{ $feat['icon'] }}" placeholder="Icon (ti-device-laptop)"
                                    class="px-3.5 py-2 text-xs border border-slate-200 rounded-xl bg-white outline-none focus:border-blue-500">
                                <input type="text" name="features[{{ $index }}][title]"
                                    value="{{ $feat['title'] }}" placeholder="Judul Fitur"
                                    class="px-3.5 py-2 text-xs border border-slate-200 rounded-xl bg-white outline-none focus:border-blue-500">
                                <input type="text" name="features[{{ $index }}][desc]"
                                    value="{{ $feat['desc'] }}" placeholder="Deskripsi Singkat"
                                    class="px-3.5 py-2 text-xs border border-slate-200 rounded-xl bg-white outline-none focus:border-blue-500">
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- KELOMPOK 5: TAUTAN SOSIAL MEDIA -->
            <div class="bg-white p-6 sm:p-8 border border-slate-200 rounded-2xl shadow-sm space-y-6">
                <div class="border-b pb-4 flex items-center justify-between">
                    <div>
                        <h3 class="font-bold text-lg text-slate-900 flex items-center gap-2">
                            <i class="ti ti-share text-blue-600"></i> Tautan Sosial Media
                        </h3>
                        <p class="text-xs text-slate-500 mt-1">Atur tautan sosial media sekolah di bagian footer.</p>
                    </div>
                    <button type="button" onclick="addSocialRow()"
                        class="px-3.5 py-2 bg-blue-50 text-blue-700 text-xs font-bold rounded-xl hover:bg-blue-100 transition-all flex items-center gap-1">
                        <i class="ti ti-plus"></i> Tambah Sosmed
                    </button>
                </div>

                <div id="socials-container" class="space-y-3">
                    @php
                        $defaultSocials = setting('socials_data')
                            ? json_decode(setting('socials_data'), true)
                            : [
                                [
                                    'name' => 'Facebook',
                                    'icon' => 'ti-brand-facebook',
                                    'url' => setting('social_facebook', '#'),
                                ],
                                [
                                    'name' => 'Instagram',
                                    'icon' => 'ti-brand-instagram',
                                    'url' => setting('social_instagram', '#'),
                                ],
                                [
                                    'name' => 'YouTube',
                                    'icon' => 'ti-brand-youtube',
                                    'url' => setting('social_youtube', '#'),
                                ],
                            ];
                    @endphp

                    @foreach ($defaultSocials as $index => $soc)
                        <div class="social-row flex items-center gap-3 bg-slate-50 p-3 rounded-xl border border-slate-200">
                            <input type="text" name="socials[{{ $index }}][name]" value="{{ $soc['name'] }}"
                                placeholder="Nama (Mis: Facebook)"
                                class="w-1/4 px-3 py-2 text-xs border border-slate-200 rounded-xl bg-white outline-none focus:border-blue-500">
                            <input type="text" name="socials[{{ $index }}][icon]" value="{{ $soc['icon'] }}"
                                placeholder="Icon (ti-brand-...)"
                                class="w-1/4 px-3 py-2 text-xs border border-slate-200 rounded-xl bg-white outline-none focus:border-blue-500">
                            <input type="text" name="socials[{{ $index }}][url]" value="{{ $soc['url'] }}"
                                placeholder="URL Link"
                                class="flex-1 px-3 py-2 text-xs border border-slate-200 rounded-xl bg-white outline-none focus:border-blue-500">
                            <button type="button" onclick="this.closest('.social-row').remove()"
                                class="p-2 text-rose-600 hover:bg-rose-50 rounded-xl transition-all cursor-pointer">
                                <i class="ti ti-trash text-base"></i>
                            </button>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- KELOMPOK 6: LATAR BELAKANG (BACKGROUND) SECTION -->
            <div class="bg-white p-6 sm:p-8 border border-slate-200 rounded-2xl shadow-sm space-y-6">
                <div class="border-b pb-4">
                    <h3 class="font-bold text-lg text-slate-900 flex items-center gap-2">
                        <i class="ti ti-photo text-blue-600"></i> Latar Belakang (Background) Section
                    </h3>
                    <p class="text-xs text-slate-500 mt-1">Atur gambar latar belakang untuk halaman Login, SSK, Guru, dan
                        Ekskul.</p>
                </div>

                <div class="grid grid-cols-2 sm:grid-cols-5 gap-4">
                    <!-- BG Login -->
                    <div class="space-y-2">
                        <label class="block text-[11px] font-bold text-slate-700 uppercase text-center">BG Login</label>
                        <div
                            class="w-full aspect-video rounded-xl bg-slate-50 border border-slate-200 flex items-center justify-center overflow-hidden relative shadow-inner">
                            <img id="preview-login"
                                src="{{ setting('bg_login') ? Storage::url(setting('bg_login')) : '' }}"
                                class="{{ setting('bg_login') ? '' : 'hidden' }} w-full h-full object-cover">
                        </div>
                        <input type="file" name="bg_login" accept="image/*"
                            onchange="processImage(event, 'preview-login')"
                            class="w-full text-[10px] text-slate-500 file:mr-1 file:py-1 file:px-2 file:rounded file:border-0 file:bg-blue-50 file:text-blue-700 cursor-pointer">
                    </div>

                    <!-- Card Login Image -->
                    <div class="space-y-2">
                        <label class="block text-[11px] font-bold text-slate-700 uppercase text-center">Card Login</label>
                        <div
                            class="w-full aspect-video rounded-xl bg-slate-50 border border-slate-200 flex items-center justify-center overflow-hidden relative shadow-inner">
                            <img id="preview-login-card"
                                src="{{ setting('login_card_image') ? Storage::url(setting('login_card_image')) : '' }}"
                                class="{{ setting('login_card_image') ? '' : 'hidden' }} w-full h-full object-cover">
                        </div>
                        <input type="file" name="login_card_image" accept="image/*"
                            onchange="processImage(event, 'preview-login-card')"
                            class="w-full text-[10px] text-slate-500 file:mr-1 file:py-1 file:px-2 file:rounded file:border-0 file:bg-blue-50 file:text-blue-700 cursor-pointer">
                    </div>

                    <!-- BG SSK -->
                    <div class="space-y-2">
                        <label class="block text-[11px] font-bold text-slate-700 uppercase text-center">SSK</label>
                        <div
                            class="w-full aspect-video rounded-xl bg-slate-50 border border-slate-200 flex items-center justify-center overflow-hidden relative shadow-inner">
                            <img id="preview-ssk" src="{{ setting('bg_ssk') ? Storage::url(setting('bg_ssk')) : '' }}"
                                class="{{ setting('bg_ssk') ? '' : 'hidden' }} w-full h-full object-cover">
                        </div>
                        <input type="file" name="bg_ssk" accept="image/*"
                            onchange="processImage(event, 'preview-ssk')"
                            class="w-full text-[10px] text-slate-500 file:mr-1 file:py-1 file:px-2 file:rounded file:border-0 file:bg-blue-50 file:text-blue-700 cursor-pointer">
                    </div>

                    <!-- BG Guru -->
                    <div class="space-y-2">
                        <label class="block text-[11px] font-bold text-slate-700 uppercase text-center">Guru</label>
                        <div
                            class="w-full aspect-video rounded-xl bg-slate-50 border border-slate-200 flex items-center justify-center overflow-hidden relative shadow-inner">
                            <img id="preview-guru" src="{{ setting('bg_guru') ? Storage::url(setting('bg_guru')) : '' }}"
                                class="{{ setting('bg_guru') ? '' : 'hidden' }} w-full h-full object-cover">
                        </div>
                        <input type="file" name="bg_guru" accept="image/*"
                            onchange="processImage(event, 'preview-guru')"
                            class="w-full text-[10px] text-slate-500 file:mr-1 file:py-1 file:px-2 file:rounded file:border-0 file:bg-blue-50 file:text-blue-700 cursor-pointer">
                    </div>

                    <!-- BG Ekskul -->
                    <div class="space-y-2">
                        <label class="block text-[11px] font-bold text-slate-700 uppercase text-center">Ekskul</label>
                        <div
                            class="w-full aspect-video rounded-xl bg-slate-50 border border-slate-200 flex items-center justify-center overflow-hidden relative shadow-inner">
                            <img id="preview-ekskul"
                                src="{{ setting('bg_ekskul') ? Storage::url(setting('bg_ekskul')) : '' }}"
                                class="{{ setting('bg_ekskul') ? '' : 'hidden' }} w-full h-full object-cover">
                        </div>
                        <input type="file" name="bg_ekskul" accept="image/*"
                            onchange="processImage(event, 'preview-ekskul')"
                            class="w-full text-[10px] text-slate-500 file:mr-1 file:py-1 file:px-2 file:rounded file:border-0 file:bg-blue-50 file:text-blue-700 cursor-pointer">
                    </div>
                </div>
            </div>

        </form>
    </div>
@endsection

@push('scripts')
    <script>
        function updateIconDisplay(inputId, previewId) {
            const iconInput = document.getElementById(inputId);
            const iconPreview = document.getElementById(previewId);
            if (iconInput && iconPreview) {
                iconPreview.className = 'ti ' + iconInput.value;
            }
        }

        let profilIndex = {{ isset($defaultProfil) ? count($defaultProfil) : 3 }};

        function addProfilRow() {
            const container = document.getElementById('profil-container');
            const html = `
            <div class="profil-row bg-slate-50 p-4 sm:p-5 rounded-2xl border border-slate-200 space-y-4">
                <div class="flex items-center justify-between border-b border-slate-200 pb-3">
                    <span class="font-bold text-xs text-slate-700 uppercase tracking-wide">Kartu Profil Baru</span>
                    <button type="button" onclick="this.closest('.profil-row').remove()" class="text-rose-600 hover:text-rose-800 text-xs font-semibold flex items-center gap-1 cursor-pointer">
                        <i class="ti ti-trash"></i> Hapus Kartu
                    </button>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-slate-600 uppercase mb-1">Judul / Label</label>
                        <input type="text" name="profil[\${profilIndex}][label]" placeholder="Visi Sekolah" class="w-full px-3.5 py-2 text-xs border border-slate-200 rounded-xl bg-white outline-none focus:border-blue-500">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-600 uppercase mb-1">Badge (Label Kecil)</label>
                        <input type="text" name="profil[\${profilIndex}][badge]" placeholder="Fokus Utama" class="w-full px-3.5 py-2 text-xs border border-slate-200 rounded-xl bg-white outline-none focus:border-blue-500">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-600 uppercase mb-1">Icon (Tabler Icons)</label>
                        <input type="text" name="profil[\${profilIndex}][icon]" placeholder="ti-target-arrow" class="w-full px-3.5 py-2 text-xs border border-slate-200 rounded-xl bg-white outline-none focus:border-blue-500">
                    </div>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-slate-600 uppercase mb-1">Teks Deskripsi Utama</label>
                        <textarea name="profil[\${profilIndex}][text]" rows="3" placeholder="Deskripsi..." class="w-full px-3.5 py-2 text-xs border border-slate-200 rounded-xl bg-white outline-none focus:border-blue-500"></textarea>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-600 uppercase mb-1">Keterangan Tambahan (Bawah)</label>
                        <textarea name="profil[\${profilIndex}][keterangan]" rows="3" placeholder="Keterangan..." class="w-full px-3.5 py-2 text-xs border border-slate-200 rounded-xl bg-white outline-none focus:border-blue-500"></textarea>
                    </div>
                    <input type="hidden" name="profil[\${profilIndex}][icon_bg]" value="bg-blue-50 text-blue-600 border-blue-100">
                </div>
            </div>
        `;
            container.insertAdjacentHTML('beforeend', html);
            profilIndex++;
        }

        let featureIndex = {{ isset($defaultFeatures) ? count($defaultFeatures) : 5 }};

        function addFeatureRow() {
            const container = document.getElementById('features-container');
            const newId = 'feat-new-' + featureIndex;
            const html = `
            <div class="feature-row bg-slate-50 p-4 rounded-xl border border-slate-200 space-y-3">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 bg-white rounded-lg border border-slate-200 flex items-center justify-center text-blue-600 shadow-sm">
                            <i id="prev-icon-${newId}" class="ti ti-star"></i>
                        </div>
                        <span class="font-bold text-xs text-slate-700">Kotak Fitur Baru</span>
                    </div>
                    <button type="button" onclick="this.closest('.feature-row').remove()" class="text-rose-600 hover:text-rose-800 text-xs font-semibold flex items-center gap-1 cursor-pointer">
                        <i class="ti ti-trash"></i> Hapus
                    </button>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                    <input type="text" name="features[\${featureIndex}][icon]" id="input-icon-\${newId}"
                        oninput="updateIconDisplay('input-icon-\${newId}', 'prev-icon-\${newId}')"
                        placeholder="Icon (ti-device-laptop)" class="px-3.5 py-2 text-xs border border-slate-200 rounded-xl bg-white outline-none focus:border-blue-500">
                    <input type="text" name="features[\${featureIndex}][title]" placeholder="Judul Fitur" class="px-3.5 py-2 text-xs border border-slate-200 rounded-xl bg-white outline-none focus:border-blue-500">
                    <input type="text" name="features[\${featureIndex}][desc]" placeholder="Deskripsi Singkat" class="px-3.5 py-2 text-xs border border-slate-200 rounded-xl bg-white outline-none focus:border-blue-500">
                </div>
            </div>
        `;
            container.insertAdjacentHTML('beforeend', html);
            featureIndex++;
        }

        let socialIndex = {{ isset($defaultSocials) ? count($defaultSocials) : 3 }};

        function addSocialRow() {
            const container = document.getElementById('socials-container');
            const html = `
            <div class="social-row flex items-center gap-3 bg-slate-50 p-3 rounded-xl border border-slate-200">
                <input type="text" name="socials[\${socialIndex}][name]" placeholder="Nama (Mis: Twitter)" class="w-1/4 px-3 py-2 text-xs border border-slate-200 rounded-xl bg-white outline-none focus:border-blue-500">
                <input type="text" name="socials[\${socialIndex}][icon]" placeholder="Icon (ti-brand-...)" class="w-1/4 px-3 py-2 text-xs border border-slate-200 rounded-xl bg-white outline-none focus:border-blue-500">
                <input type="text" name="socials[\${socialIndex}][url]" placeholder="URL Link" class="flex-1 px-3 py-2 text-xs border border-slate-200 rounded-xl bg-white outline-none focus:border-blue-500">
                <button type="button" onclick="this.closest('.social-row').remove()" class="p-2 text-rose-600 hover:bg-rose-50 rounded-xl transition-all cursor-pointer"><i class="ti ti-trash text-base"></i></button>
            </div>
        `;
            container.insertAdjacentHTML('beforeend', html);
            socialIndex++;
        }
    </script>
@endpush
