<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Guru;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class GuruController extends Controller
{
    public function index()
    {
        $gurus = Guru::orderBy('sort_order', 'asc')->paginate(10);
        $orderPreview = Guru::orderBy('sort_order', 'asc')->select(['id', 'name', 'sort_order'])->get();
        return view('admin.guru.index', compact('gurus', 'orderPreview'));
    }

    public function create()
    {
        return view('admin.guru.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'jabatan' => 'required|string|max:255',
            'sub' => 'nullable|string|max:255',
            'category' => 'required|string|max:100',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:1024',
            'sort_order' => 'nullable|integer',
        ]);

        $data = $request->except('image');
        $data['is_published'] = $request->has('is_published') ? 1 : 0;

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('guru', 'public');
        }

        Guru::create($data);

        return redirect()->route('admin.guru.index')->with('success', 'Data guru/staff berhasil ditambahkan.');
    }

    public function edit(Guru $guru)
    {
        return view('admin.guru.edit', compact('guru'));
    }

    public function update(Request $request, Guru $guru)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'jabatan' => 'required|string|max:255',
            'sub' => 'nullable|string|max:255',
            'category' => 'required|string|max:100',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:1024',
            'sort_order' => 'nullable|integer',
        ]);

        $data = $request->except('image');
        $data['is_published'] = $request->has('is_published') ? 1 : 0;

        if ($request->hasFile('image')) {
            if ($guru->image && Storage::disk('public')->exists($guru->image)) {
                Storage::disk('public')->delete($guru->image);
            }
            $data['image'] = $request->file('image')->store('guru', 'public');
        }

        $guru->update($data);

        return redirect()->route('admin.guru.index')->with('success', 'Data guru/staff berhasil diperbarui.');
    }

    public function destroy(Guru $guru)
    {
        if ($guru->image && Storage::disk('public')->exists($guru->image)) {
            Storage::disk('public')->delete($guru->image);
        }

        $guru->delete();

        return redirect()->route('admin.guru.index')->with('success', 'Data guru/staff berhasil dihapus.');
    }

    /**
     * Simpan urutan baru dari drag-and-drop.
     */
    public function reorder(Request $request)
    {
        $request->validate(['order' => 'required|array', 'order.*' => 'integer']);

        \Illuminate\Support\Facades\DB::transaction(function () use ($request) {
            foreach ($request->order as $index => $id) {
                Guru::where('id', $id)->update(['sort_order' => $index]);
            }
        });

        return response()->json(['success' => true]);
    }
}