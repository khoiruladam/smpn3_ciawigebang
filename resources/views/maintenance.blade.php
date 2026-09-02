@extends('layouts.app')

@section('content')
    <div class="min-h-[60vh] flex flex-col items-center justify-center text-center p-8">
        <div class="w-20 h-20 bg-amber-100 text-amber-600 rounded-full flex items-center justify-center text-4xl mb-6">
            <i class="ti ti-tools"></i>
        </div>
        <h2 class="text-3xl font-bold text-slate-900 mb-2">Sedang Perbaikan</h2>
        <p class="text-slate-500 max-w-md mb-8">Fitur ini sedang kami bangun. Mohon tunggu update selanjutnya ya!</p>
        <a href="javascript:history.back()"
            class="px-6 py-3 bg-slate-900 text-white rounded-xl font-bold hover:bg-slate-800 transition-all">
            Kembali
        </a>
    </div>
@endsection
