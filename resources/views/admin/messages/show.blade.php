@extends('layouts.admin')

@section('title', 'Detail Pesan')
@section('header_title', 'Detail Pesan')

@section('content')

    <div class="max-w-2xl">
        <a href="{{ route('admin.messages.index') }}"
            class="inline-flex items-center gap-1.5 text-sm text-slate-500 hover:text-slate-700 mb-6">
            <i class="ti ti-arrow-left" aria-hidden="true"></i> Kembali ke pesan masuk
        </a>

        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 sm:p-8">
            <div class="flex items-start justify-between mb-6 pb-4 border-b border-slate-100">
                <div>
                    <div class="font-bold text-slate-900 text-lg">{{ $message->displayName() }}</div>
                    @if (!$message->is_anonymous && $message->email)
                        <div class="text-sm text-slate-500">{{ $message->email }}</div>
                    @endif
                    <div class="text-xs text-slate-400 mt-1">{{ $message->created_at->translatedFormat('d F Y, H:i') }} WIB
                    </div>
                </div>
                @if ($message->is_anonymous)
                    <span
                        class="text-xs font-semibold px-2.5 py-1 bg-slate-100 text-slate-500 rounded-full shrink-0">Anonim</span>
                @endif
            </div>

            <p class="text-slate-700 text-sm leading-relaxed whitespace-pre-line break-words">{{ $message->message }}</p>

            <div class="mt-8 pt-6 border-t border-slate-100 flex items-center gap-3">
                @if (!$message->is_anonymous && $message->email)
                    <a href="mailto:{{ e($message->email) }}"
                        class="inline-flex items-center gap-2 px-4 py-2.5 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold rounded-xl shadow-sm transition-all">
                        <i class="ti ti-mail" aria-hidden="true"></i> Balas via Email
                    </a>
                @endif

                <button type="button"
                    onclick="openDeleteModal('{{ route('admin.messages.destroy', $message) }}', 'pesan ini')"
                    class="inline-flex items-center gap-2 px-4 py-2.5 bg-rose-50 hover:bg-rose-600 text-rose-600 hover:text-white border border-rose-200 text-sm font-semibold rounded-xl transition-all cursor-pointer">
                    <i class="ti ti-trash" aria-hidden="true"></i> Hapus Pesan
                </button>
            </div>
        </div>
    </div>

@endsection
