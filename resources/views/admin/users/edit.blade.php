@extends('layouts.admin')

@section('title', 'Edit Pengguna')
@section('header_title', 'Edit Informasi Pengguna')

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

            <!-- Header Info Profil yang Diedit -->
            <div class="flex items-center gap-4 mb-6 pb-6 border-b border-slate-100">
                <div
                    class="w-12 h-12 rounded-2xl {{ $user->role === 'admin' ? 'bg-blue-50 text-blue-600 border border-blue-200' : 'bg-amber-50 text-amber-600 border border-amber-200' }} flex items-center justify-center font-bold text-lg shrink-0">
                    <i class="ti ti-user" aria-hidden="true"></i>
                </div>
                <div>
                    <div class="font-bold text-slate-900 text-base sm:text-lg">{{ $user->name }}</div>
                    <div class="flex items-center gap-2 mt-1">
                        <span class="text-xs text-slate-500">{{ $user->email }}</span>
                        <span
                            class="text-[10px] font-bold px-2 py-0.5 rounded-md {{ $user->role === 'admin' ? 'bg-blue-50 border border-blue-200 text-blue-700' : 'bg-amber-50 border border-amber-200 text-amber-700' }}">
                            {{ ucfirst($user->role) }}
                        </span>
                    </div>
                </div>
            </div>

            <!-- Formulir Edit Pengguna -->
            <form method="POST" action="{{ route('admin.users.update', $user) }}" class="space-y-5" id="edit-user-form">
                @csrf
                @method('PUT')

                <!-- Nama Lengkap -->
                <div>
                    <label for="name" class="block text-xs sm:text-sm font-bold text-slate-700 mb-1.5">Nama
                        Lengkap</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 text-slate-400">
                            <i class="ti ti-user text-base"></i>
                        </span>
                        <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}" required
                            autofocus
                            class="w-full pl-10 pr-4 py-2.5 bg-slate-50/50 border border-slate-300 rounded-xl text-sm focus:bg-white focus:ring-2 focus:ring-blue-500/20 focus:border-blue-600 outline-none transition-all">
                    </div>
                </div>

                <!-- Email -->
                <div>
                    <label for="email" class="block text-xs sm:text-sm font-bold text-slate-700 mb-1.5">Alamat
                        Email</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 text-slate-400">
                            <i class="ti ti-mail text-base"></i>
                        </span>
                        <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}"
                            required
                            class="w-full pl-10 pr-4 py-2.5 bg-slate-50/50 border border-slate-300 rounded-xl text-sm focus:bg-white focus:ring-2 focus:ring-blue-500/20 focus:border-blue-600 outline-none transition-all">
                    </div>
                </div>

                <div class="pt-2">
                    <div class="p-4 bg-slate-50 rounded-2xl border border-slate-200 space-y-4">
                        <div class="flex items-center gap-2 text-slate-700 font-bold text-xs sm:text-sm">
                            <i class="ti ti-lock-access text-blue-600 text-base"></i>
                            <span>Ubah Kata Sandi (Opsional)</span>
                        </div>
                        <p class="text-[11px] text-slate-500 -mt-2">Kosongkan bagian ini jika Anda tidak ingin mengganti
                            password akun.</p>

                        <!-- Password Baru -->
                        <div>
                            <label for="password" class="block text-xs font-semibold text-slate-700 mb-1">Password
                                Baru</label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 text-slate-400">
                                    <i class="ti ti-lock text-base"></i>
                                </span>
                                <input type="password" id="password" name="password" placeholder="Minimal 8 karakter"
                                    class="w-full pl-10 pr-10 py-2.5 bg-white border border-slate-300 rounded-xl text-sm focus:ring-2 focus:ring-blue-500/20 focus:border-blue-600 outline-none transition-all">
                                <button type="button" id="toggle-password"
                                    class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-slate-400 hover:text-slate-600 cursor-pointer">
                                    <i class="ti ti-eye text-base" id="eye-icon"></i>
                                </button>
                            </div>

                            <!-- Indikator Kekuatan Password Real-time -->
                            <div id="password-strength-container"
                                class="mt-2 space-y-1.5 bg-white p-2.5 rounded-xl border border-slate-200 text-xs hidden">
                                <div class="flex items-center justify-between text-slate-500 mb-1">
                                    <span class="font-semibold">Kekuatan Password:</span>
                                    <span id="password-strength-text" class="font-bold text-slate-400">Belum diisi</span>
                                </div>
                                <div class="w-full bg-slate-200 h-1.5 rounded-full overflow-hidden">
                                    <div id="password-strength-bar"
                                        class="bg-rose-500 h-full w-0 transition-all duration-300"></div>
                                </div>
                                <ul class="grid grid-cols-2 gap-1 mt-2 text-[11px] text-slate-500">
                                    <li id="rule-length" class="flex items-center gap-1.5"><i
                                            class="ti ti-circle text-slate-300"></i> Minimal 8 karakter</li>
                                    <li id="rule-number" class="flex items-center gap-1.5"><i
                                            class="ti ti-circle text-slate-300"></i> Mengandung angka</li>
                                </ul>
                            </div>
                        </div>

                        <!-- Konfirmasi Password Baru -->
                        <div>
                            <label for="password_confirmation"
                                class="block text-xs font-semibold text-slate-700 mb-1">Konfirmasi Password Baru</label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 text-slate-400">
                                    <i class="ti ti-lock-check text-base"></i>
                                </span>
                                <input type="password" id="password_confirmation" name="password_confirmation"
                                    placeholder="Ulangi password baru"
                                    class="w-full pl-10 pr-4 py-2.5 bg-white border border-slate-300 rounded-xl text-sm focus:ring-2 focus:ring-blue-500/20 focus:border-blue-600 outline-none transition-all">
                            </div>
                            <p id="password-match-warning" class="text-[11px] text-rose-500 mt-1 hidden">Password baru tidak
                                sama!</p>
                        </div>
                    </div>
                </div>

                <!-- Tombol Submit -->
                <div class="pt-2">
                    <button type="submit"
                        class="w-full flex items-center justify-center gap-2 py-3 bg-blue-600 hover:bg-blue-700 text-white font-bold text-sm rounded-xl shadow-sm transition-all cursor-pointer">
                        <i class="ti ti-device-floppy text-base"></i>
                        <span>Simpan Perubahan Akun</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
