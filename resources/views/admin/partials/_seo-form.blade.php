{{--
    Partial form SEO reusable — di-include di semua halaman create/edit admin.
    Menerima variabel $seo (nullable SeoMeta instance).

    Penggunaan:
    @include('admin.partials._seo-form', ['seo' => $model->seo ?? null])
--}}

@php
    $seo = $seo ?? null;
@endphp

{{-- Collapsible Card: Pengaturan SEO --}}
<div class="bg-white rounded-2xl border border-slate-200 shadow-xs overflow-hidden mt-6" x-data="{ open: false }" id="seo-settings-card">

    {{-- Header / Toggle Button --}}
    <button type="button"
        class="w-full flex items-center justify-between px-6 py-4 hover:bg-slate-50/80 transition-colors cursor-pointer"
        onclick="document.getElementById('seo-body').classList.toggle('hidden'); this.querySelector('.seo-chevron').classList.toggle('rotate-180');">
        <div class="flex items-center gap-3">
            <div class="w-9 h-9 rounded-xl bg-emerald-50 text-emerald-600 border border-emerald-200 flex items-center justify-center text-base shrink-0">
                <i class="ti ti-seo"></i>
            </div>
            <div class="text-left">
                <h3 class="text-sm font-bold text-slate-900">Pengaturan SEO</h3>
                <p class="text-[11px] text-slate-400 font-medium">Meta tags, Open Graph, dan pratinjau Google — opsional</p>
            </div>
        </div>
        <i class="ti ti-chevron-down text-slate-400 text-lg transition-transform duration-200 seo-chevron"></i>
    </button>

    {{-- Collapsible Body --}}
    <div id="seo-body" class="hidden border-t border-slate-100 px-6 py-5 space-y-5">

        {{-- Meta Title --}}
        <div>
            <label for="meta_title" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                Meta Title <span class="text-slate-400 font-normal normal-case">(Opsional)</span>
            </label>
            <input type="text" name="meta_title" id="meta_title"
                value="{{ old('meta_title', $seo->meta_title ?? '') }}"
                placeholder="Kosongkan untuk menggunakan judul konten secara otomatis"
                class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-slate-900 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 transition-all">
            @error('meta_title')
                <p class="text-rose-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Meta Description + Live Counter --}}
        <div>
            <label for="meta_description" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                Meta Description <span class="text-slate-400 font-normal normal-case">(Maks. 160 karakter)</span>
            </label>
            <textarea name="meta_description" id="meta_description" rows="3" maxlength="160"
                placeholder="Kosongkan untuk menggunakan ringkasan konten secara otomatis"
                oninput="document.getElementById('seo-char-count').textContent = this.value.length"
                class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-slate-900 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 transition-all">{{ old('meta_description', $seo->meta_description ?? '') }}</textarea>
            <div class="flex items-center justify-between mt-1.5">
                @error('meta_description')
                    <p class="text-rose-500 text-xs">{{ $message }}</p>
                @enderror
                <p class="text-[11px] text-slate-400 ml-auto">
                    <span id="seo-char-count">{{ strlen(old('meta_description', $seo->meta_description ?? '')) }}</span><span class="text-slate-300">/</span>160
                </p>
            </div>
        </div>

        {{-- Meta Keywords --}}
        <div>
            <label for="meta_keywords" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                Meta Keywords <span class="text-slate-400 font-normal normal-case">(Opsional, pisahkan dengan koma)</span>
            </label>
            <input type="text" name="meta_keywords" id="meta_keywords"
                value="{{ old('meta_keywords', $seo->meta_keywords ?? '') }}"
                placeholder="Contoh: smpn 3 ciawigebang, prestasi, ekstrakurikuler"
                class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-slate-900 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 transition-all">
            @error('meta_keywords')
                <p class="text-rose-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Grid: OG Image & Canonical URL --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            {{-- OG Image --}}
            <div>
                <label for="og_image" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                    Gambar OG <span class="text-slate-400 font-normal normal-case">(Opsional)</span>
                </label>
                <input type="file" name="og_image" id="og_image" accept="image/*"
                    class="w-full px-2.5 py-1.5 bg-slate-50/50 border border-slate-200 rounded-xl text-xs text-slate-600 file:mr-2 file:py-1 file:px-2.5 file:rounded-lg file:border-0 file:bg-emerald-50 file:text-emerald-700 file:text-xs file:font-semibold hover:file:bg-emerald-100 transition-all cursor-pointer">
                <p class="text-[10px] text-slate-400 mt-1">Gambar yang tampil saat di-share ke media sosial. Maks. 2MB.</p>
                @if ($seo && $seo->og_image)
                    <div class="mt-2 flex items-center gap-2">
                        <img src="{{ Storage::url($seo->og_image) }}" alt="OG Image" class="w-16 h-10 object-cover rounded-lg border border-slate-200">
                        <span class="text-[10px] text-emerald-600 font-semibold">Sudah diupload</span>
                    </div>
                @endif
                @error('og_image')
                    <p class="text-rose-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Canonical URL --}}
            <div>
                <label for="canonical_url" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                    Canonical URL <span class="text-slate-400 font-normal normal-case">(Opsional)</span>
                </label>
                <input type="url" name="canonical_url" id="canonical_url"
                    value="{{ old('canonical_url', $seo->canonical_url ?? '') }}"
                    placeholder="https://smpn3ciawigebang.sch.id/..."
                    class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-slate-900 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 transition-all">
                <p class="text-[10px] text-slate-400 mt-1">Kosongkan untuk menggunakan URL halaman saat ini.</p>
                @error('canonical_url')
                    <p class="text-rose-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
        </div>

        {{-- Separator --}}
        <div class="pt-2 border-t border-slate-100">
            <h4 class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-3 flex items-center gap-2">
                <i class="ti ti-search text-emerald-600"></i>
                Pratinjau Hasil Pencarian Google
            </h4>

            {{-- Google SERP Preview --}}
            <div class="bg-white border border-slate-200 rounded-xl p-4 space-y-1" id="seo-serp-preview">
                {{-- Title (biru) --}}
                <h3 id="serp-title" class="text-blue-700 text-base font-medium leading-snug truncate hover:underline cursor-pointer" style="font-family: Arial, sans-serif;">
                    {{ old('meta_title', $seo->meta_title ?? 'Judul halaman akan tampil di sini') }}
                </h3>
                {{-- URL (hijau) --}}
                <p id="serp-url" class="text-emerald-800 text-xs truncate" style="font-family: Arial, sans-serif;">
                    {{ old('canonical_url', $seo->canonical_url ?? url()->current()) }}
                </p>
                {{-- Description (abu) --}}
                <p id="serp-description" class="text-slate-600 text-sm leading-relaxed line-clamp-2" style="font-family: Arial, sans-serif;">
                    {{ old('meta_description', $seo->meta_description ?? 'Deskripsi meta akan tampil di sini. Maksimal 160 karakter.') }}
                </p>
            </div>
        </div>
    </div>
</div>

{{-- Script Live SERP Preview --}}
@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const titleInput = document.getElementById('meta_title');
    const descInput = document.getElementById('meta_description');
    const urlInput = document.getElementById('canonical_url');

    const serpTitle = document.getElementById('serp-title');
    const serpDesc = document.getElementById('serp-description');
    const serpUrl = document.getElementById('serp-url');

    if (titleInput && serpTitle) {
        titleInput.addEventListener('input', function() {
            serpTitle.textContent = this.value || 'Judul halaman akan tampil di sini';
        });
    }

    if (descInput && serpDesc) {
        descInput.addEventListener('input', function() {
            serpDesc.textContent = this.value || 'Deskripsi meta akan tampil di sini. Maksimal 160 karakter.';
        });
    }

    if (urlInput && serpUrl) {
        urlInput.addEventListener('input', function() {
            serpUrl.textContent = this.value || '{{ url()->current() }}';
        });
    }
});
</script>
@endpush
