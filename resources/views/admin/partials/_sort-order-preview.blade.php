{{--
    Komponen Preview Urutan Tampil + Drag-and-Drop
    
    Variabel yang dibutuhkan:
    - $orderPreview  : Collection items (minimal punya id + kolom judul)
    - $titleColumn   : string — nama kolom judul (misal 'name', 'title')
    - $reorderUrl    : string — URL endpoint POST untuk simpan urutan baru
--}}

@if(isset($orderPreview) && $orderPreview->count() > 0)
<div class="mb-6 bg-white border border-slate-200 rounded-2xl shadow-xs overflow-hidden">
    <div class="px-4 py-3 border-b border-slate-100 bg-slate-50/50 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2">
        <h3 class="text-xs font-bold text-slate-600 flex items-center gap-2 uppercase tracking-wider">
            <i class="ti ti-arrows-sort text-blue-600 text-base"></i>
            Preview Urutan Tampil
        </h3>
        <div class="flex items-center gap-2">
            <span id="sort-status" class="text-[10px] text-slate-400 hidden">
                <i class="ti ti-check text-emerald-500"></i> Tersimpan
            </span>
            <span class="text-[10px] text-slate-400 flex items-center gap-1">
                <i class="ti ti-grip-vertical text-slate-300"></i> Seret untuk mengubah urutan
            </span>
        </div>
    </div>

    <div class="p-3 sm:p-4">
        <div id="sortable-preview" class="flex flex-wrap gap-2" data-reorder-url="{{ $reorderUrl }}">
            @foreach($orderPreview as $index => $item)
                <div class="sort-item group flex items-center gap-1.5 pl-1.5 pr-3 py-1.5 bg-slate-50 hover:bg-blue-50 border border-slate-200 hover:border-blue-200 rounded-lg text-xs font-medium text-slate-700 cursor-grab active:cursor-grabbing transition-all duration-150"
                     data-id="{{ $item->id }}">
                    <span class="sort-number w-5 h-5 bg-blue-600 group-hover:bg-blue-700 text-white rounded-md flex items-center justify-center text-[10px] font-bold shrink-0 transition-colors">{{ $index + 1 }}</span>
                    <i class="ti ti-grip-vertical text-slate-300 group-hover:text-blue-400 text-sm shrink-0 transition-colors"></i>
                    <span class="truncate max-w-[140px]">{{ $item->{$titleColumn} }}</span>
                </div>
            @endforeach
        </div>
    </div>
</div>
@endif
