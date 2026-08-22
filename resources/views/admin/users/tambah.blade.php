@extends('layouts.admin')

@section('title', 'Tambah Operator')
@section('header_title', 'Tambah Operator Baru')

@section('content')

    <div class="max-w-2xl mx-auto">
        <!-- Tombol Kembali yang Jelas -->
        <div class="mb-6">
            <a href="{{ route('admin.users.index') }}"
                class="inline-flex items-center gap-2 px-3.5 py-2 bg-white hover:bg-slate-50 border border-slate-200 text-slate-700 text-xs sm:text-sm font-semibold rounded-xl shadow-2xs transition-all">
                <i class="ti ti-arrow-left text-base text-slate-500" aria-hidden="true"></i>
                <span>Kembali ke Daftar Pengguna</span>
            </a>
        </div>

        <div class="bg-white rounded-2xl border border-slate-200 shadow-xs p-6 sm:p-8">

            <!-- Informasi Role -->
            <div
                class="flex items-start gap-3 mb-6 p-4 bg-amber-50/70 border border-amber-200 rounded-xl text-amber-800 text-xs sm:text-sm">
                <i class="ti ti-info-circle text-lg text-amber-600 shrink-0 mt-0.5" aria-hidden="true"></i>
                <div>
                    <span class="font-bold block mb-0.5">Informasi Hak Akses</span>
                    <span>Akun baru yang dibuat otomatis berstatus sebagai <strong>Operator</strong>. Role tidak dapat
                        diubah menjadi Admin melalui formulir ini.</span>
                </div>
            </div>

            <!-- Formulir Tambah Operator -->
            <form method="POST" action="{{ route('admin.users.store') }}" class="space-y-5" id="create-operator-form">
                @csrf

                <!-- Nama Lengkap -->
                <div>
                    <label for="name" class="block text-xs sm:text-sm font-bold text-slate-700 mb-1.5">Nama
                        Lengkap</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 text-slate-400">
                            <i class="ti ti-user text-base"></i>
                        </span>
                        <input type="text" id="name" name="name" value="{{ old('name') }}" required autofocus
                            placeholder="Contoh: Budi Santoso, S.Pd."
                            class="w-full pl-10 pr-4 py-2.5 bg-slate-50/50 border border-slate-300 rounded-xl text-sm focus:bg-white focus:ring-2 focus:ring-blue-500/20 focus:border-blue-600 outline-none transition-all">
                    </div>
                </div>

                <!-- Email -->
                <div>
                    <label for="email" class="block text-xs sm:text-sm font-bold text-slate-700 mb-1.5">Alamat Email
                        (Untuk Login)</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 text-slate-400">
                            <i class="ti ti-mail text-base"></i>
                        </span>
                        <input type="email" id="email" name="email" value="{{ old('email') }}" required
                            placeholder="operator@sekolah.sch.id"
                            class="w-full pl-10 pr-4 py-2.5 bg-slate-50/50 border border-slate-300 rounded-xl text-sm focus:bg-white focus:ring-2 focus:ring-blue-500/20 focus:border-blue-600 outline-none transition-all">
                    </div>
                    <p class="text-[11px] text-slate-400 mt-1">Pastikan email aktif dan belum pernah terdaftar sebelumnya.
                    </p>
                </div>

                <!-- Password -->
                <div>
                    <label for="password" class="block text-xs sm:text-sm font-bold text-slate-700 mb-1.5">Password</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 text-slate-400">
                            <i class="ti ti-lock text-base"></i>
                        </span>
                        <input type="password" id="password" name="password" required placeholder="Minimal 8 karakter"
                            class="w-full pl-10 pr-10 py-2.5 bg-slate-50/50 border border-slate-300 rounded-xl text-sm focus:bg-white focus:ring-2 focus:ring-blue-500/20 focus:border-blue-600 outline-none transition-all">
                        <button type="button" id="toggle-password"
                            class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-slate-400 hover:text-slate-600 cursor-pointer">
                            <i class="ti ti-eye text-base" id="eye-icon"></i>
                        </button>
                    </div>

                    <!-- Indikator Kekuatan Password Real-time -->
                    <div class="mt-2.5 space-y-1.5 bg-slate-50 p-3 rounded-xl border border-slate-200 text-xs">
                        <div class="flex items-center justify-between text-slate-500 mb-1">
                            <span class="font-semibold">Kekuatan Password:</span>
                            <span id="password-strength-text" class="font-bold text-slate-400">Belum diisi</span>
                        </div>
                        <div class="w-full bg-slate-200 h-1.5 rounded-full overflow-hidden">
                            <div id="password-strength-bar" class="bg-rose-500 h-full w-0 transition-all duration-300">
                            </div>
                        </div>
                        <ul class="grid grid-cols-2 gap-1 mt-2 text-[11px] text-slate-500">
                            <li id="rule-length" class="flex items-center gap-1.5"><i
                                    class="ti ti-circle text-slate-300"></i> Minimal 8 karakter</li>
                            <li id="rule-number" class="flex items-center gap-1.5"><i
                                    class="ti ti-circle text-slate-300"></i> Mengandung angka</li>
                        </ul>
                    </div>
                </div>

                <!-- Konfirmasi Password -->
                <div>
                    <label for="password_confirmation"
                        class="block text-xs sm:text-sm font-bold text-slate-700 mb-1.5">Konfirmasi Password</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 text-slate-400">
                            <i class="ti ti-lock-check text-base"></i>
                        </span>
                        <input type="password" id="password_confirmation" name="password_confirmation" required
                            placeholder="Ulangi password yang sama"
                            class="w-full pl-10 pr-4 py-2.5 bg-slate-50/50 border border-slate-300 rounded-xl text-sm focus:bg-white focus:ring-2 focus:ring-blue-500/20 focus:border-blue-600 outline-none transition-all">
                    </div>
                    <p id="password-match-warning" class="text-[11px] text-rose-500 mt-1 hidden">Password tidak sama!</p>
                </div>

                <!-- Tombol Submit -->
                <div class="pt-2">
                    <button type="submit"
                        class="w-full flex items-center justify-center gap-2 py-3 bg-blue-600 hover:bg-blue-700 text-white font-bold text-sm rounded-xl shadow-sm transition-all cursor-pointer">
                        <i class="ti ti-user-check text-base"></i>
                        <span>Simpan &amp; Buat Akun Operator</span>
                    </button>
                </div>
            </form>
        </div>
    </div>

@endsection
