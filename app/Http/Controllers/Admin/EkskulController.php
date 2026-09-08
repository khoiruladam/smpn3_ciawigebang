<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\SeoRequest;
use App\Models\Ekskul;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class EkskulController extends Controller
{
    public function index()
    {
        $ekskuls = Ekskul::orderBy('sort_order')->paginate(10);
        $orderPreview = Ekskul::orderBy('sort_order')->select(['id', 'name', 'sort_order'])->get();
        return view('admin.ekskul.index', compact('ekskuls', 'orderPreview'));
    }

    public function create()
    {
        return view('admin.ekskul.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'icon' => 'required|string',
            'category' => 'nullable|string|max:100',
            'short_description' => 'required|string|max:500',
            'description' => 'required|string',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:1024',
            'gallery.*' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:1024',
            'sort_order' => 'nullable|integer',
            'is_published' => 'nullable|boolean',
        ]);

        $validated['slug'] = Str::slug($validated['name']);
        $validated['is_published'] = $request->has('is_published');

        // Upload Cover
        if ($request->hasFile('cover_image')) {
            $validated['cover_image'] = $request->file('cover_image')->store('ekskuls/covers', 'public');
        }

        // Upload Galeri Foto (Maks 3)
        if ($request->hasFile('gallery')) {
            $galleryPaths = [];
            foreach ($request->file('gallery') as $file) {
                $galleryPaths[] = $file->store('ekskuls/gallery', 'public');
            }
            $validated['gallery'] = $galleryPaths; // Disimpan sebagai array JSON (pastikan model di-cast array)
        }

        $request->validate(SeoRequest::seoRules());

        $ekskul = Ekskul::create($validated);
        $ekskul->saveSeo($request);

        return redirect()->route('admin.ekskul.index')->with('success', 'Ekstrakurikuler baru berhasil ditambahkan.');
    }

    public function edit(Ekskul $ekskul)
    {
        $ekskul->load('seo');
        return view('admin.ekskul.edit', compact('ekskul'));
    }

    public function update(Request $request, Ekskul $ekskul)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'icon' => 'required|string',
            'category' => 'nullable|string|max:100',
            'short_description' => 'required|string|max:500',
            'description' => 'required|string',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:1024',
            'gallery.*' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:1024',
            'sort_order' => 'nullable|integer',
        ]);

        if ($request->filled('slug')) {
            $validated['slug'] = Str::slug($request->slug);
        } elseif (empty($ekskul->slug)) {
            $validated['slug'] = Str::slug($validated['name']);
        } else {
            unset($validated['slug']);
        }
        $validated['is_published'] = $request->has('is_published');

        // Update Cover
        if ($request->hasFile('cover_image')) {
            if ($ekskul->cover_image) {
                Storage::disk('public')->delete($ekskul->cover_image);
            }
            $validated['cover_image'] = $request->file('cover_image')->store('ekskuls/covers', 'public');
        }

        // Tambah Galeri Foto Baru tanpa menghapus yang lama
        if ($request->hasFile('gallery')) {
            $galleryPaths = is_array($ekskul->gallery) ? $ekskul->gallery : [];
            foreach ($request->file('gallery') as $file) {
                $galleryPaths[] = $file->store('ekskuls/gallery', 'public');
            }
            $validated['gallery'] = array_slice($galleryPaths, 0, 6); // Batasi maksimal misal 6 foto total di database
        }

        $request->validate(SeoRequest::seoRules());

        $ekskul->update($validated);
        $ekskul->saveSeo($request);

        return redirect()->route('admin.ekskul.index')->with('success', "Data Ekstrakurikuler {$ekskul->name} berhasil diperbarui.");
    }

    public function destroy(Ekskul $ekskul)
    {
        // Hapus cover
        if ($ekskul->cover_image) {
            Storage::disk('public')->delete($ekskul->cover_image);
        }

        // Hapus semua foto galeri
        if (is_array($ekskul->gallery)) {
            foreach ($ekskul->gallery as $path) {
                Storage::disk('public')->delete($path);
            }
        }

        $name = $ekskul->name;
        $ekskul->delete();

        return back()->with('success', "Ekstrakurikuler {$name} beserta seluruh fotonya berhasil dihapus.");
    }

    // Metode khusus untuk menghapus 1 foto dari array galeri saat di halaman edit
    public function destroyGallery(Ekskul $ekskul, $index)
    {
        $gallery = is_array($ekskul->gallery) ? $ekskul->gallery : [];

        if (isset($gallery[$index])) {
            Storage::disk('public')->delete($gallery[$index]);
            unset($gallery[$index]);

            // Re-index array dan simpan
            $ekskul->update(['gallery' => array_values($gallery)]);
        }

        return back()->with('success', 'Satu foto galeri berhasil dihapus.');
    }

    /**
     * Simpan urutan baru dari drag-and-drop.
     */
    public function reorder(Request $request)
    {
        $request->validate(['order' => 'required|array', 'order.*' => 'integer']);

        \Illuminate\Support\Facades\DB::transaction(function () use ($request) {
            foreach ($request->order as $index => $id) {
                Ekskul::where('id', $id)->update(['sort_order' => $index]);
            }
        });

        return response()->json(['success' => true]);
    }
}