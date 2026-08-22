@extends('layouts.admin')

@section('title', 'Manajemen Prestasi')
@section('header_title', 'Prestasi & Penghargaan')

@section('content')
    <div class="p-6 border-b border-slate-100 flex flex-col sm:flex-row items-center justify-between gap-4">
        <div>

        </div>
        <a href="{{ route('admin.prestasi.create') }}"
            class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold rounded-xl transition-colors">
            <i class="ti ti-plus"></i> Tambah Prestasi
        </a>
    </div>

    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50 text-slate-500 text-xs uppercase tracking-wider">
                        <th class="px-6 py-4 font-semibold border-b border-slate-200">Info Prestasi</th>
                        <th class="px-6 py-4 font-semibold border-b border-slate-200">Tahun</th>
                        <th class="px-6 py-4 font-semibold border-b border-slate-200">Urutan</th>
                        <th class="px-6 py-4 font-semibold border-b border-slate-200">Status</th>
                        <th class="px-6 py-4 font-semibold border-b border-slate-200 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse ($achievements as $item)
                        <tr class="hover:bg-slate-50 transition-colors">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div
                                        class="w-10 h-10 rounded-xl bg-amber-50 text-amber-600 border border-amber-100 flex items-center justify-center shrink-0">
                                        <i class="ti {{ $item->icon }} text-xl"></i>
                                    </div>
                                    <div>
                                        <p class="text-sm font-bold text-slate-900">{{ $item->title }}</p>
                                        <p class="text-xs text-slate-500">{{ $item->category ?? '-' }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-sm font-medium text-slate-700">{{ $item->year }}</td>
                            <td class="px-6 py-4 text-sm font-medium text-slate-700">{{ $item->sort_order }}</td>
                            <td class="px-6 py-4">
                                @if ($item->is_published)
                                    <span
                                        class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md bg-emerald-50 text-emerald-700 text-xs font-semibold border border-emerald-200">
                                        <i class="ti ti-check"></i> Tayang
                                    </span>
                                @else
                                    <span
                                        class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md bg-slate-100 text-slate-600 text-xs font-semibold border border-slate-200">
                                        <i class="ti ti-eye-off"></i> Draft
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('admin.prestasi.edit', $item) }}"
                                        class="w-8 h-8 rounded-lg bg-amber-50 text-amber-600 hover:bg-amber-100 flex items-center justify-center transition-colors">
                                        <i class="ti ti-edit"></i>
                                    </a>
                                    <button type="button"
                                        onclick="openDeleteModal('{{ route('admin.prestasi.destroy', $item) }}', '{{ $item->title }}')"
                                        class="w-8 h-8 rounded-lg bg-rose-50 text-rose-600 hover:bg-rose-100 flex items-center justify-center transition-colors cursor-pointer">
                                        <i class="ti ti-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-8 text-center text-sm text-slate-500">Belum ada data prestasi.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="p-4 border-t border-slate-100">
            {{ $achievements->links() }}
        </div>
    </div>

    <!-- Modal Konfirmasi Hapus -->
    <div id="delete-modal"
        class="fixed inset-0 z-50 flex items-center justify-center bg-slate-900/40 backdrop-blur-xs opacity-0 pointer-events-none transition-opacity duration-200">
        <div class="bg-white rounded-2xl border border-slate-200 shadow-xl max-w-sm w-full p-6 text-center transform scale-95 transition-transform duration-200"
            id="delete-modal-card">
            <div
                class="w-12 h-12 rounded-full bg-rose-50 text-rose-600 border border-rose-100 mx-auto flex items-center justify-center text-2xl mb-4">
                <i class="ti ti-alert-triangle"></i>
            </div>
            <h3 class="text-base font-bold text-slate-900 mb-1">Hapus Prestasi?</h3>
            <p id="delete-modal-text" class="text-xs text-slate-500 leading-relaxed mb-6">Apakah Anda yakin ingin menghapus
                data ini?</p>
            <div class="flex items-center gap-3">
                <button type="button" onclick="closeDeleteModal()"
                    class="flex-1 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-semibold rounded-xl cursor-pointer">Batal</button>
                <form id="delete-form-action" method="POST" class="flex-1">
                    @csrf @method('DELETE')
                    <button type="submit"
                        class="w-full py-2.5 bg-rose-600 hover:bg-rose-700 text-white text-xs font-semibold rounded-xl cursor-pointer">Ya,
                        Hapus</button>
                </form>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            const deleteModal = document.getElementById('delete-modal');
            const deleteModalCard = document.getElementById('delete-modal-card');
            const deleteFormAction = document.getElementById('delete-form-action');
            const deleteModalText = document.getElementById('delete-modal-text');

            function openDeleteModal(url, name) {
                deleteFormAction.action = url;
                deleteModalText.innerHTML = `Hapus prestasi <b>"${name}"</b>? Tindakan ini tidak dapat dibatalkan.`;
                deleteModal.classList.remove('opacity-0', 'pointer-events-none');
                deleteModalCard.classList.remove('scale-95');
                deleteModalCard.classList.add('scale-100');
            }

            function closeDeleteModal() {
                deleteModal.classList.add('opacity-0', 'pointer-events-none');
                deleteModalCard.classList.remove('scale-100');
                deleteModalCard.classList.add('scale-95');
            }
        </script>
    @endpush
@endsection
